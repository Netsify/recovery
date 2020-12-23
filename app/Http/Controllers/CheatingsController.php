<?php

namespace App\Http\Controllers;

use App\Models\Proctoring\Cheating;
use App\Models\Proctoring\ProctoringResult;
use App\Services\ProctoringResultService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheatingsController extends Controller
{
    public function delete(Request $request)
    {
        $proctoring_result_id = $request->get('proctoring_result_id');
        $cheatings = $request->get('cheatings');

        $result = ProctoringResult::query()->find($proctoring_result_id);
        $proctoringResult = new ProctoringResultService($result);
        $proctoringResult->deleteCheatings($cheatings);

        if ($proctoringResult->setStatus()) {
            return response()->json([
                'status'  => "ok",
                'message' => "Количество затронутых записей = {$proctoringResult->deletedRows}"
            ], 200);
        }

        Log::channel('proctoring-error')->error("Не удалось внести изменения в таблицу cheatings", [
            'cheatings'      => $cheatings,
            'deletedRecords' => $proctoringResult->deletedRows
        ]);

        return response()->json([
            'status'  => "fail",
            'message' => "Не удалось внести изменения. Попробуйте позже"
        ]);
    }
}
