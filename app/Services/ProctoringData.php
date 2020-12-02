<?php
/**
 * Created by PhpStorm.
 * User: isaev
 * Date: 28.11.20
 * Time: 20:05
 */

namespace App\Services;


use App\Models\Proctoring\Cheating;
use App\Models\Proctoring\CheatingType;
use App\Models\Proctoring\InfoType;
use App\Models\Proctoring\ProctoringResult;
use App\Models\Proctoring\TestsResult;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProctoringData
{
    private $_isStream;
    private $_cheatingCode;
    private $_data;
    private $_cheatings;

    public function __construct(string $cheatingCode, array $data, bool $isStream)
    {
        $this->_cheatingCode = $cheatingCode;
        $this->_data         = $data;
        $this->_isStream     = $isStream;
    }

    public function saveData()
    {
        $testsResult = TestsResult::query()->where('cheating_code', $this->_cheatingCode)->first();

        if (!$this->_isStream) {
            $arrayProctoringResult = [
                'start_time' => Carbon::createFromTimestamp($this->_data['start_time']),
                'end_time'   => Carbon::createFromTimestamp($this->_data['end_time']),
                'score'      => $this->_data['score']
            ];
        } else {
            $arrayProctoringResult = $this->_data;
        }

        if (!$testsResult->proctoringResult) {
            $proctoringResult = new ProctoringResult($arrayProctoringResult);
            $res = $testsResult->proctoringResult()->save($proctoringResult);
        } else {
            $res = $testsResult->proctoringResult()->update($arrayProctoringResult);
            $proctoringResult = $testsResult->proctoringResult;
        }

        if ($res) {
            if ($this->_cheatings) {
                return $this->saveCheatings($proctoringResult);
            }

            return true;
        }

        return false;
    }

    public function setCheatings(array $cheatings)
    {
        $this->_cheatings = $cheatings;
    }

    private function saveCheatings(ProctoringResult $proctoringResult)
    {
        if ($proctoringResult->cheatings->isEmpty()) {
            $cheatings = [];

            foreach ($this->_cheatings as $cheating) {
                $cheating['uploaded_at'] = Carbon::createFromTimestamp($cheating['uploaded_at']);
                unset($cheating['end_at'], $cheating['pk']);

                $infoType = $this->getInfoType($cheating);
                $cheatingType = $this->getCheatingType($cheating);
                $ch = new Cheating($cheating);
                $ch->info_type_id = $infoType;
                $ch->cheating_type_id = $cheatingType;

                $cheatings[] = $ch;
            }

            return $proctoringResult->cheatings()->saveMany($cheatings);
        }
    }

    private function getInfoType(&$cheating)
    {
        $infoType = InfoType::query()
            ->where('info_en', $cheating['info'])
            ->firstOrCreate(['info_en' => $cheating['info']]);

        unset($cheating['info']);

        return $infoType->id;

    }

    private function getCheatingType(&$cheating)
    {
        $cheatingType = CheatingType::query()
            ->where('name', $cheating['cheating_type'])
            ->firstOrCreate(['name' => $cheating['cheating_type']]);

        unset($cheating['cheating_type']);

        return $cheatingType->id;
    }
}