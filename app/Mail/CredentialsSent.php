<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Student;

class CredentialsSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The student instance.
     *
     * @var Student
     */
    public $student;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Student $student
     * @return void
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('notification@kineu.info', 'КИнЭУ им. М. Дулатова')
                    ->subject('Учётные данные от системы дистанционного обучения')
                    ->markdown('mails.credentials');
    }
}
