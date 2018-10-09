<?php

namespace WidowsXP\Http\Controllers;

use Illuminate\Http\Request;
use WidowsXP\Http\Controllers\Controller;
use WidowsXP\User;
#use WidowsXP\Http\Requests\StoreUserRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $users = User::paginate(5);
	    return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $user = User::findOrFail($id);
	    return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
	    $user = User::findOrFail($id);
	    #$user->update($request->all());
	    #return redirect()->route('users.index')->with(['message' => 'User updated successfully']);
	    #conditional logic if email AND password are change simultaneously
	    if(request('email') != $user->email && !empty(request('password'))){

	    $this->validate(request(), [
		    'name' => 'required',
		    'email' => 'required|email|unique:users',
		    'password' => 'required|min:6|confirmed'
	    ]);

	    $user->name = request('name');
	    $user->email = request('email');
	    $user->password = bcrypt(request('password'));

	    $user->save();
	    return redirect()->route('users.edit', $user->id)->with(['message' => 'Update of user complete']);
	    }

	    #if only email is changing
	    elseif(request('email') != $user->email && empty(request('password'))){

	    $this->validate(request(), [
		    'name' => 'required',
		    'email' => 'required|email|unique:users'
	    ]);

	    $user->name = request('name');
	    $user->email = request('email');

	    $user->save();
	    return redirect()->route('users.edit', $user->id)->with(['message' => 'Update of user complete']);
	    }

	    #if only password is changing
	    elseif(!empty(request('password')) && request('email') == $user->email){
	    	
	    $this->validate(request(), [
		    'name' => 'required',
		    'password' => 'required|min:6|confirmed'
	    ]);

	    $user->name = request('name');
	    $user->password = bcrypt(request('password'));

	    $user->save();
	    return redirect()->route('users.edit', $user->id)->with(['message' => 'Update of user complete']);
	    }

	    #only name is changing
	    else {
	    $this->validate(request(), [
		    'name' => 'required'
	    ]);

	    $user->name = request('name');

	    $user->save();
	    return redirect()->route('users.edit', $user->id)->with(['message' => 'Update of user complete']);

	    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    $user = User::findOrFail($id);
	    $user->delete();
	    return redirect()->route('users.index')->with(['message' => 'User deleted successfully']);
    }

    public function restore($id)
    {
		$user = User::withTrashed()->findOrFail($id);
		$user->restore();
		return redirect()->route('users.index')->with(['message' => 'User recovered successfully']);
    }
}
