<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class LeaderboardController extends Controller
{
    protected function level()
    {
        $users = DB::table('users')->select('*')->orderByDesc('experience')->orderBy('id')->limit(10)->get();
        foreach($users as $key => &$user)
        {
            $user->level = $this->getUserLevel($user->experience);
        }

        $showUserDatas = auth()->user() ? $this->showUserDatas($users, auth()->user()) : false;

        if ($showUserDatas) {
            $userDatas = DB::table('users')->select('*')->where('name', auth()->user()->name)->first();
            $userDatas->level = $this->getUserLevel($userDatas->experience);
        }

        return view('layouts/leaderboard/level', [
            'users' => $users,
            'showUserDatas' => $showUserDatas,
            'userDatas' => $userDatas ?? [],
        ]);
    }

    protected function solved()
    {
        $users = [];
        $users = DB::table('usertask')
            ->join('users', 'usertask.userid', '=', 'users.id')
            ->selectRaw('users.name, count(*) as taskcount, users.currentBadge')
            ->orderByDesc('taskcount')
			->orderBy('users.id')
            ->where('usertask.points', '>', '0')
            ->limit(10)
            ->groupByRaw('users.name, users.currentBadge')
            ->get();

        $showUserDatas = auth()->user() ? $this->showUserDatas($users, auth()->user()) : false;

        if ($showUserDatas) {
            $userDatas = DB::table('usertask')
                ->join('users', 'usertask.userid', '=', 'users.id')
                ->selectRaw('users.name, count(*) as taskcount, users.currentBadge')
                ->where('usertask.points', '>', '0')
                ->where('users.name', auth()->user()->name)
                ->groupByRaw('users.name, users.currentBadge')
                ->first();
        }

        return view('layouts/leaderboard/solved', [
            'users' => $users,
            'showUserDatas' => $showUserDatas,
            'userDatas' => $userDatas ?? [],
        ]);
    }

    protected function sent()
    {
        $users = DB::table('users')
            ->join('tasks', 'users.id', '=', 'tasks.createdBy')
            ->selectRaw('users.name, count(tasks.id) as taskcount, users.currentBadge')
            ->orderByDesc('taskcount')
			->orderBy('users.id')
            ->limit(10)
            ->groupByRaw('users.name, users.currentBadge')
            ->get();
        
        $showUserDatas = auth()->user() ? $this->showUserDatas($users, auth()->user()) : false;

        if ($showUserDatas) {
            $userDatas = DB::table('users')
                ->join('tasks', 'users.id', '=', 'tasks.createdBy')
                ->selectRaw('users.name, count(tasks.id) as taskcount, users.currentBadge')
                ->where('users.name', auth()->user()->name)
                ->groupByRaw('users.name, users.currentBadge')
                ->first();
        }
        
        return view('layouts/leaderboard/sent', [
            'users' => $users,
            'showUserDatas' => $showUserDatas,
            'userDatas' => $userDatas ?? [],
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

    private function showUserDatas($list, $user)
    {
        $showUserDatas = true;
        
        foreach($list as $item) {
            if ($item->name == $user->name) {
                $showUserDatas = false;
            }
        }
        
        return $showUserDatas;
    }
}
