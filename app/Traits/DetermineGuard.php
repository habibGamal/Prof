<?php

namespace App\Traits;

use App\Models\Admin;
use App\Models\Teacher;
use App\Models\User;

class DetermineGuard
{

    public function guard()
    {
        $request = request();
        if ($request->is('admins/*')) {
            return 'admins';
        } elseif ($request->is('teachers/*')) {
            return 'teachers';
        } else {
            return 'users';
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
            return User::class;
        }
    }
}
