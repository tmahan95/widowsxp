<?php

namespace WidowsXP\Http\Controllers;

use WidowsXP\Monitors;
use Illuminate\Http\Request;

class MonitorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $log = Monitors::paginate(5);
	return view('monitors.index', compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \WidowsXP\Monitors  $monitors
     * @return \Illuminate\Http\Response
     */
    public function show(Monitors $monitors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \WidowsXP\Monitors  $monitors
     * @return \Illuminate\Http\Response
     */
    public function edit(Monitors $monitors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \WidowsXP\Monitors  $monitors
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Monitors $monitors)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \WidowsXP\Monitors  $monitors
     * @return \Illuminate\Http\Response
     */
    public function destroy(Monitors $monitors)
    {
        //
    }
public function apiCreate(Request $data) {
           /* $log = new Logs;

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
            */
            return Monitors::create([
            'compname' => $data['compname'],
            'monSerial' => $data['monSerial'],
            ]);
            $log->save();
#           return redirect()->route('logs.index', $user->id)->with(['message' => 'Update of user complete']);
    }

    public function searchMonitors(Request $request) {
        $q = $request->q;
        $mon = Monitors::select('compname','monSerial')->where('compname', 'LIKE', '%'.$q.'%')->orWhere('monSerial', 'LIKE', '%'.$q.'%')->distinct()->get();
#       $log = Logs::where('uname', 'LIKE', '%'.$q.'%')->get();
        if(count($mon) > 0)
                return view('monitors.index')->withDetails ($mon)->withQuery( $q );
        else
                return view('monitors.index')->withMessage('No Details Found. Try to search again!');
    }

  /*  public function searchLogUsers(Request $request){
        $q = $request->q;
        $log = Logs::select('compName','monSerial')->where('compName', 'LIKE', '%'.$q.'%')->orWhere('uname','LIKE','%'.$q.'%')->orWhere('compname', 'LIKE','%'.$q.'%')->orWhere('ipaddress', 'LIKE','%'.$q.'%')->orWhere('os_version', 'LIKE','%'.$q.'%')->orWhere('os_build', 'LIKE','%'.$q.'%')->orWhere('bios_version', 'LIKE','%'.$q.'%')->orWhere('bios_date', 'LIKE','%'.$q.'%')->orWhere('model', 'LIKE','%'.$q.'%')->orWhere('serial', 'LIKE','%'.$q.'%')->distinct()->orderBy('date','desc')->take(5)->get();
        if(count($log) > 0)
                return view('logs.index')->withDetails ($log)->withQuery( $q );
        else
                return view('logs.index')->withMessage('No Details Found. Try another serach or contact the site administrator');
    }*/
}
