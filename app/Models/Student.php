<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function saveInSession()
    {
        session()->put('collection', $this);

        return $this;
    }

    public function getIIN($IIN)
    {
        return $this->where('IIN', $IIN)->first()->saveInSession();
    }

    public function getFullName($firstName, $middleName, $lastName)
    {
        return $this->where('stud_fam', $firstName)->where('stud_name', $middleName)->where('stud_otch', $lastName)
            ->first()->saveInSession();
    }
}
