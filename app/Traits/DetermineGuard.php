<?php

namespace App\Traits;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;

trait DetermineGuard
{

    public function guard()
    {
        $request = request();
        if ($request->is('admins/*')) {
            return 'admins';
        } elseif ($request->is('teachers/*')) {
            return 'teachers';
        } else {
            return 'students';
        }
    }

    public function authClass()
    {
        $request = request();
        if ($request->is('admins/*')) {
            return Admin::class;
        } elseif ($request->is('teachers/*')) {
            return Teacher::class;
        } else {
            return Student::class;
        }
    }
}
