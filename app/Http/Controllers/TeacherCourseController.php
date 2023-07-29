<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeacherCourseController extends Controller
{

    public function teacherCoureses(Request $request)
    {
        $courses = $request->user('teachers')->courses;
        return inertia()->render('Teacher/Courses/MyCourses', [
            'courses' => $courses,
        ]);
    }

    public function studentsOfCourse(Request $request, string $id)
    {
        $course = $request->user('teachers')->courses()->where('id', $id)->firstOrFail();
        $students = $course->students;
        return inertia()->render('Teacher/Courses/Students', [
            'students' => $students,
            'course' => $course,
        ]);
    }

    public function omitStudentFromCourse(Request $request, string $courseId, string $studentId)
    {
        $course = $request->user('teachers')->courses()->where('id', $courseId)->firstOrFail();
        $course->students()->where('id', $studentId)->subscription->update(['can_access' => false]);
        return redirect()->back()->with('success', 'Operation done successfully');
    }

    public function returnStudentToCourse(Request $request, string $courseId, string $studentId)
    {
        $course = $request->user('teachers')->courses()->where('id', $courseId)->firstOrFail();
        $course->students()->where('id', $studentId)->subscription->update(['can_access' => true]);
        return redirect()->back()->with('success', 'Operation done successfully');
    }

    public function requestCodesForCourse(Request $request, string $id)
    {
        $request->validate([
            'number_required' => ['required', 'integer'],
            'code_type' => ['required', Rule::in(['monthly', 'lecture'])],
        ]);

        $course = $request->user('teachers')->courses()->where('id', $id)->firstOrFail();

        $course->codesRequests()->create([
            'number_required' => $request->number_required,
            'code_type' => $request->code_type,
        ]);

        return redirect()->back()->with('success', 'Operation done successfully');
    }

    public function courseCodes(Request $request, string $id)
    {
        $course = $request->user('teachers')->courses()->where('id', $id)->firstOrFail();

        $codes = $course->codes;

        return inertia()->render('Teacher/Courses/Codes', [
            'codes' => $codes,
            'course' => $course,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia()->render('Teacher/Courses/CreateCourse');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string'],
            'type' => ['required', Rule::in(['monthly', 'lecture'])],
            'time_period' => ['required', 'string'],
        ]);

        $request->user('teachers')->courses()->create($validatedData);

        return redirect()->route('teacher.courses.index')->with('success', 'Operation done successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return inertia()->render('Teacher/Courses/CourseManager', [
            'course' => $course,
            // TODO ...some other data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return inertia()->render('Teacher/Courses/EditCourseInfo');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string'],
            'type' => ['required', Rule::in(['monthly', 'lecture'])],
            'time_period' => ['required', 'string'],
        ]);

        $course = Course::findOrFail($id);
        $course->update($validatedData);

        return redirect()->route('teacher.courses.index')->with('success', 'Operation done successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('teacher.courses.index')->with('success', 'Operation done successfully');
    }
}
