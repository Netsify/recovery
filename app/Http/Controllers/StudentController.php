<?php

namespace App\Http\Controllers;

use App\Http\Requests\IINRequest;
use App\Models\Student;
use App\Mail\CredentialsSent;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{
    /**
     * @var Student
     */
    private $student;

    /**
     * Create a new controller instance.
     *
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('iin');
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

    public function check(IINRequest $request)
    {
        if ($request->has('IIN')) {
            $student = $this->student->getIIN($request->IIN);
            if ($student) {
                $student->collectionToSession();
                return view('email', compact('student'));
            } else {
                session()->put('IIN', $request->IIN);
                return view('fullname')->with('message', config('app.iin_failed'));
            }
        } elseif ($request->has(['first_name', 'middle_name', 'last_name'])) {
            $student = $this->student->getFullName($request->first_name, $request->middle_name, $request->last_name);
            if ($student) {
                $student->IIN = session('IIN');
                $student->collectionToSession()->save();
                return view('email', compact('student'));
            } else {
                return view('fullname')->with('message', config('app.name_failed'));
            }
        }
    }

    public function sendEmail(IINRequest $request)
    {
        if ($request->has('email')) {
            $email = $request->email;
            session('collection')->email = $email;
            session('collection')->save();
        } elseif (session('collection')->email) {
            $email = session('collection')->email;
        }

        $password = $this->student->createPassword();
        session('collection')->stud_passwd = md5($password);
        session('collection')->save();
        session('collection')->stud_passwd = $password;

        Mail::to($email)->send(new CredentialsSent(session('collection')));

        return view('thanks');
    }
}
