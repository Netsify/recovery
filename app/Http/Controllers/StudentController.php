<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Mail\CredentialsSent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function checkIIN(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IIN' => 'required|digits:12',
        ]);

        if ($validator->fails()) {
            return view('iin')->with('message', config('app.iin_validation_error'));
        }

        $student = $this->student->getIIN($request->IIN);

        if (!is_null($student)) {
            $student->collectionToSession();
            return is_null(session('collection')->stud_vizit) ? view('email.index') :
                view('recovery.index', compact('student'));
        } else {
            session(['IIN' => $request->IIN]);
            return view('fullname')->with('message', config('app.iin_failed'));
        }
    }

    public function checkFullName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'last_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return view('fullname')->with('message', config('app.fullname_validation_error'));
        }

        $student = $this->student->getFullName($request->first_name, $request->middle_name, $request->last_name);

        if (!is_null($student)) {
            if (is_null($student->IIN)) {
                $student->IIN = session('IIN');

                /**
                 * IIN added by student himself
                 */
                $student->IIN_added_by = 2;

                $student->save();
            }
            $student->collectionToSession();
            return is_null(session('collection')->stud_vizit) ? view('email.index') :
                view('recovery.index', compact('student'));
        } else {
            return back()->with('message', config('app.name_failed'));
        }
    }

    public function sendEmail(Request $request)
    {
        $password = $this->student->createPassword();

        session('collection')->email = $request->email;
        session('collection')->stud_passwd = md5($password);
        session('collection')->save();
        session('collection')->stud_passwd = $password;

        Mail::to($request->email)->send(new CredentialsSent(session('collection')));

        return view('email.thanks');
    }
}
