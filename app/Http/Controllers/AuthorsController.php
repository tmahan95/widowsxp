<?php

namespace WidowsXP\Http\Controllers;

use Illuminate\Http\Request;
use WidowsXP\Http\Controllers\Controller;
use WidowsXP\Author;
use WidowsXP\Http\Requests\StoreAuthorRequest;

class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $authors = Author::paginate(5);
	    return view('authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAuthorRequest $request)
    {
	    Author::create($request->all());
	    return redirect()->route('authors.index')->with(['message' => 'Author added successfully']);
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
	    $author = Author::findOrFail($id);
	    return view('authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAuthorRequest $request, $id)
    {
	    $author = Author::findOrFail($id);
	    $author->update($request->all());
	    return redirect()->route('authors.index')->with(['message' => 'Author updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    $author = Author::findOrFail($id);
	    $author->delete();
	    return redirect()->route('authors.index')->with(['message' => 'Author deleted successfully']);
    }

    public function restore($id)
    {
		$author = Author::withTrashed()->findOrFail($id);
		$author->restore();
		return redirect()->route('authors.index')->with(['message' => 'Author recovered successfully']);
    }
}
