<?php

namespace App\Models\Proctoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestsResult extends Model
{
    use HasFactory;

    protected $table = 'kv_tests_results';

    public $timestamps = false;

    public function proctoringResult()
    {
        return $this->hasOne(ProctoringResult::class);
    }
}
