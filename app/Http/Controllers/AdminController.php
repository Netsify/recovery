<?php

namespace App\Http\Controllers;

use App\Models\EmailChangeRequest;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
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
    public function index(): View
    {
        $emailChangeRequests = EmailChangeRequest::with('student')->whereNull('accepted_at')->get();

        return view('admin.index', compact('emailChangeRequests'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  EmailChangeRequest $emailChangeRequest
     * @return RedirectResponse
     */
    public function update(Request $request, EmailChangeRequest $emailChangeRequest): RedirectResponse
    {
        $emailChangeRequest->email = $request->email;
        $emailChangeRequest->accepted_at = now();
        $emailChangeRequest->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EmailChangeRequest $emailChangeRequest
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(EmailChangeRequest $emailChangeRequest): RedirectResponse
    {
        $emailChangeRequest->delete();

        return back();
    }
}
