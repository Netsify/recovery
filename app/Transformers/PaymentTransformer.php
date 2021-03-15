<?php

namespace App\Transformers;
use App\Models\Payment;
use App\Models\Proctoring\IdentificationPhoto;

/**
 * Трансформирует двнные по оплате студентов в массив
 * Class PaymentTransformer
 * @package App\Transformers
 */
class PaymentTransformer
{
    /**
     * Трансформирует оплату в массив
     *
     * @param Payment $payment
     * @return array
     */
    public static function oneToArray(Payment $payment) : array
    {
        return [
            'student_id' => $payment->student_id,
            'assesned'   => $payment->assessed,
            'discount'   => $payment->discount,
            'payment'    => $payment->payment,
            'obp'        => $payment->obp,
            'percent'    => $payment->percent,
            'uep'        => $payment->uep,
            'ubp'        => $payment->ubp,
            'date'       => $payment->created_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Трансформирует коллекцию фото в массив
     *
     * @param $payments
     * @return array
     */
    public static function manyToArray($payments) : array
    {
        $result = [];

        foreach ($payments as $payment) {
            $result[] = self::oneToArray($payment);
        }

        return $result;
    }
}