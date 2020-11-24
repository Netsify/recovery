<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use App\Http\Requests\FullNameRequest;
use App\Http\Requests\IINRequest;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use App\Mail\CredentialsSent;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

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

    public function index(): View
    {
        return view('iin');
    }

    public function recovery(): View
    {
        return view('recovery.index');
    }

    public function recoveryThanks(): View
    {
        return view('recovery.thanks');
    }

    public function emailThanks(): View
    {
        return view('email.thanks');
    }

    public function checkIIN(IINRequest $request): View
    {
        $student = $this->student->getByIIN($request->IIN);

        if (!is_null($student)) {
            session(compact('student'));

            $data = [
                'full_name' => $student->full_name,
                'group' => $student->getGroup(),
                'specialty' => $student->specialty->getFullSpecialty(),
                'education_form' => $student->educationform->name,
                'admission_year' => $student->stud_post,
                'disguised_email' => $student->disguiseEmail(),
                'IIN' => $request->IIN
            ];

            return is_null($student->stud_vizit) || is_null($student->email)
                ? view('email.index', $data)
                : view('recovery.resend', $data);
        } else {
            session(['IIN' => $request->IIN]);
            session()->flash('message', config('app.iin_failed'));

            return view('fullname');
        }
    }

    public function checkFullName(FullNameRequest $request): View
    {
        $params = [];
        foreach ($request->all() as $key => $value) {
            $params[$key] = kaz_translit(mb_convert_case($value, MB_CASE_TITLE, "UTF-8"));
        }

        $student = $this->student->getByFullName($params);

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

            $data = [
                'full_name' => $student->getFullName(),
                'group' => $student->getGroup(),
                'specialty' => $student->specialty()->getFullSpecialty(),
                'education_form' => $student->educationform()->name,
                'admission_year' => $student->stud_post,
                'disguised_email' => $student->disguiseEmail()
            ];

            return is_null($student->stud_vizit) || is_null($student->email) ?
                view('email.index', $data) :
                view('recovery.resend', $data);
        } else {
            session()->flash('message', config('app.name_failed'));

            return view('fullname');
        }
    }

    public function sendEmail(EmailRequest $request): RedirectResponse
    {
        $student = session('student');

        if ($request->has('email')) {
            $student->email = $request->email;
        }

        $password = $this->student->createPassword();

        $student->stud_login = kaz_translit($student->stud_login, true);

        $student->stud_passwd = $password;

        Mail::to($student->email)->send(new CredentialsSent($student));

        $student->stud_passwd = md5($password);

        $student->save();

        return redirect()->route('students.email_thanks');
    }
}
