<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use App\Models\RequestEmail;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $email_requests = RequestEmail::with('student')->whereNull('accepted_at')->get();

        return view('admin.index', compact('email_requests'));
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
     * @return View
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
     * @return RedirectResponse
     */
    public function update(Request $request, RequestEmail $email_request)
    {
        $email_request->email = $request->email;
        $email_request->accepted_at = now();
        $email_request->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Student
     * @return RedirectResponse
     */
    public function destroy(RequestEmail $email_request)
    {
        $email_request->delete();

        return back();
    }
}
