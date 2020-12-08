<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestEmail extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'email'
    ];

    /**
     * Return documents attached to the email change request
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'request_id', 'id');
    }

    /**
     * Return the email change request owner
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'stud_id', 'student_id');
    }
}