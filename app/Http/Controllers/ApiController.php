<?php

namespace WidowsXP\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{ 
	/*public function apiLogCreate(array $data) {
	    $log = new Logs;

	    $this->validate(request(), [
		    'date' => 'required',
		    'uname' => 'required',
		    'compname' => 'required',
		    'ipaddress' => 'required',
		    'os_version' => 'required',
		    'os_build' => 'required',
		    'bios_version' => 'required',
		    'bios_date' => 'required',
		    'model' => 'required',
		    'serial' => 'required',
	    ]);

	    $log->date = request('date');
	    $log->uname = request('uname');
	    $log->compname = request('compname');
	    $log->ipaddress = request('ipaddress');
	    $log->os_version = request('os_version');
	    $log->os_build = request('os_build');
	    $log->bios_version = request('bios_version');
	    $log->bios_date = request('bios_date');
	    $log->model = request('model');
	    $log->serial = request('serial');
	    
	    return Logs::create([
	    'date' => $data['date'],
	    'uname' => $data['uname'],
	    'compname' => $data['compname'],
	    'ipaddress' => $data['ipaddress'],
	    'os_version' => $data['os_version'],
	    'os_build' => $data['os_build'],
	    'bios_version' => $data['bios_version'],
	    'bios_date' => $data['bios_date'],
	    'model' => $data['model'],
	    'serial' => $data['serial'],
    ]);
	    #$log->save();
	    #	    return redirect()->route('logs.index', $user->id)->with(['message' => 'Update of user complete']);
	 
	}*/

	public function apiProgCreate(array $data) {
		
	    return Program::create([
		    'compname' => $data['compname'],
		    'progname' => $data['progname'],
		    'version' => $data['version'],
	    ]);
	}
}
