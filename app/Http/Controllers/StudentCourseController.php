<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function teacherCoureses(Teacher $teacher)
    {
        $courses = $teacher->courses;
        return inertia()->render('Courses/TeacherCourses', [
            'courses' => $courses,
            'teacher' => $teacher,
        ]);
    }



    public function displayCourseVideosToStudent(Course $course)
    {
        // TODO: check if the student is enrolled in the course
        $videos = $course->videos;
        return inertia()->render('Student/Courses/Videos', [
            'videos' => $videos,
            'course' => $course,
        ]);
    }
}
