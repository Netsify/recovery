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

    public function index()
    {
        return view('iin');
    }

    public function fullname()
    {
        return view('fullname');
    }

    public function recovery()
    {
        return view('recovery.index');
    }

    public function recoveryResend()
    {
        return view('recovery.resend');
    }

    public function recoveryThanks()
    {
        return view('recovery.thanks');
    }

    public function email()
    {
        return view('email.index');
    }

    public function emailThanks()
    {
        return view('email.thanks');
    }

    public function checkIIN(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IIN' => 'digits:12',
        ]);

        if ($validator->fails()) {
            session()->flash('message', config('app.iin_validation_error'));

            return back();
        }

        $student = $this->student->getIIN($request->IIN);

        if (!is_null($student)) {
            $student->collectionToSession();

            return is_null(session('collection')->stud_vizit) || is_null(session('collection')->email) ?
                redirect()->route('students.email') :
                redirect()->route('students.recovery_resend')->with(compact('student'));
        } else {
            session(['IIN' => $request->IIN]);
            session()->flash('message', config('app.iin_failed'));

            return redirect()->route('students.fullname');
        }
    }

    public function checkFullName(Request $request)
    {
        $params = [];
        foreach ($request->all() as $key => $value) {
            $params[$key] = kaz_translit(mb_convert_case($value, MB_CASE_TITLE, "UTF-8"));
        }

        $validator = Validator::make($params, [
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'last_name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            session()->flash('message', config('app.fullname_validation_error'));

            return back();
        }

        $student = $this->student->getFullName($params['first_name'], $params['middle_name'], $params['last_name']);

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
                redirect()->route('students.email') :
                redirect()->route('students.recovery_resend')->with(compact('student'));
        } else {
            session()->flash('message', config('app.name_failed'));

            return redirect()->route('students.fullname');
        }
    }

    public function sendEmail(Request $request)
    {
        $password = $this->student->createPassword();

        if ($request->has('email')) {
            session('collection')->email = $request->email;
        }

        session('collection')->stud_passwd = md5($password);
        session('collection')->save();
        session('collection')->stud_passwd = $password;
        session('collection')->stud_login = kaz_translit(session('collection')->stud_login, true);

        Mail::to(session('collection')->email)->send(new CredentialsSent(session('collection')));

        return redirect()->route('students.email_thanks');
    }
}
