<?php

namespace App\Http\Controllers;

use App\Models\Predmet;
use App\Models\Student;
use App\Models\TestsType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ReallySimpleJWT\Token;

class JWTController extends Controller
{
    const NAME   = 'kineu';
    const SECRET = 'KInEU2020@kv';

    public function makeToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'predmet' => ['required', 'integer', 'min:1'],
            'student' => ['required', 'integer', 'min:1'],
            'timeopen' => ['required', 'date', 'date_format:Y-m-d H:i:s'],
            'timeclose' => ['required', 'date', 'date_format:Y-m-d H:i:s', 'after:timeopen'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => "Bad request"
            ],
                400);
        }

        $predmet_id = $request->get('predmet');
        $student_id = $request->get('student');
        $type = $request->get('type');
        $timeopen = strtotime($request->get('timeopen'));
        $timeclose = strtotime($request->get('timeclose'));

        $predmet = Predmet::query()->find($predmet_id);
        $typeTest = TestsType::query()->where(['name' => $type])->first();
        $student = Student::query()->find($student_id);
        if (!$predmet || !$typeTest || !$student) {
            return response()->json(
                [
                    'status' => 404,
                    'message' => "Not found"
                ],
                404);
        }

        $carbon = Carbon::createFromFormat('H:i:s', $typeTest->time_test);
        $cheating_code = base64_encode($student_id . '_' . microtime(true) . '_' . $predmet_id);

        $data = [
            'name'          => self::NAME,
            'userId'        => $student_id,
            'exam_name'     => $predmet->pred_name,
            'timeopen'      => $timeopen,
            'timeclose'     => $timeclose,
            'duration'      => $carbon->hour * 60 + $carbon->minute,
            'rules'         => [
                'face_rec'    => true,
                'screen'      => true,
                'dual_screen' => true,
                'live_chat'   => false,
                'audio'       => true,
                'stream'      => true,
                'clipboard'   => true,
                'authorize'   => true,
                'mobile'      => false,
            ],
            'cheating_code' => $cheating_code,
            'url' => 'https://sdo.kineu.kz/newstudy/test/index.php?type=' . $type . '&disc=' . $predmet_id,
            'submit_url' => 'https://sdo.kineu.kz/newstudy/test/result.php'
        ];

        $token = Token::customPayload($data, self::SECRET);

        return response()->json(
            [
                'status'        => 200,
                'token'         => $token,
                'cheating_code' => $cheating_code
            ],
            200);
    }

    public function decode($token)
    {
        try {
            $payload = Token::getPayload($token, self::SECRET);
            return response()->json([
                'status'  => 200,
                'payload' => $payload
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 400,
                'message' => "Bad request"
            ], 400);
        }
    }

    public function testing(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student' => ['required', 'integer', 'min:1'],
            'timeopen' => ['required', 'date', 'date_format:Y-m-d H:i:s'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => "Bad request"
            ],
                400);
        }

        $student_id = $request->get('student');
        $timeopen = strtotime($request->get('timeopen'));
        $cheating_code = base64_encode($student_id . '_' . microtime(true));

        $student = Student::query()->find($student_id);
        if (!$student) {
            return response()->json(
                [
                    'status' => 404,
                    'message' => "Not found"
                ],
                404);
        }

        $data = [
            'name'          => self::NAME,
            'userId'        => $student_id,
            'exam_name'     => "Тестирование прокторинга",
            'timeopen'      => $timeopen,
            'timeclose'     => $timeopen + 60,
            'duration'      => 60,
            'rules'         => [
                'face_rec'    => true,
                'screen'      => true,
                'dual_screen' => true,
                'live_chat'   => false,
                'audio'       => true,
                'stream'      => true,
                'clipboard'   => true,
                'authorize'   => true,
                'mobile'      => false,
            ],
            'cheating_code' => $cheating_code,
            'url' => 'https://sdo.kineu.kz/newstudy/test/testing_proctoring.php',
            'submit_url' => 'https://sdo.kineu.kz/newstudy/test/testing_proctoring.php'
        ];

        $token = Token::customPayload($data, self::SECRET);

        return response()->json(
            [
                'status'        => 200,
                'token'         => $token,
                'cheating_code' => $cheating_code
            ],
            200);
    }
}
