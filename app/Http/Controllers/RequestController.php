<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DocumentRequest $request)
    {
        foreach ($request->file('passport') as $file) {
            $this->document->saveDocument($file, $request->email);
        }

        return redirect()->route('students.recovery_thanks');
    }
}
