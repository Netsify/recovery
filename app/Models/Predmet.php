<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Predmet extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'predmet';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'pred_id';
}
