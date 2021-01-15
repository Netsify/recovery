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

    /**
     * Return the student's full specialty.
     *
     * @return string
     */
    public function getFullSpecialty() : string
    {
        return "{$this->spec_shifr} {$this->spec_name}({$this->spec_year})";
    }

    /**
     * Return the student's specialty language.
     *
     * @return string
     */
    public function getLanguage() : string
    {
        return preg_match('<(каз)>ui', $this->spec_forma) ? 'kz' : 'ru';
    }
}
