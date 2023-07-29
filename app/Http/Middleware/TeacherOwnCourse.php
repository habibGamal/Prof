<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherOwnCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // TODO: check if the teacher owns the course
        if ($request->is('teacher/courses/*')) {
            $courseId = $request->route('courseId');
            $course = $request->user('teachers')->courses()->where('id', $courseId)->first();
            if (!$course) {
                return redirect()->route('teacher.courses.index')->with('error', 'You do not own this course');
            }
        }
        return $next($request);
    }
}
