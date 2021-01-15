<?php

namespace App\Models\Proctoring;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Класс нарушений
 *
 * @property int $id
 * @property string $image             - Изображени
 * @property string $content           - Содержимое
 * @property int $info_type_id         - ид типа информации
 * @property int $cheating_type_id     - ид типа нарушшения
 * @property int $proctoring_result_id - ид результата прокторинга
 * @property int $level                - Уровень доверия
 * @property Carbon $uploaded_at       - Когда загружен
 * @property InfoType $info            - Тип информации
 * @property CheatingType $type        - Тип нарушения
 * @property ProctoringResult $result  - Результат прокторринга
 * @property Carbon $deleted_at        - Дата удаления
 *
 * Class Cheating
 * @package App\Models\Proctoring
 */
class Cheating extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['image', 'content', 'info_type_id', 'level', 'uploaded_at', 'cheating_type_id'];

    public $timestamps = false;

    /**
     * тип информации
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function info()
    {
        return $this->hasOne(InfoType::class, 'id', 'info_type_id');
    }

    /**
     * тип нарушения
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne(CheatingType::class, 'id', 'cheating_type_id');
    }

    /**
     * результат прокторинга
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function result()
    {
        return $this->belongsTo(ProctoringResult::class);
    }
}
