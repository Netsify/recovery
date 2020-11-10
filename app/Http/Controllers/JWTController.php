<?php

namespace App\Http\Controllers;

use App\Models\Predmet;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;

class JWTController extends Controller
{
    public function getJWT(Request $request)
    {
        $predmet_id = $request->get('predmet');
        $student_id = $request->get('student');
        $type = $request->get('type');

        $predmet = Predmet::query()->find($predmet_id);
        $cheating_code = base64_encode($student_id . '_'. microtime(true) . '_' . $predmet_id);

        $data = [
            'name'         => "kineu",
            'user_id'      => $student_id,
            'exam_name'    => $predmet->pred_name,
            'timeopen'     => strtotime('2020-11-01 00:00:00'),
            'timeclose'    => strtotime('2020-12-14 23:59:59'),
            'duration'     => 60,
            'rules'        => [
                'face_rec'    => true,
                'screen'      => true,
                'dual_screen' => true,
                'live_chat'   => false,
                'audio'       => false,
                'stream'      => false,
                'clipboard'   => false,
                'authorize'   => false,
                'mobile'      => false,
            ],
            'cheating_code' => $cheating_code,
            'url'           => 'https://sdo.kineu.kz/newstudy/test/index.php?type=' . $type . '&disc=' . $predmet_id,
            'submit_url'    => 'https://sdo.kineu.kz/newstudy/test/result.php'
        ];

        return response()->json(['token' => Token::customPayload($data, 'KInEU2020@kv')], 200);
    }
}
