<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function store(Request $request)
    {

        
        $data = $request->input('course');

        // Save course
        $course = Course::create([
            'title' => $data['title'],
            'feature_video' => $data['feature_video'],
        ]);

        // Save modules & contents
        foreach ($data['modules'] as $moduleData) {
            $module = $course->modules()->create([
                'title' => $moduleData['title']
            ]);

            foreach ($moduleData['contents'] as $contentData) {
                $module->contents()->create($contentData);
            }
        }

        return response()->json(['success' => true, 'course_id' => $course->id]);
    }
}
