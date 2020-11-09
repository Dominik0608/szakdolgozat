<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <title>{{config('app.title')}} - Teszt módosítása</title>
        <link rel="stylesheet" href="{{asset('css\auth.css')}}">
    </head>
    <body>
        <div class="container">
            @if ( Auth::check() )
                @if (Auth::user()->id == $task->createdBy)
                    @if ($testcase)
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">Teszt hozzáadása</div>
                                    <div class="card-body">
                                        <form method="POST" action="/task/{{$task->id}}/savetestcase/{{$testcase->id}}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group">
                                                <label for="test_input">Test input</label>
                                                <textarea class="form-control" id="test_input" name="test_input" rows="2" required>{{$testcase->test_input}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="test_output">Test output</label>
                                                <textarea class="form-control" id="test_output" name="test_output" rows="2" required>{{$testcase->test_output}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="validator_input">Validator input</label>
                                                <textarea class="form-control" id="validator_input" name="validator_input" rows="2" required>{{$testcase->validator_input}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="validator_output">Validator output</label>
                                                <textarea class="form-control" id="validator_output" name="validator_output" rows="2" required>{{$testcase->validator_output}}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="submitbutton" value="save">Mentés</button>
                                            <button type="submit" class="btn btn-primary" name="submitbutton" value="delete">Teszt törlése</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            A teszt nem található! (Hibás URL)
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