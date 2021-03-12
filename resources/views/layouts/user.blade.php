<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <title>{{config('app.title')}} - {{$username}}</title>
        <link rel="stylesheet" href="{{asset('css\user.css')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div class="container">
            <h1>Felhasználói adatok:</h1>
            <h2>
                {{ $username }}
                @if (count($badges) > 0)
                    @foreach ($badges as $badge)
                        @if ($user->id == $me)
                            @if ($badge->badgeid == $currentBadge)
                                <img src="/badges/{{$badge->badgeid}}.png" class="user-badge selected-badge">
                            @else
                                <img src="/badges/{{$badge->badgeid}}.png" class="user-badge selectable" onclick="setCurrentBadge({{$badge->badgeid}})">
                            @endif
                        @else
                            <img src="/badges/{{$badge->badgeid}}.png" class="user-badge">
                        @endif
                    @endforeach
                @endif
            </h2>
            <p><strong>Regisztrált:</strong> {{ $registration }}</p>
            <p><strong>Szint:</strong> {{ $level }}</p>
            <p><strong>Iskola:</strong> {{ $school ?? "Ismeretlen" }}
                @if ($user->id == $me)
                    <a href="/user/{{ $username }}/edit"><i class="far fa-edit"></i></a>
                @endif
            </p>
        </div>

        <script>
            function setCurrentBadge(badgeid) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax({
                    url: '/user/{{$user->id}}/setCurrentBadge',
                    type: 'POST',
                    data: {userid: {{Auth::user()->id ?? -1}}, badgeid: badgeid},
                    success: function(result){
                        console.log(result)
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }
        </script>
    </body>
</html>