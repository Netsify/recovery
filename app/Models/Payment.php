<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Оплата студентов
 *
 * @property int $id
 * @property int $student_id - ИД студента
 * @property int $assessed - Начисслено
 * @property int $discount - Скидка
 * @property int $payment
 * @property int $obp
 * @property int $percent - Процент оплаты
 * @property int $uep - Недоплата
 * @property int $ubp - Недоплата
 * @property Carbon $created_at - Дата
 *
 *
 * Class Payment
 * @package App\Models
 */
class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
}
