<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function getIIN($IIN)
    {
        return $this->where('IIN', $IIN)->get();
    }

    public function getFullName($firstName, $middleName, $lastName)
    {
        return $this->where('stud_fam', $firstName)->where('stud_name', $middleName)->where('stud_otch', $lastName)->get();
    }
}
