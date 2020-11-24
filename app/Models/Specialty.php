<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'spec_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'specialnost';

    public function getFullSpecialty()
    {
        return "{$this->spec_shifr} {$this->spec_name}({$this->spec_year})";
    }

    public function getLanguage()
    {
        return preg_match('<(каз)>ui', $this->spec_forma) ? 'kz' : 'ru';
    }
}
