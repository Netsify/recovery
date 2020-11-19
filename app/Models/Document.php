<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_id', 'path', 'name'
    ];

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
            'requested_email' => $email,
        ])->save();
    }
}
