<?php

namespace WidowsXP\Http\Controllers;

use WidowsXP\Logs;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $logs = Logs::paginate(5);
	    return view('logs.index', compact('logs'));
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
     * @param  \WidowsXP\Logs  $logs
     * @return \Illuminate\Http\Response
     */
    public function show(Logs $logs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \WidowsXP\Logs  $logs
     * @return \Illuminate\Http\Response
     */
    public function edit(Logs $logs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \WidowsXP\Logs  $logs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Logs $logs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \WidowsXP\Logs  $logs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logs $logs)
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
	    $log->save();
#	    return redirect()->route('logs.index', $user->id)->with(['message' => 'Update of user complete']);
    }
}
