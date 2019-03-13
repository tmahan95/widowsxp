using Microsoft.Win32;
using System;
using System.Collections.Generic;
using System.Data;
using System.Diagnostics;
using System.IO;
using System.Linq;
using System.Management;
using System.Net;
using System.Net.NetworkInformation;
using System.ServiceProcess;
using System.Text;
using System.Text.RegularExpressions;

namespace WidowsXP
{
    public partial class MyNewService : ServiceBase
    {
        private bool executed = true;
        private int eventId = 100;
        private int eventNoServer = 101;
        private int eventSuccess = 102;
        private DateTime today = DateTime.Today;
        private DateTime nextRunDate = DateTime.Today.AddDays(+1);
        string monSerial = "";
        List<string> monSerialList = new List<string>();


        public MyNewService()
        {
            InitializeComponent();

            eventLog1 = new System.Diagnostics.EventLog();

            if (!System.Diagnostics.EventLog.SourceExists("WidowsXP Service"))
            {
                System.Diagnostics.EventLog.CreateEventSource("WidowsXP Service", "WidowsXP");
            }
            eventLog1.Source = "WidowsXP Service";
            eventLog1.Log = "WidowsXP";
        }

        protected override void OnStart(string[] args)
        {
            eventLog1.WriteEntry("In OnStart");
            //Setup a timer to trigger every minute, this calls another method which I'll use for monitoring event logs
            //commenting this out, this will trigger OnTimer every 60 seconds
            System.Timers.Timer timer = new System.Timers.Timer
            {
                Interval = 60000 * 5 // 5 Minutes
            };
            timer.Elapsed += new System.Timers.ElapsedEventHandler(this.OnTimer);
            timer.Start();
            executed = false;

        }

        protected override void OnStop()
        {
            eventLog1.WriteEntry("In OnStop");
        }

        private void eventLog1_EntryWritten(object sender, EntryWrittenEventArgs e)
        {

        }

        private void OnTimer(object sender, System.Timers.ElapsedEventArgs args)
        {
            today = DateTime.Today;
            //Compares two dates, left is today, right is tomorrow. I only want to execute this once a day.
            if (today < nextRunDate)
            {
                if (executed == false)
                {
                    //Checks to see if the computer can connect to FS2. IF it can't see FS2, there's no point in running the widows method.
                    Ping ping = new Ping();
                    try
                    {
                        PingReply pingReply = ping.Send("fs2");
                        //If you see fs2, call Widows()
                        if (pingReply.Status == IPStatus.Success)
                        {
                            //Does all the inventory work.
                            Widows();
                        }
                        else
                        {
                            eventLog1.WriteEntry("I couldn't connect to fs2, I'll run again within 5 minutes.", EventLogEntryType.Warning, eventNoServer);
                        }
                    }
                    catch
                    {
                    }

                }

            }
            else
            {
                executed = false;
                nextRunDate = DateTime.Today.AddDays(+1);
            }

            eventLog1.WriteEntry("OnTimer method called.", EventLogEntryType.Information, eventId);
        }

