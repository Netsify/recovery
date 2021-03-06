<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdentificationPhotoRequest;
use App\Models\Proctoring\IdentificationPhoto;
use App\Services\ProctoringData;
use App\Transformers\IdentificationPhotoTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
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
                'status' => 201,
                'message' => "Данные успешно сохранены"
            ], 201);
        } else {
            Log::channel('proctoring-error')->error("Произошла ошибка при попытке сохранения результата", [
                'request' => $request->all(),
                'headers' => $request->headers->all()
            ]);

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
            $student = $photo->student->getFullName();
            $msg = "Получен запрос на изменение фото от " . $student;
            $msg = urlencode($msg);
            $telegram = Http::get("https://api.telegram.org/bot720766457:AAE7SSje9PTMkAR4ZbJ6PgbwzahRS4aaAH4/sendMessage?chat_id=396932950&text=$msg");

            if ($telegram->status() >= 400) {
                Log::channel('proctoring-error')->error("Не удалось отправить сообщение боту.", [
                    'body'    => $telegram->body(),
                    'headers' => $telegram->headers(),
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => "Данные были успешно получены"
            ], 200);
        }

        return response()->json([
            'status' => 500,
            'message' => "Не удалось принять и обработать запрос"
        ], 500);
    }

    /**
     * Возвращает все фото пользователей
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allPhotos() : JsonResponse
    {
        $unchecked_photos = IdentificationPhoto::with('student')->get();
        $unchecked_photos = IdentificationPhotoTransformer::manyToArray($unchecked_photos);

        $checked_photos = IdentificationPhoto::onlyTrashed()->with('student')->orderByDesc('deleted_at')->get();
        $checked_photos = IdentificationPhotoTransformer::manyToArray($checked_photos);

        return response()->json([
            'status' => "ok",
            'data'   => compact('unchecked_photos', 'checked_photos')
        ], 200);
    }
}
