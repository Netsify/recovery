<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * @var Document
     */
    private $document;

    /**
     * Create a new controller instance.
     *
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $documents = $this->document->with('student')->get();

        return view('admin.index', compact('documents'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
