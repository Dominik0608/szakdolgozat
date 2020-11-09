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
            <h1>Üdvözöllek a feladatoknál!</h1>
            <div class="row">
                @foreach ($tasks as $task)
                    <div class="task-box col-md-3 col-sm-12">
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
    </body>
</html>