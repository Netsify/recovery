<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stud_id', 'path', 'name'
    ];

    /**
     * Save a document.
     *
     * @param string $file
     * @return void
     */
    public function saveDocument($file)
    {
        $this->create([
            'stud_id' => session('collection')->stud_id,
            'path' => $file->store('passports', 'public'),
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
        ])->save();
    }
}
