<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <title>{{config('app.title')}} - Feladat módosítása</title>
        <link rel="stylesheet" href="{{asset('css\task.css')}}">
    </head>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                @if (Auth::check())
                    @if (Auth::user()->id == $task->createdBy)
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Feladat módosítása</div>
                                <div class="card-body">
                                    <form method="POST" action="/task/{{ $task->id }}/edit">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="title">Cím</label>
                                            <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}" maxlength="255" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Leírás</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Minden információ, amire a felhasználónak szüksége lehet." required>{{ $task->description }}</textarea>
                                        </div>
                                        <p><strong>Ellenőrzött:</strong> {{ $task->verified ? 'igen' : 'nem' }}</p>
                                        <button type="submit" class="btn btn-primary">Mentés</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">Tippek</div>
                                <div class="card-body">
                                    @foreach ($hints as $item)
                                        <div class="hint-box">
                                            <p><a href="/task/{{$task->id}}/edit/hint/{{$item->id}}"><i class="fas fa-cog" data-toggle="tooltip" data-placement="top" title="Szerkesztés"></i></a> {{$item->hint}}</p>
                                        </div>
                                    @endforeach
                                    <a href="/task/{{$task->id}}/newhint"><button type="submit" class="btn btn-primary">Új tipp hozzáadása</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Tippek</div>
                                <div class="card-body">
                                    @foreach ($testCases as $key => $item)
                                        <label>Teszt #{{$key + 1}} <a href="/task/{{$task->id}}/edit/testcase/{{$item->id}}"><i class="fas fa-cog" data-toggle="tooltip" data-placement="top" title="Szerkesztés"></i></a></label>
                                        <div class="hint-box">
                                            <p>{{$item->test_input}}</p>
                                        </div>
                                        <div class="hint-box">
                                            <p>{{$item->test_output}}</p>
                                        </div>
                                        <div class="hint-box">
                                            <p>{{$item->validator_input}}</p>
                                        </div>
                                        <div class="hint-box">
                                            <p>{{$item->validator_output}}</p>
                                        </div>
                                    @endforeach
                                    <a href="/task/{{$task->id}}/newtestcase"><button type="submit" class="btn btn-primary">Új teszt hozzáadása</button></a>
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
        </div>
    </body>
</html>