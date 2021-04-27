<?php

namespace App\Http\Controllers;

use App\Models\Predmet;
use App\Models\Proctoring\ProctoringRule;
use App\Models\Student;
use App\Models\TestsType;
use App\Services\JWTTokenService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ReallySimpleJWT\Token;

class JWTController extends Controller
{
    public function getToken(Request $request)
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

        $jwt_service = new JWTTokenService();
        $jwt_service->user_id = $student_id;
        $jwt_service->name = $predmet->pred_name;
        $jwt_service->timeopen = $timeopen;
        $jwt_service->timeclose = $timeclose;
        $jwt_service->duration = $carbon->hour * 60 + $carbon->minute;
        $jwt_service->url = "https://sdo.kineu.kz/newstudy/test/index.php?type=$type&disc=$predmet_id";
        $jwt_service->submit_url = 'https://sdo.kineu.kz/newstudy/test/result.php';
        $jwt_service->lang = $student->specialty->language;
        $jwt_service->setRules($this->getProctoringRules());
        $jwt_service->setCheatingCode($cheating_code);

        return response()->json(
            [
                'status'        => 200,
                'token'         => $jwt_service->make(),
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

        $jwt_service = new JWTTokenService();
        $jwt_service->user_id = $student_id;
        $jwt_service->name = "Тестирование прокторинга";
        $jwt_service->timeopen = $timeopen;
        $jwt_service->timeclose = $timeopen + 900;
        $jwt_service->duration = 1;
        $jwt_service->url = 'https://sdo.kineu.kz/newstudy/test/testing_proctoring.php';
        $jwt_service->submit_url = 'https://sdo.kineu.kz/newstudy/test/testing_proctoring.php';
        $jwt_service->lang = $student->specialty->language;
        $jwt_service->setRules($this->getProctoringRules());
        $jwt_service->setCheatingCode($cheating_code);

        return response()->json(
            [
                'status'        => 200,
                'token'         => $jwt_service->make(),
                'cheating_code' => $cheating_code
            ],
            200);
    }

    protected function getProctoringRules()
    {
        $arr = [];
        $rules = ProctoringRule::all()->toArray();

        foreach ($rules as $rule) {
            $arr[$rule['rule']] = $rule['is_active'] ? true : false;
        }

        return $arr;
    }
}
