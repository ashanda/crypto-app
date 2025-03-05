<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
        //return response()->json(['message' => 'Welcome to Admin Dashboard']);
    }

    public function activateUser(User $user)
    {
        $user->status = 'active';
        $user->save();

        // Send an email or notification if needed
        return redirect()->route('admin.dashboard');
    }
}
