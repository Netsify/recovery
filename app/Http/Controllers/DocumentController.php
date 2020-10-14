<?php

namespace App\Http\Controllers;

use App\Models\Document;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    /**
     * @var Document
     */
    private $document;

    /**
     * Create a new controller instance.
     *
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
//        $validator = Validator::make(
//            $request->all(),
//            [
//                'email' => 'required',
//                'passport' => 'required',
//            ],
//            [
//                'email.required' => config('app.email_validation_error'),
//                'passport.required' => config('app.file_validation_error')
//            ]
//        );
//
//        $student = session('collection');
//        $messages = $validator->messages();
//
//        if ($validator->fails()) {
//            return view('recovery.index', compact('student', 'messages'));
//        }

        session('student')->email_recovery = $request->email;
        session('student')->save();

        foreach ($request->file('passport') as $file) {
            $this->document->saveDocument($file);
        }

        return redirect()->route('students.recovery_thanks');
    }
}
