<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VideosController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $id)
    {
        $course = $request->user('teachers')->courses()->where('id', $id)->firstOrFail();
        $videos = $course->videos;
        return inertia()->render('Teachers/Courses/Videos/Index', [
            'videos' => $videos,
            'course' => $course,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia()->render('Teachers/Courses/Videos/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'video' => ['required', 'file', 'mimes:mp4'],
            'no_show' => ['required', Rule::in(['1', '2', 'open'])],
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $videoPath = $request->file('video')->store('videos/' . $request->user('teachers')->id . '/' . $request->course_id);

        $request->user('teachers')
            ->courses()
            ->where('id', $request->course_id)
            ->firstOrFail()
            ->videos()
            ->create([
                'name' => $request->name,
                'description' => $request->description,
                'video' => $videoPath,
                'no_show' => $request->no_show,
                'course_id' => $request->course_id,
            ]);

        return redirect()->route('teacher.courses.videos.index', ['id' => $request->course_id])->with('success', 'Operation done successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $video = $request->user('teachers')->videos()->where('id', $id)->firstOrFail();
        return inertia()->render('Teachers/Courses/Videos/Show', ['video' => $video]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $video = $request->user('teachers')->videos()->where('id', $id)->firstOrFail();
        return inertia()->render('Teachers/Courses/Videos/Edit', ['video' => $video]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'video' => ['nullable', 'file', 'mimes:mp4'],
            'no_show' => ['required', Rule::in(['1', '2', 'open'])],
        ]);

        $video = $request->user('teachers')->videos()->where('id', $id)->firstOrFail();

        $video->update([
            'name' => $request->name,
            'description' => $request->description,
            'no_show' => $request->no_show,
        ]);

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos/' . $request->user('teachers')->id . '/' . $video->course_id);
            $video->update([
                'video' => $videoPath,
            ]);
        }

        return redirect()->route('teacher.courses.videos.index', ['id' => $video->course_id])->with('success', 'Operation done successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $video = $request->user('teachers')->videos()->where('id', $id)->firstOrFail();
        $video->delete();

        return redirect()->route('teacher.courses.videos.index', ['id' => $video->course_id])->with('success', 'Operation done successfully');
    }
}
