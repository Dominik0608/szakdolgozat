<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <title>{{config('app.title')}} - {{$username}}</title>
        <link rel="stylesheet" href="{{asset('css\user.css')}}">
    </head>
    <body>
        <div class="container">
            <h1>Felhasználói adatok:</h1>
            <h2>{{ $username }}</h2>
            <p><strong>Regisztrált:</strong> {{ $registration }}</p>
            <p><strong>Szint:</strong> {{ $level }}</p>
            <p><strong>Iskola:</strong> {{ $school ?? "Ismeretlen" }}
                @if ($user->id == $me->id)
                    <a href="/user/{{ $username }}/edit"><i class="far fa-edit"></i></a>
                @endif
            </p>
        </div>
    </body>
</html>