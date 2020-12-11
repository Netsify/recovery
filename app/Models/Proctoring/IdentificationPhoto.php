<?php

namespace App\Models\Proctoring;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Модель для работы с фотками студента на прокторинге
 *
 * @property integer $id
 * @property int $pk            - ИД мз системы прокторинга
 * @property int $student_id    - ИД студента
 * @property string $old_image  - Старая фотка
 * @property string $new_image  - Новая фотка
 * @property Carbon $created_at - Дата создания
 * @property Carbon $updated_at - Дата обновления
 * @property Carbon $deleted_at - Дата удаления
 *
 * Class IdentificationPhoto
 * @package App\Models\Proctoring
 */
class IdentificationPhoto extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string - Имя таблицы
     */
    protected $table = 'proctoring_identification_photos';

    protected $fillable = ['old_image', 'new_image'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'stud_id');
    }
}
