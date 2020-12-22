<?php

namespace App\Models\Proctoring;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс для работы с результатми прокторинга
 *
 * @property integer $id
 * @property integer $test_result_id - id из таблицы с результатами тестирования
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property integer $score - уровень доверия
 * @property string $stream_link - ссылка на видео
 * @property string $identification - ссылка на фото
 * @property int $is_valid - Статус после ручной проверки результатов прокторинга
 * @property Cheating[] $cheatings - Нарушения
 *
 * Class ProctoringResult
 * @package App\Models\Proctoring
 */
class ProctoringResult extends Model
{
    use HasFactory;

    protected $fillable = ['start_time', 'end_time', 'score', 'stream_uploaded', 'stream_link', 'identification'];

    public $timestamps = false;

    /**
     * Возвращает нарушения допущенные во время прохождения прокторинга
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cheatings()
    {
        return $this->hasMany(Cheating::class);
    }
}
