<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class TeacherExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $id)
    {
        $course = $request->user('teachers')->courses()->where('id', $id)->firstOrFail();

        return inertia()->render('Teacher/Courses/Exams/Index', [
            'exams' => $course->exams,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia()->render('Teacher/Courses/Exams/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validDate = $request->validate([
            'name' => ['required', 'string'],
            'content' => ['required', 'array', 'min:1'],
            'content.*.question' => ['required', 'string'],
            'content.*.answers' => ['required', 'array', 'min:2', 'max:4'],
            'content.*.answers.*.answer' => ['required', 'string'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date'],
            'duration' => ['required', 'integer'],
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $request->user('teachers')
            ->courses()
            ->where('id', $request->course_id)
            ->firstOrFail()
            ->exams()
            ->create($validDate);

        return redirect()->route('teacher.courses.exams.index', $request->course_id)->with('success', 'Operation done successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return inertia()->render('Teacher/Courses/Exams/Show', [
            'exam' => Exam::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return inertia()->render('Teacher/Courses/Exams/Edit', [
            'exam' => Exam::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validDate = $request->validate([
            'name' => ['required', 'string'],
            'content' => ['required', 'array', 'min:1'],
            'content.*.question' => ['required', 'string'],
            'content.*.answers' => ['required', 'array', 'min:2', 'max:4'],
            'content.*.answers.*.answer' => ['required', 'string'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date'],
            'duration' => ['required', 'integer'],
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $request->user('teachers')
            ->courses()
            ->where('id', $request->course_id)
            ->firstOrFail()
            ->exams()
            ->where('id', $id)
            ->update($validDate);

        return redirect()->route('teacher.courses.exams.index', $request->course_id)->with('success', 'Operation done successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $exam = Exam::findOrFail($id);

        $exam->delete();

        return redirect()->route('teacher.courses.exams.index', $id)->with('success', 'Operation done successfully');
    }
}
