<?php

namespace App\Http\Controllers;

use App\Models\Document;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required',
                'passport' => 'required',
            ],
            [
                'email.required' => config('app.email_validation_error'),
                'passport.required' => config('app.file_validation_error')
            ]
        );

        $student = session('collection');
        $messages = $validator->messages();

        if ($validator->fails()) {
            return view('recovery.index', compact('student', 'messages'));
        }

        session('collection')->email = $request->email;
        session('collection')->save();

        foreach ($request->file('passport') as $file) {
            $this->document->saveDocument($file);
        }

        return view('recovery.thanks');
    }
}
