<?php

namespace App\Http\Controllers;

use App\Models\Proctoring\ProctoringResult;
use App\Models\Proctoring\TestsResult;
use App\Services\ProctoringData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ReallySimpleJWT\Token;

class ProctoringController extends JWTController
{
    public function getResult(Request $request)
    {
        $isStream = $request->get('isStream');
        if ($isStream) {
            $data = [
                'stream_link'     => $request->get('stream')['link'],
                'stream_uploaded' => Carbon::createFromTimestamp($request->get('stream')['uploaded'])
            ];
        } else {
            $data = $request->only(['start_time', 'end_time', 'score']);
        }

        $proctoringData = new ProctoringData($request->get('cheating_code'), $data, $isStream);

        if (!$isStream && $request->has('cheatings')) {
            $proctoringData->setCheatings($request->get('cheatings'));
        }

        if ($proctoringData->saveData()) {
            return response()->json([
                'status'  => 201,
                'message' => "Данные успешно сохранены"
            ], 201);
        }
    }
}
