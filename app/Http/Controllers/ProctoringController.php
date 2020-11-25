<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProctoringController extends Controller
{
    public function getResult(Request $request)
    {
        $headers = $request->headers->all();

        Log::channel('proctoring')->info("Были получены следующие данные", [
            'body'    => $request->all(),
            'headers' => $headers
        ]);

        return;
    }
}
