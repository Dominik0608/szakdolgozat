<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProfilesController extends Controller
{
    public function index($username)
    {
        $user = User::where('name', $username)->first();
        $me = auth()->user();
        $level = $user->getUserLevel();

        $badges = DB::table('badges')->select('badgeid')->where('userid', '=', $user->id)->get();

        return view('layouts/user', [
            'user' => $user,
            'username' => $user->name,
            'registration' => $user->created_at,
            'level' => $level,
            'school' => $user->school,
            'me' => $me->id ?? -1,
            'badges' => $badges,
            'currentBadge' => $user->currentBadge ?? -1,
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

    public function setCurrentBadge(Request $request)
    {
        if (is_numeric($request->userid) && is_numeric($request->badgeid)) {
            DB::statement("UPDATE users SET currentBadge = $request->badgeid WHERE id = $request->userid");
        }
        $returnData = array("success" => true);
        return json_encode($returnData);
    }
}
