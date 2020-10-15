<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use App\Http\Requests\FullNameRequest;
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

    public function checkIIN(IINRequest $request)
    {
        $student = $this->student->getIIN($request->IIN);

        if (!is_null($student)) {
            session(compact('student'));

            return is_null($student->stud_vizit) || is_null($student->email) ?
                redirect()->route('students.email') : redirect()->route('students.recovery_resend');
        } else {
            session(['IIN' => $request->IIN]);
            session()->flash('message', config('app.iin_failed'));

            return redirect()->route('students.fullname');
        }
    }

    public function checkFullName(FullNameRequest $request)
    {
        $params = [];
        foreach ($request->all() as $key => $value) {
            $params[$key] = kaz_translit(mb_convert_case($value, MB_CASE_TITLE, "UTF-8"));
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
            session(compact('student'));

            return is_null($student->stud_vizit) || is_null($student->email) ?
                redirect()->route('students.email') : redirect()->route('students.recovery_resend');
        } else {
            session()->flash('message', config('app.name_failed'));

            return redirect()->route('students.fullname');
        }
    }

    public function sendEmail(EmailRequest $request)
    {
        $password = $this->student->createPassword();
        if ($request->has('email')) {
            session('student')->email = $request->email;
        }
        session('student')->stud_passwd = $password;
        session('student')->stud_login = kaz_translit(session('student')->stud_login, true);
        Mail::to(session('student')->email)->send(new CredentialsSent(session('student')));
        session('student')->stud_passwd = md5($password);
        session('student')->save();

        return redirect()->route('students.email_thanks');
    }
}
