<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProctoringController extends Controller
{
    public function getResult(Request $request)
    {
        Log::channel('proctoring')->info("Были получены следующие данные", $request->all());

        return;
    }
}
