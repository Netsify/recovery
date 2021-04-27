<?php

namespace App\Http\Middleware;

use App\Services\JWTTokenService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ReallySimpleJWT\Token;

class Proctoring
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log::channel('proctoring-info')->info("Данные, полученные из запроса", [
            'request' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        if (!$request->headers->has('authorization')) {
            return response()->json(['status' => "fail", 'data' => "Not authorized"], 401);
        }

        if (!$this->checkToken($request->headers->get('authorization'))) {
            return response()->json([
                'status'  => 400,
                'message' => "Ошибка. Не удалось расшифровать токен."
            ], 400);
        }

        return $next($request);
    }

    private function checkToken($token)
    {
        Log::channel('proctoring-info')->info("Получен токен $token");

        $token = explode(' ', $token)[1];

        try {
            $payload = Token::getPayload($token, JWTTokenService::SECRET);

            if (!key_exists('exp', $payload)) {
                return false;
            }
        } catch (\Exception $e) {
            Log::channel('proctoring-error')->error("Ошибка. Не удалось расшифровать токен.", [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'token'   => $token
            ]);

            return false;
        }

        return true;
    }
}
