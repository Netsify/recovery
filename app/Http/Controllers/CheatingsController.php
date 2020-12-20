<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheatingsController extends Controller
{
    public function delete(Request $request)
    {
        Log::channel('proctoring-info')->info("Получены данные на корректировку результатов прокторинга", [
            'request' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        return response()->json(['status' => "ok"], 200);
    }
}
