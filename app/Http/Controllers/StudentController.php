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

    public function check(IINRequest $request)
    {
        $student = $this->student->getIIN($request->IIN);

        if (!is_null($student)) {
            $student->collectionToSession();
            return is_null(session('collection')->stud_vizit) ? view('email.index') :
                view('recovery.index', compact('student'));
        } else {
            session(['IIN' => $request->IIN]);
            return view('fullname')->with('message', config('app.iin_failed'));
        }

//        if ($request->has(['first_name', 'middle_name', 'last_name'])) {
//            $student = $this->student->getFullName($request->first_name, $request->middle_name, $request->last_name);
//            if (!is_null($student)) {
//                if (is_null($student->IIN)) {
//                    $student->IIN = session('IIN');
//                    $student->IIN_added_by = 2; //2 for student himself
//                    $student->save();
//                }
//                $student->collectionToSession();
//                return is_null(session('collection')->stud_vizit) ? view('email.index') : view('recovery.index');
//            } else {
//                return view('fullname')->with('message', config('app.name_failed'));
//            }
//        }
    }

    public function sendEmail(IINRequest $request)
    {
//        if ($request->has('email')) {
//            $email = $request->email;
            session('collection')->email = $request->email;
            session('collection')->save();
//        } elseif (!is_null(session('collection')->email)) {
//            $email = session('collection')->email;
//        }

        $password = $this->student->createPassword();
        session('collection')->stud_passwd = md5($password);
        session('collection')->save();
        session('collection')->stud_passwd = $password;

        Mail::to($request->email)->send(new CredentialsSent(session('collection')));

        return view('email.thanks');
    }
}
