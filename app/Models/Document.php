<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'path', 'name', 'requested_email'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'stud_id');
    }

    /**
     * Save a document.
     *
     * @param string $file
     * @return void
     */
    public function saveDocument($file, $email)
    {
        $storedPath = $file->store('passports', 'public');

        $this->create([
            'student_id' => session('student')->stud_id,
            'path' => $storedPath,
            'name' => $file->getClientOriginalName(),
            'requested_email' => $email
        ])->save();
    }
}
