<?php

namespace App\Http\Controllers;

use App\Models\Proctoring\TestsResult;
use App\Services\ProctoringData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProctoringController extends Controller
{
    public function getResult(Request $request)
    {
        $proctoringData = new ProctoringData($request->get('cheating_code'), $request->except('cheatings', 'cheating_code'));

        if ($request->has('cheatings')) {
            $proctoringData->setCheatings($request->get('cheatings'));
        }

        if ($proctoringData->saveData()) {
            return response()->json([
                'status'  => 201,
                'message' => "Данные успешно сохранены"
            ], 201);
        } else {
            Log::channel('proctoring-error')->error("Произошла ошибка при попытке сохранения результата");

            return response()->json([
                'status'  => 400,
                'message' => "Произошла ошибка при попытке сохранения результата"
            ], 400);

        }
    }

    /**
     * Метод принятия запроса на изменение фото в расссширении прокторинга
     * @param Request $request
     *
     * @return Response
     */
    public function changePhoto(Request $request)
    {
        Log::channel('proctoring-info')->info("Получены данные на изменеие фотографии", [
            'request' => $request->all(),
            'headers' => $request->headers,
            'files'   => $request->files->all()
        ]);

        return response()->json([
            'status'  => 200,
            'message' => "Запрос обработан"
        ]);
    }
}
