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

    public function apiCreate(Request $data) {
	    
	    return Program::create([
		    'compname' => $data['compname'],
		    'progname' => $data['progname'],
		    'version' => $data['version'],
	    ]);
    }

    public function searchProgs(Request $request) {
	$q = $request->q;
	$programs = Program::select('compname','progname','version')->where('compname', 'LIKE', '%'.$q.'%')->orWhere('progname','LIKE','%'.$q.'%')->orWhere('version', 'LIKE','%'.$q.'%')->orderBy('progname')->get();

	if( count($programs) > 0){
		return view('programs.index', compact('programs'))->withQuery( $q );
	}
	else{
		return view('programs.index')->withMessage('No Details Found. Try to search again!');
	}
    }

    public function refinedProgSearch(Request $request){
	$q = $request->q;
	$programs = Program::select('compname','progname','version')->where('compname','like','%'.$q.'%')->orWhere('progname','like','%'.$q.'%')->orWhere('version','like','%'.$q.'%')->orderBy('compname')->get();

	$balls = "omfg";

	if( count($programs) > 0){
		return view('programs.index', compact('programs'))->withQuery( $q );
	}
	else{
		return view('programs.index')->withMessage('No Details Found. Try another serach or contact the site administrator');
	}
    }
}
