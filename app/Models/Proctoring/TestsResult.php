<?php

namespace App\Models\Proctoring;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель для работы с результатами тестов
 *
 * @property integer $id
 * @property string $cheating_code - cheating code
 * @property Carbon $date_start - Дата начала экзамена
 * @property Carbon $date_end - Дата завершения экзамена
 *
 * Class TestsResult
 * @package App\Models\Proctoring
 */
class TestsResult extends Model
{
    use HasFactory;

    protected $table = 'kv_tests_results';

    public $timestamps = false;

    /**
     * Возвращает результат прокторинга
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function proctoringResult()
    {
        return $this->hasOne(ProctoringResult::class);
    }
}
