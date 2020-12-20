<?php

namespace App\Http\Controllers;

use App\Models\Proctoring\Cheating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheatingsController extends Controller
{
    public function delete(Request $request)
    {
        $cheatings = $request->get('cheatings');
        $deletedRecords = Cheating::query()->whereIn('id', array_keys($cheatings))->delete();

        if ($deletedRecords){
            return response()->json([
                'status'  => "ok",
                'message' => "Количество затронутых записей = {$deletedRecords}"
            ], 200);
        }

        Log::channel('proctoring-error')->error("Не удалось внести изменения в таблицу cheatings", [
            'cheatings'      => $cheatings,
            'deletedRecords' => $deletedRecords
        ]);

        return response()->json([
            'status'  => "fail",
            'message' => "Не удалось внести изменения. Попробуйте позже"
        ]);
    }
}
