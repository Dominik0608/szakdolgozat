<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <title>{{config('app.title')}} - Ranglista</title>
        <link rel="stylesheet" href="{{asset('css\leaderboard.css')}}">
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <ul class="lb-navbar-ul">
                    <a href="#">
                        <li class="lb-navbar-li selected">
                            Szint
                        </li>
                    </a>
                    <a href="/leaderboard/solved">
                        <li class="lb-navbar-li">
                            Megoldott feladatok
                        </li>
                    </a>
                    <a href="/leaderboard/sent">
                        <li class="lb-navbar-li">
                            Beküldött feladatok
                        </li>
                    </a>
                </ul>
                <div class="col-sm-12">
                    <table>
                        <tr>
                            <th class="td-name">Név</th>
                            <th class="td-level">Szint</th>
                            <th class="td-school">Iskola</th>
                        </tr>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td class="td-name">
                                    @switch($key+1)
                                        @case(1)
                                            <i class="fas fa-medal gold"></i> 
                                            @break

                                        @case(2)
                                            <i class="fas fa-medal silver"></i> 
                                            @break

                                        @case(3)
                                            <i class="fas fa-medal bronze"></i> 
                                            @break

                                        @default
                                            <div class="place">{{$key+1}}</div> 
                                    @endswitch
                                    <a href="/user/{{$user->name}}"><strong>{{$user->name}}</strong></a>
                                    @if ($user->currentBadge)
                                        <img src="/badges/{{$user->currentBadge}}.png" class="user-badge">
                                    @endif
                                </td>
                                <td class="td-level">{{$user->level}}</td>
                                <td class="td-school">{{$user->school ?? 'Ismeretlen'}}</td>
                            </tr>
                        @endforeach
                        @if ($showUserDatas)
                            <tr style="background-color: #272946;">
                                <td class="td-name">
                                    <i class="fas fa-question"></i>
                                    <a href="/user/{{$userDatas->name}}"><strong>{{$userDatas->name}}</strong></a>
                                    @if ($userDatas->currentBadge)
                                        <img src="/badges/{{$userDatas->currentBadge}}.png" class="user-badge">
                                    @endif
                                </td>
                                <td class="td-level">{{$userDatas->level}}</td>
                                <td class="td-school">{{$userDatas->school ?? 'Ismeretlen'}}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>