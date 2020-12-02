<?php

namespace App\Models\Proctoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheatingType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description_en'];
}
