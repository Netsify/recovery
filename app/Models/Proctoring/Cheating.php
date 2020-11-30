<?php

namespace App\Models\Proctoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cheating extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'content', 'info_type_id', 'level', 'uploaded_at', 'cheating_type_id'];

    public $timestamps = false;

    public function info()
    {
        return $this->hasOne(InfoType::class, 'id', 'info_type_id');
    }

    public function type()
    {
        return $this->hasOne(CheatingType::class, 'id', 'cheating_type_id');
    }
}
