<?php

namespace App\Models\Proctoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoType extends Model
{
    use HasFactory;

    protected $fillable = ['info_en', 'info_ru'];
}
