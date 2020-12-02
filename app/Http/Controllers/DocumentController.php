<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\Models\RequestEmail;

class DocumentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DocumentRequest $request)
    {
        $emailRequest = RequestEmail::query()->create([
            'student_id' => session('student')->stud_id,
            'email' => $request->email
        ]);

        foreach ($request->file('passport') as $file) {
            $storedPath = $file->store('passports', 'public');

            Document::query()->create([
                'request_id' => $emailRequest->id,
                'path' => $storedPath,
                'name' => $file->getClientOriginalName(),
            ]);
        }

        return redirect()->route('students.recovery_thanks');
    }
}
