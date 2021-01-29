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
        $this->_data = $data;
    }

    public function saveData()
    {
        $testsResult = TestsResult::query()->where('cheating_code', $this->_cheatingCode)->first();

        if (!is_null($this->_data['end_at'])) {
            $this->_data['end_at'] = Carbon::createFromTimestamp($this->_data['end_at']);
        }

        $arrayProctoringResult = [
            'start_time' => Carbon::createFromTimestamp($this->_data['start_at']),
            'end_time' => $this->_data['end_at'],
            'score' => $this->_data['score'],
            'stream_link' => $this->_data['video'],
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
        $date_start = $proctoringResult->test_result->date_start;
        $date_end = $proctoringResult->test_result->date_end;
        if ($proctoringResult->cheatings->isEmpty()) {
            $cheatings = [];

            foreach ($this->_cheatings as $cheating) {
                $infoType = $this->getInfoType($cheating);
                $cheatingType = $this->getCheatingType($cheating);
                $uploaded_at = Carbon::createFromTimestamp($cheating['created_at']);

                $ch = $this->createCheating($cheating['image'], $cheating['content'], $infoType->id, $cheating['score'], $uploaded_at, $cheatingType, $date_start, $date_end);
                $cheatings[] = $ch;

                if ($infoType->info_en == 'audio') {
                    $audios = explode("\r\n", $cheating['content']);

                    foreach ($audios as $audio) {
                        $audio = explode(':', $audio);
                        list($dates, $content) = $audio;
                        $content = trim($content);

                        list($start, $end) = explode('-', $dates);
                        $start = Carbon::createFromTimestamp($start);

                        $cheatings[] = $this->createCheating($cheating['image'], $content, $infoType->id, 1, $start, $cheatingType, $date_start, $date_end, true);
                    }
                }
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

        return $infoType;

    }

    private function getCheatingType(&$cheating)
    {
        $cheatingType = CheatingType::query()
            ->where('name', $cheating['cheating_type'])
            ->firstOrCreate(['name' => $cheating['cheating_type']]);

        unset($cheating['cheating_type']);

        return $cheatingType->id;
    }

    /**
     * Создаём читинг
     *
     * @param $image
     * @param $content
     * @param $info_type_id
     * @param $score
     * @param $uploaded_at
     * @param $cheating_type_id
     * @param $date_start
     * @param $date_end
     * @return Cheating
     */
    private function createCheating($image, $content, $info_type_id, $score, $uploaded_at, $cheating_type_id, $date_start, $date_end, $parsed_audio = null) : Cheating
    {
        $ch = new Cheating();
        $ch->image = $image;
        $ch->content = $content;
        $ch->info_type_id = $info_type_id;
        $ch->level = $score;
        $ch->uploaded_at = $uploaded_at;
        $ch->cheating_type_id = $cheating_type_id;
        $ch->is_parsed_audio = $parsed_audio;
        $range = range(
            Carbon::createFromFormat('Y-m-d H:i:s', $date_start)->timestamp,
            Carbon::createFromFormat('Y-m-d H:i:s', $date_end)->timestamp
        );

        if (!in_array($ch->uploaded_at->timestamp, $range)) {
            $ch->deleted_at = (new Carbon())->timestamp;
        }

        return $ch;

    }
}