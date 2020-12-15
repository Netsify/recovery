<?php

namespace App\Http\Controllers;

use App\Models\Proctoring\IdentificationPhoto;
use App\Transformers\IdentificationPhotoTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use ReallySimpleJWT\Token;

class IdentificationPhotoController extends Controller
{
    /**
     * Подтверждает запрос
     *
     * @param IdentificationPhoto $identificationPhoto
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \ReallySimpleJWT\Exception\ValidateException
     */
    public function accept(IdentificationPhoto $identificationPhoto)
    {
        $result = $this->setPhoto($identificationPhoto->pk, 'approve');

        if ($result < 400) {
            if ($identificationPhoto->delete()) {
                $photos = IdentificationPhoto::with('student')->get();

                return response()->json([
                    'status' => "ok",
                    'data' => IdentificationPhotoTransformer::manyToArray($photos)
                ], 200);
            }
        }
    }

    /**
     * Отклоняет запрос
     *
     * @param IdentificationPhoto $identificationPhoto
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \ReallySimpleJWT\Exception\ValidateException
     */
    public function reject(IdentificationPhoto $identificationPhoto)
    {
        $result = $this->setPhoto($identificationPhoto->pk, 'reject');

        if ($result < 400) {
            if ($identificationPhoto->delete()) {
                $photos = IdentificationPhoto::with('student')->get();

                return response()->json([
                    'status' => "ok",
                    'data' => IdentificationPhotoTransformer::manyToArray($photos)
                ], 200);
            }
        }
    }

    /**
     * Отправляет запрос в aeroexam
     *
     * @param int $pk
     * @param string $flag
     * @return int
     * @throws \ReallySimpleJWT\Exception\ValidateException
     */
    public function setPhoto(int $pk, string $flag)
    {
        $payload = ['exp' => Carbon::now()->timestamp + 600];

        $token = Token::customPayload($payload, JWTController::SECRET);

        $response = Http::withToken($token, 'JWT')
            ->get("https://proctoring.aeroexam.org/api/image-requests/kineu/$flag/$pk");

        if ($response->status() >= 400) {
            Log::channel('proctoring-error')->error("Не удалось получить ответ от стороннего сервера", [
                'data' => $response
            ]);

            return $response->status();
        }

        return $response->status();
    }
}
