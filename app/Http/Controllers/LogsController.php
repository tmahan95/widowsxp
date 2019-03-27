<?php

namespace WidowsXP\Http\Controllers;

#use Illuminate\Support\Facades\DB;
use WidowsXP\Logs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
	    'date' => date('Y-m-d', strtotime($data['date'])),
	    'uname' => $data['uname'],
	    'compname' => $data['compname'],
	    'ipaddress' => $data['ipaddress'],
	    'os_version' => $data['os_version'],
	    'os_build' => $data['os_build'],
	    'bios_version' => $data['bios_version'],
	    'bios_date' => date('Y-m-d', strtotime($data['bios_date'])),
	    'model' => $data['model'],
	    'serial' => $data['serial'],
	    ]);
	    $log->save();
#	    return redirect()->route('logs.index', $user->id)->with(['message' => 'Update of user complete']);
    }


    public function searchLogs(Request $request) {
	$q = $request->q;
	$log = Logs::select('date','uname','compname','ipaddress','os_version','os_build','bios_version','bios_date','model','serial')->where('date', 'LIKE', '%'.$q.'%')->orWhere('uname','LIKE','%'.$q.'%')->orWhere('compname', 'LIKE','%'.$q.'%')->orWhere('ipaddress', 'LIKE','%'.$q.'%')->orWhere('os_version', 'LIKE','%'.$q.'%')->orWhere('os_build', 'LIKE','%'.$q.'%')->orWhere('bios_version', 'LIKE','%'.$q.'%')->orWhere('bios_date', 'LIKE','%'.$q.'%')->orWhere('model', 'LIKE','%'.$q.'%')->orWhere('serial', 'LIKE','%'.$q.'%')->distinct()->orderBy('date','desc')->get()->paginate(25);
#	$log = Logs::where('uname', 'LIKE', '%'.$q.'%')->get();
	if(count($log) > 0)
		return view('logs.index')->withDetails ($log)->withQuery( $q );
	else
		return view('logs.index')->withMessage('No Details Found. Try to search again!');
    }

    public function searchLogUsers(Request $request){
	$q = $request->q;
	session(['query' => $q]);
	$log = Logs::select('date','uname','compname','ipaddress','os_version','os_build','bios_version','bios_date','model','serial')->where('date', 'LIKE', '%'.$q.'%')->orWhere('uname','LIKE','%'.$q.'%')->orWhere('compname', 'LIKE','%'.$q.'%')->orWhere('ipaddress', 'LIKE','%'.$q.'%')->orWhere('os_version', 'LIKE','%'.$q.'%')->orWhere('os_build', 'LIKE','%'.$q.'%')->orWhere('bios_version', 'LIKE','%'.$q.'%')->orWhere('bios_date', 'LIKE','%'.$q.'%')->orWhere('model', 'LIKE','%'.$q.'%')->orWhere('serial', 'LIKE','%'.$q.'%')->distinct()->orderBy('date','desc')->get()->paginate(25);
	if(count($log) > 0)
		return view('logs.index')->withDetails ($log)->withQuery( $q );
	else
		return view('logs.index')->withMessage('No Details Found. Try another serach or contact the site administrator');
    }

    public function download(Request $request) {
	$headers = array(
			"Content-type" => "text/csv",
			"Content-Disposition" => "attachment; filename=logs.csv",
			"Pragma" => "no-cache",
			"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
			"Expires" => "0"
			);
//	$logs = Logs::all()->toArray();
	$q = $request->q;

	$log = Logs::select('date','uname','compname','ipaddress','os_version','os_build','bios_version','bios_date','model','serial')->where('date', 'LIKE', '%'.$q.'%')->orWhere('uname','LIKE','%'.$q.'%')->orWhere('compname', 'LIKE','%'.$q.'%')->orWhere('ipaddress', 'LIKE','%'.$q.'%')->orWhere('os_version', 'LIKE','%'.$q.'%')->orWhere('os_build', 'LIKE','%'.$q.'%')->orWhere('bios_version', 'LIKE','%'.$q.'%')->orWhere('bios_date', 'LIKE','%'.$q.'%')->orWhere('model', 'LIKE','%'.$q.'%')->orWhere('serial', 'LIKE','%'.$q.'%')->distinct()->orderBy('date','desc')->get()->toArray();

	$callback = function() use ($log){
		$FH = fopen('php://output', 'w');

		foreach ($log as $fields){
			$fields = (array) $fields;
			fputcsv($FH, ($fields));
	    	}
		fclose($FH);
	};

	return response()->stream($callback, 200, $headers);
    }
}
