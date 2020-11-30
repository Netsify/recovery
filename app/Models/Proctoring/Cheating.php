<?php

namespace App\Models\Proctoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cheating extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'content', 'info', 'level', 'uploaded_at', 'cheating_type'];

    public $timestamps = false;
}
