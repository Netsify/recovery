<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'IIN',
    ];

    public function checkIIN($IIN)
    {
        $this->where('IIN', $IIN)->get();
    }

    public function checkName($firstName, $middleName, $lastName)
    {
        $this->where('stud_fam', $firstName)->where('stud_name', $middleName)->where('stud_otch', $lastName)->get();
    }
}
