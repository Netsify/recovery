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
    private $_cheatingCode;
    private $_data;
    private $_cheatings;

    public function __construct(string $cheatingCode, array $data)
    {
        $this->_cheatingCode = $cheatingCode;
        $this->_data         = $data;
    }

    public function saveData()
    {
        $testsResult = TestsResult::query()->where('cheating_code', $this->_cheatingCode)->first();

        $arrayProctoringResult = [
            'start_time'     => Carbon::createFromTimestamp($this->_data['start_at']),
            'end_time'       => Carbon::createFromTimestamp($this->_data['end_at']),
            'score'          => $this->_data['score'],
            'stream_link'    => $this->_data['video'],
            'identification' => $this->_data['identification']
        ];


        if (!$testsResult->proctoringResult) {
            $proctoringResult = new ProctoringResult($arrayProctoringResult);
            $proctoringResult = $testsResult->proctoringResult()->save($proctoringResult);
        } else {
            $proctoringResult = $testsResult->proctoringResult->update($arrayProctoringResult);
            $proctoringResult = $testsResult->proctoringResult()->first();
        }

        if ($proctoringResult) {
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
                $infoType = $this->getInfoType($cheating);
                $cheatingType = $this->getCheatingType($cheating);

                $ch = new Cheating();
                $ch->image = $cheating['image'];
                $ch->content = $cheating['content'];
                $ch->info_type_id = $infoType;
                $ch->level = $cheating['score'];
                $ch->uploaded_at = Carbon::createFromTimestamp($cheating['created_at']);
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