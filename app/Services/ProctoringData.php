<?php
/**
 * Created by PhpStorm.
 * User: isaev
 * Date: 28.11.20
 * Time: 20:05
 */

namespace App\Services;


use App\Models\Proctoring\Cheating;
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
        }

        if ($res) {
            if ($this->_cheatings) {
                if ($this->saveCheatings($proctoringResult)) {
                    return true;
                }
            }

            return true;
        } else {
            Log::channel('proctoring-error')->error("Произошла ошибка при попытке сохранения результата");

            return response()->json([
                'status'  => 400,
                'message' => "Произошла ошибка при попытке сохранения результата"
            ], 400);
        }
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
                $cheatings[] = new Cheating($cheating);
            }

            return $proctoringResult->cheatings()->saveMany($cheatings);
        }
    }
}