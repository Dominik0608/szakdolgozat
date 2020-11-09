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
                    <a href="/leaderboard/level">
                        <li class="lb-navbar-li">
                            Szint
                        </li>
                    </a>
                    <a href="#">
                        <li class="lb-navbar-li selected">
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
                        <th class="td-level">Megoldott feladatok</th>
                    </tr>
                    @foreach ($users as $key => $user)
                        <tr>
                            @switch($key+1)
                                @case(1)
                                    <td class="td-name"><i class="fas fa-medal gold"></i> <a href="/user/{{$user->name}}"><strong>{{$user->name}}</strong></a></td>
                                    @break

                                @case(2)
                                    <td class="td-name"><i class="fas fa-medal silver"></i> <a href="/user/{{$user->name}}"><strong>{{$user->name}}</strong></a></td>
                                    @break

                                @case(3)
                                    <td class="td-name"><i class="fas fa-medal bronze"></i> <a href="/user/{{$user->name}}"><strong>{{$user->name}}</strong></a></td>
                                    @break

                                @default
                                    <td class="td-name"><div class="place">{{$key+1}}</div> <a href="/user/{{$user->name}}"><strong>{{$user->name}}</strong></a></td>
                            @endswitch
                            <td class="td-level">{{$user->taskcount}}</td>
                        </tr>
                    @endforeach
                </table>
                </div>
            </div>
        </div>
    </body>
</html>