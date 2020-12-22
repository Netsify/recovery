<?php

namespace App\Services;
use App\Models\Proctoring\ProctoringResult;
use Illuminate\Support\Facades\DB;

/**
 * Сервис для работы с результатом прокторинга и читингами
 *
 * Class ProctoringResultService
 * @package App\Services
 */
class ProctoringResultService
{
    public $deletedRows = 0;

    private $_proctoringResult;

    /**
     * ProctoringResultService constructor.
     * @param ProctoringResult $proctoringResult
     */
    public function __construct(ProctoringResult $proctoringResult)
    {
        $this->_proctoringResult = $proctoringResult;
    }

    /**
     * Удаляет читинги
     *
     * @param array $cheatings
     */
    public function deleteCheatings(array $cheatings)
    {
        $this->deletedRows = $this->_proctoringResult->cheatings()->whereIn('id', array_keys($cheatings))->delete();
    }

    /**
     * Устанавливает статус
     *
     * @return bool
     */
    public function setStatus() :bool
    {
        $sum = $this->_proctoringResult->cheatings()->sum('level');
        $score = $this->getTreshholdScore();

        if ($sum <= $score) {
            $this->_proctoringResult->is_valid = 1;
            $res = $this->_proctoringResult->save();
        } else {
            $this->_proctoringResult->is_valid = 0;
            $res = $this->_proctoringResult->save();
        }

        return $res;
    }

    /**
     * Получаем пороговый score
     *
     * @return int
     */
    private function getTreshholdScore() :int
    {
        return (int)DB::table('sdo_settings')
            ->select('value')
            ->where('key', "proctoring_treshold_score")
            ->first()
            ->value;
    }
}