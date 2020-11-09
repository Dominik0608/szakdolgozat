<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <title>{{config('app.title')}} - Feladatok</title>
        <link rel="stylesheet" href="{{asset('css\tasks.css')}}">
    </head>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-12" style="margin-top: 20px;">
                    <!--
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="függvény, lista, változó, stb...">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">Keresés</button>
                        </div>
                    </div>
                    -->
                    @if (Auth::check())
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ownTasks">
                            <label class="form-check-label" for="ownTasks">
                                Saját feladatok elrejtése
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="solvedTasks">
                            <label class="form-check-label" for="solvedTasks">
                                Megoldott feladatok elrejtése
                            </label>
                        </div>
                    @endif
                </div>
                
                @foreach ($tasks as $task)
                    <div class="task-box col-md-4 col-sm-12
                        @if (($task->leftTime ?? -1) == 0) solvedTask @endif
                        @if ((Auth::user()->id ?? -1) == ($task->createdBy ?? -2)) ownTask @endif
                    ">
                        <div class="task">
                            <a href="/task/{{ $task->id }}"><span>{{ $task->title }}</span></a>
                            @if ($task->verified)
                                <i class="fas fa-check-circle" data-toggle="tooltip" data-placement="top" title="Ellenőrzött"></i>
                            @endif
                            @if (Auth::check())
                                @if (Auth::user()->id == $task->createdBy)
                                    <a href="/task/{{ $task->id }}/edit"><i class="fas fa-cog task-edit" data-toggle="tooltip" data-placement="top" title="Szerkesztés"></i></a>
                                @endif
                            @endif
                            <p class="">{{ $task->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="newTask"><a href="/tasks/create"><i class="fas fa-plus-circle"></i></a></div>

        <script>
            $(document).ready(function() {
                $('#ownTasks').val(this.checked);
                $('#solvedTasks').val(this.checked);

                $('#ownTasks').change(function() {
                    if(this.checked) {
                        $(".ownTask").css("display", "none");
                    } else {
                        $(".ownTask").css("display", "block");
                    }      
                });
                
                $('#solvedTasks').change(function() {
                    if(this.checked) {
                        $(".solvedTask").css("display", "none");
                    } else {
                        $(".solvedTask").css("display", "block");
                    }      
                });
            });
        </script>
    </body>
</html>