<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <title>{{config('app.title')}} - Tipp hozzáadása</title>
        <link rel="stylesheet" href="{{asset('css\auth.css')}}">
    </head>
    <body>
        <div class="container">
            @if ( Auth::check() )
                @if (Auth::user()->id == $taskowner)
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">Tipp hozzáadása</div>
                                <div class="card-body">
                                    <form method="POST" action="/task/{{ $taskid }}/savenewhint">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="hint">Tipp</label>
                                            <textarea class="form-control" id="hint" name="hint" rows="2" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Mentés</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        Nincs jogosultságod az oldal megtekintésére!
                    </div>
                @endif
            @else
                <div class="alert alert-danger" role="alert">
                    Nincs jogosultságod az oldal megtekintésére!
                </div>
            @endif
        </div>
    </body>
</html>