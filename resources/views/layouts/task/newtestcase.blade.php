<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <title>{{config('app.title')}} - Teszt hozzáadása</title>
        <link rel="stylesheet" href="{{asset('css\auth.css')}}">
    </head>
    <body>
        <div class="container">
            @if ( Auth::check() )
                @if (Auth::user()->id == $taskowner)
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">Teszt hozzáadása</div>
                                <div class="card-body">
                                    <form method="POST" action="/task/{{ $taskid }}/savenewtestcase">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="test_input">Test input</label>
                                            <textarea class="form-control" id="test_input" name="test_input" rows="2" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="test_output">Test output</label>
                                            <textarea class="form-control" id="test_output" name="test_output" rows="2" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="validator_input">Validator input</label>
                                            <textarea class="form-control" id="validator_input" name="validator_input" rows="2" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="validator_output">Validator output</label>
                                            <textarea class="form-control" id="validator_output" name="validator_output" rows="2" required></textarea>
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