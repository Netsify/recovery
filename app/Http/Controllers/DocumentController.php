<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;

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
    public function store(DocumentRequest $request)
    {
        session('student')->email_recovery = $request->email;
        session('student')->save();

        foreach ($request->file('passport') as $file) {
            $this->document->saveDocument($file);
        }

        return redirect()->route('students.recovery_thanks');
    }
}
