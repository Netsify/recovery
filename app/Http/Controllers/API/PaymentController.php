<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Transformers\PaymentTransformer;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function info(Request $request)
    {
        $iin = $request->input('student_iin');
        $student = (new Student())->getByIIN($iin);

        if (!$student) {
            return response()->json([
                'code'    => 404,
                'message' => "Not found"
            ], 404);
        }
        $student->load('payments');

        $payments = $student->payments->sortByDesc('created_at');

        return response()->json([
            'code' => 200,
            'data' => [
                'student' => $student->getFullName(),
                'payment' => PaymentTransformer::manyToArray($payments)
            ]
        ],200);
    }
}
