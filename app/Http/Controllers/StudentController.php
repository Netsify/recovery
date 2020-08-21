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

    public function fullName()
    {
        return view('fullname');
    }

    public function recovery()
    {
        return view('recovery.index');
    }

    public function checkIIN(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IIN' => 'digits:12',
        ]);

        if ($validator->fails()) {
            return back()->with('message', config('app.iin_validation_error'));
        }

        $student = $this->student->getIIN($request->IIN);

        if (!is_null($student)) {
            $student->collectionToSession();
            return is_null(session('collection')->stud_vizit) ? view('email.index') :
                view('recovery.index', compact('student'));
//            return is_null(session('collection')->stud_vizit) ? redirect()->route('students.email') :
//                redirect()->route('students.recovery');
        } else {
            session(['IIN' => $request->IIN]);
            session(['message' => config('app.iin_failed')]);
            return view('fullname')->with('message', config('app.iin_failed'));
//            return redirect()->route('students.full_name');
        }
    }

    public function checkFullName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'string',
            'middle_name' => 'string',
            'last_name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->with('message', config('app.fullname_validation_error'));
        }

        $student = $this->student->getFullNameLong($request->first_name, $request->middle_name, $request->last_name) ??
            $this->student->getFullNameShort($request->first_name, $request->middle_name);

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
            return is_null(session('collection')->stud_vizit) || is_null(session('collection')->email) ?
                view('email.index') : view('recovery.index', compact('student'));
//            return is_null(session('collection')->stud_vizit) || is_null(session('collection')->email) ?
//                redirect()->route('students.email') : redirect()->route('students.recovery');
        } else {
            session(['message' => config('app.name_failed')]);
//            return redirect()->route('students.full_name');
            return view('fullname')->with('message', config('app.name_failed'));
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
