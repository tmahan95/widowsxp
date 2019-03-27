<?php

namespace WidowsXP\Http\Controllers;

use WidowsXP\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	   #$programs = Program::get();
	   return view('programs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    return view('programs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    Program::create($request->all());
	    $programs = Program::get();
	    return view('programs.index', compact('programs'))->withMessage('Program created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \WidowsXP\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \WidowsXP\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \WidowsXP\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \WidowsXP\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
	    $program = Program::select('*')->where('compname','=',$program->compname);
	    $program->delete();
	    return redirect()->route('program.index')->withMessage('prog deleted');
    }

    public function apiDelete(Request $data) {
	    return Program::select('*')->where('compname', '=', $data['compname'])->delete();
    }
    public function apiDelete2(Request $data){
	   return Program::select('*')->where('compname','=',$data['compname'])->where('progname','=',$data['progname'])->delete();
    }

    public function apiCreate(Request $data) {
	    
	    return Program::create([
		    'compname' => $data['compname'],
		    'progname' => $data['progname'],
		    'version' => $data['version'],
	    ]);
    }
    public function apiCreate2(Request $data) {
	   $compname = $data['compname'];
	   $progname = $data['progname'];
	   $version = $data ['version'];
	   if (Program::where('compname', '=', $compname)->where('progname', '=', $progname)->exists()){
	   }
	   else {
		return Program::create([
		    'compname'=> $data['compname'],
                    'progname' => $data['progname'],
		    'version' => $data['version'],
		]);
	   }
 }

    public function searchProgs(Request $request) {
	$q = $request->q;
	$programs = Program::select('compname','progname','version')->where('compname', 'LIKE', '%'.$q.'%')->orWhere('progname','LIKE','%'.$q.'%')->orWhere('version', 'LIKE','%'.$q.'%')->orderBy('progname')->get();

	if( count($programs) > 0){
		return view('programs.index', compact('programs'))->with( 'q', $q );
	}
	else{
		return view('programs.index')->withMessage('No Details Found. Try to search again!');
	}
    }

    public function refinedProgSearch(Request $request){
	$q = $request->q;
	$programs = Program::select('compname','progname','version')->where('compname','like','%'.$q.'%')->orWhere('progname','like','%'.$q.'%')->orWhere('version','like','%'.$q.'%')->orderBy('progname')->get();

	if( count($programs) > 0){
		return view('programs.index', compact('programs'))->with( 'q', $q );
	}
	else{
		return view('programs.index')->withMessage('No Details Found. Try another serach or contact the site administrator');
	}
    }
    public function download(Request $request) {
        $headers = array(
                        "Content-type" => "text/csv",
                        "Content-Disposition" => "attachment; filename=logs.csv",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                        );
//      $logs = Logs::all()->toArray();
        $q = $request->q;

	$programs = Program::select('compname','progname','version')->where('compname','like','%'.$q.'%')->orWhere('progname','like','%'.$q.'%')->orWhere('version','like','%'.$q.'%')->orderBy('progname')->get()->toArray();

        $callback = function() use ($programs){
                $FH = fopen('php://output', 'w');

                foreach ($programs as $fields){
                        $fields = (array) $fields;
                        fputcsv($FH, ($fields));
                }
                fclose($FH);
        };

        return response()->stream($callback, 200, $headers);
    }
}
