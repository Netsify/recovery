<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
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
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $ids = $this->document->groupBy('student_id', 'created_at')->pluck('student_id');
        $students = Student::with(['documents' => function ($query) {
            $query->whereNull('accepted_at');
        }])->find($ids);

        return view('admin.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($request->student_id);
        $student->email = $request->email;
        $student->save();

        $document = Document::findOrFail($id);
        $document->accepted_at = now();
        $document->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Student
     * @return RedirectResponse
     */
    public function destroy(Student $student)
    {
        foreach ($student->documents as $document) {
            $document->delete();
        }

        return back();
    }
}
