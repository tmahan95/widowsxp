<?php

namespace WidowsXP\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

	    public function user()
	    {
	    $users = DB::table('users')->where('email', \Auth::user()->email)->first();
	return view('updateUser', ['user' => $users]);
    }
}
