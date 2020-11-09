<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <title>{{config('app.title')}} - Tipp módosítása</title>
        <link rel="stylesheet" href="{{asset('css\auth.css')}}">
    </head>
    <body>
        <div class="container">
            @if ( Auth::check() )
                @if (Auth::user()->id == $task->createdBy)
                    @if ($hint)
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">Tipp szerkesztése</div>
                                    <div class="card-body">
                                    <form method="POST" action="/task/{{$task->id}}/savehint/{{$hint->id}}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group">
                                                <label for="hint">Tipp</label>
                                                <textarea class="form-control" id="hint" name="hint" rows="2" required>{{$hint->hint}}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="submitbutton" value="save">Mentés</button>
                                            <button type="submit" class="btn btn-primary" name="submitbutton" value="delete">Tipp törlése</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            A tipp nem található! (Hibás URL)
                        </div>
                    @endif
                @else
                    <div class="alert alert-danger" role="alert">
                        Nincs jogosultságod az oldal megtekintésére!
                    </div>
                @endif
            @else
                <div class="alert alert-danger" role="alert">
                    Nem vagy bejelentkezve!
                </div>
            @endif
        </div>
    </body>
</html>