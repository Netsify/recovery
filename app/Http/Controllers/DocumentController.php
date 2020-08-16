<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;

use Illuminate\Http\Request;

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
        session('collection')->email = $request->email;
        session('collection')->save();

        $files = $request->file('passport');

        foreach ($files as $file) {
            $this->document->saveDocument($file);
        }

        return view('recovery.thanks');
    }
}
