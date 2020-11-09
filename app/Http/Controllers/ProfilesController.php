<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfilesController extends Controller
{
    public function index($username)
    {
        $user = User::where('name', $username)->first();
        $me = auth()->user();
        $level = $user->getUserLevel();

        return view('layouts/user', [
            'user' => $user,
            'username' => $user->name,
            'registration' => $user->created_at,
            'level' => $level,
            'school' => $user->school,
            'me' => $me,
        ]);
    }

    public function edit()
    {
        return view('layouts/edit');
    }

    public function update()
    {
        $data = request()->validate([
            'school' => ['nullable', 'string', 'max:255'],
        ]);
        //dd($data);
        auth()->user()->update($data);
        
        return redirect("/user/".auth()->user()->name);
    }
}
