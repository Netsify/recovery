<?php

namespace App\Models\Proctoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProctoringResult extends Model
{
    use HasFactory;

    protected $fillable = ['start_time', 'end_time', 'score', 'stream_uploaded', 'stream_link'];

    public $timestamps = false;

    public function cheatings()
    {
        return $this->hasMany(Cheating::class);
    }
}
