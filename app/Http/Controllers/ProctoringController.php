<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdentificationPhotoRequest;
use App\Models\Proctoring\IdentificationPhoto;
use App\Models\Proctoring\TestsResult;
use App\Services\ProctoringData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

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
     * Метод принятия запроса на изменение фото в расширении прокторинга
     * @param IdentificationPhotoRequest $request
     *
     * @return Response
     */
    public function changePhoto(IdentificationPhotoRequest $request)
    {
        Log::channel('proctoring-info')->info("Получены данные на изменение фотографии", [
            'request' => $request->all(),
            'headers' => $request->headers,
        ]);

        $photo = new IdentificationPhoto($request->only('old_image', 'new_image'));

        $photo->student_id = $request->get('user_id');
        $photo->pk = $request->get('id');

        if ($photo->save()) {
            return response()->json([
                'status'  => 200,
                'message' => "Данные были успешно получены"
            ], 200);
        }

        return response()->json([
            'status'  => 500,
            'message' => "Не удалось принять и обработать запрос"
        ],500);
    }

    public function allPhotos()
    {
        $photos = IdentificationPhoto::with('student')->get();

        $result = [];
        try {
            foreach ($photos as $photo) {
                $result[] = [
                    'id' => $photo->id,
                    'pk' => $photo->pk,
                    'old_image' => $photo->old_image,
                    'new_image' => $photo->new_image,
                    'student' => $photo->student->getFullName(),
                ];
            }

            return response()->json([
                'status' => "ok",
                'data' => $result
            ], 200);
        } catch (\Error $e) {
            Log::channel('proctoring-error')->error($e->getMessage());

            return response()->json([
                'status' => "fail",
                'data' => false
            ], 500);
        }
    }
}