        private void Widows()
        {
            try
            {
                /*********This whole block is for user/computer info********************************************/
                string date = "invalid";
                string userName = "invalid";
                string hostName = "invalid";
                string localIP = "invalid";
                string osName = "invalid";
                string osVersion = "invalid";
                string biosVersion = "invalid";
                string biosDate = "invalid";
                string model = "invalid";
                string serial = "invalid";

                //Get Shell serial number and BIOS Version
                ManagementObjectSearcher ser = new ManagementObjectSearcher("SELECT SerialNumber, SMBIOSBIOSVersion, ReleaseDate from Win32_BIOS");

                //breakout properties and write to console
                ManagementObjectCollection information = ser.Get();
                foreach (ManagementObject obj in information)
                {
                    foreach (PropertyData data in obj.Properties)
                    {
                        if (data.Name == "SerialNumber")
                        {
                            serial = data.Value.ToString();
                        }
                        else if (data.Name == "SMBIOSBIOSVersion")
                        {
                            biosVersion = data.Value.ToString();
                        }
                        else if (data.Name == "ReleaseDate")
                        {
                            DateTime biosDate1 = ManagementDateTimeConverter.ToDateTime(data.Value.ToString());
                            biosDate = biosDate1.ToString("d");
                        }
                    }
                }

                //Get Computername and Model
                ManagementObjectSearcher sysinfo = new ManagementObjectSearcher("Select Name, Model, UserName from win32_computersystem");
                ManagementObjectCollection sysinfocollection = sysinfo.Get();
                foreach (ManagementObject obj in sysinfocollection)
                {
                    foreach (PropertyData data in obj.Properties)
                    {
                        if (data.Name == "Name")
                        {
                            hostName = data.Value.ToString();
                        }
                        else if (data.Name == "Model")
                        {
                            model = data.Value.ToString();
                        }
                        else if (data.Name == "UserName")
                        {
                            userName = data.Value.ToString();
                            userName = Regex.Replace(userName, @"^
                                                           [^\\]* # Match 0 or more characters except underscore
                                                           \\     # Match the underscore", "", RegexOptions.IgnorePatternWhitespace);
                        }
                    }
                }

                //Get OS Version and OS Name
                ManagementObjectSearcher osinfo = new ManagementObjectSearcher("Select Version, Caption from win32_OperatingSystem");
                ManagementObjectCollection osinfocollection = osinfo.Get();
                foreach (ManagementObject obj in osinfocollection)
                {
                    foreach (PropertyData data in obj.Properties)
                    {
                        if (data.Name == "Version")
                        {
                            osVersion = data.Value.ToString();
                        }
                        else if (data.Name == "Caption")
                        {
                            osName = data.Value.ToString();
                        }
                    }
                }

                //Get IP address
                IPAddress[] localIPs = Dns.GetHostAddresses(Dns.GetHostName());

                localIP = localIPs[0].ToString();

                //get date
                date = System.DateTime.Today.ToShortDateString();

                //write all the stuff to csv
                string filepath = @"\\fs2\it\installs\timmy\InventoryProject\WidowsXP\Test_CSVs\derp.csv";
                //For TESTING ONLY
                //string filepath = @"c:\derp.csv"; 

                StringBuilder csv = new StringBuilder();
                var newLine = string.Format("{0},{1},{2},{3},{4},{5},{6},{7},{8},{9}", date, userName, hostName, localIP, osName, osVersion, biosVersion, biosDate, model, serial);
                csv.AppendLine(newLine);
                File.AppendAllText(filepath, csv.ToString());

                /***************************************This is for Programs and stuff************************************/

                List<string> progs = new List<string>();
                string registry_key = @"SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall";

                using (RegistryKey key = Registry.LocalMachine.OpenSubKey(registry_key))
                {
                    foreach (string subkey_name in key.GetSubKeyNames())
                    {
                        using (RegistryKey subkey = key.OpenSubKey(subkey_name))
                        {
                            if (subkey.GetValue("DisplayName") != null)
                            {
                                progs.Add(hostName + ", " + subkey.GetValue("DisplayName") + ", " + subkey.GetValue("DisplayVersion"));
                            }
                        }
                    }
                }
                //sort em
                progs = progs.OrderBy(x => x).ToList();

                //write em out to a file for pickup
                csv = new StringBuilder();

                //change filepath for programs list.
                filepath = @"\\fs2\it\installs\timmy\InventoryProject\WidowsXP\Test_CSVs\ProgramLists\" + hostName + ".csv";

                //gotta get hostname on the first line for Widows digest
                File.WriteAllText(filepath, hostName + Environment.NewLine);
                foreach (string derp in progs)
                {
                    File.AppendAllText(filepath, derp + Environment.NewLine);
                }

                //Monitor info gathering ##################################################################################
                //########This is for getting monitor info#######################

                ManagementObjectSearcher searcher = new ManagementObjectSearcher("root\\WMI", "SELECT * FROM WMIMonitorID");
                foreach (ManagementObject obj in searcher.Get())
                {
                    foreach (var prop in obj.Properties)
                    {
                        if (prop.Name == "SerialNumberID")
                        {
                            monSerial = "";
                            foreach (char c in (UInt16[])prop.Value)
                            {
                                if (c != '\0')
                                {
                                    monSerial = monSerial + c;
                                }
                            }
                        }
                    }
                    if (!(string.IsNullOrEmpty(monSerial)) && monSerial != "0")
                    {
                        monSerialList.Add(hostName + ", " + monSerial);
                    }
                    //set monSerial and monManufacturer if one or the other is blank or null (don't want those in the database)
                    else
                    {
                        monSerial = "";
                    }
                }
                filepath = @"\\fs2\it\Installs\TIMMY\InventoryProject\Widowsxp\Test_CSVs\Monitors\" + hostName + ".csv";

                if (monSerialList.Count != 0)
                {
                    foreach (string derp in monSerialList)
                    {
                        File.AppendAllText(filepath, derp + Environment.NewLine);
                    }
                }

                executed = true;
                eventLog1.WriteEntry("Data collection succeeded.", EventLogEntryType.Information, eventSuccess);
            }
            catch
            {
                eventLog1.WriteEntry("Inventory Data Collection failed.", EventLogEntryType.Error, eventNoServer);
            }
        }
    }
}
