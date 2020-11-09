<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class LeaderboardController extends Controller
{
    protected function level()
    {
        $users = DB::table('users')->select('*')->orderByDesc('experience')->limit(10)->get();
        foreach($users as $key => &$user)
        {
            $user->level = $this->getUserLevel($user->experience);
        }
        return view('layouts/leaderboard/level', [
            'users' => $users,
        ]);
    }

    protected function solved()
    {
        $users = [];
        $users = DB::table('usertask')
            ->join('users', 'usertask.userid', '=', 'users.id')
            ->selectRaw('users.name, count(*) as taskcount')
            ->orderByDesc('taskcount')
            ->where('usertask.points', '>', '0')
            ->limit(10)
            ->get();
        //dd($users);
        return view('layouts/leaderboard/solved', [
            'users' => $users,
        ]);
    }

    protected function sent()
    {
        $users = DB::table('users')
            ->join('tasks', 'users.id', '=', 'tasks.createdBy')
            ->selectRaw('users.name, count(tasks.id) as taskcount')
            ->orderByDesc('taskcount')
            ->limit(10)
            ->get();
        //$users = DB::select('select users.name, count(tasks.id) as taskcount from `users` inner join `tasks` on `users`.`id` = `tasks`.`createdBy` order by `taskcount` desc limit 10');
        return view('layouts/leaderboard/sent', [
            'users' => $users,
        ]);
    }

    private function getUserLevel($experience)
    {
        $level = 1;
        while($experience > 0) {
            $level++;
            $experience -= $level * 10;
        }
        return $level;
    }

}
