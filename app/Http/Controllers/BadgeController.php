<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BadgeController extends Controller
{
    public static function tryToAddBadge($userid, $badgeid)
    {
        $badges = DB::table('badges')->select('*')->where('userid', '=', $userid)->where('badgeid', '=', $badgeid)->get();
        // DB::table('log')->insert(
        //     [
        //         'text' => $userid . " " . $badgeid,
        //     ]
        // );
        if (count($badges) == 0) {
            DB::table('badges')->insert(
                [
                    'userid' => $userid,
                    'badgeid' => $badgeid,
                ]
            );
        }
    }
}
