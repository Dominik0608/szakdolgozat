<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <title>{{config('app.title')}} - Feladat leírása</title>
        <link rel="stylesheet" href="{{asset('css\task.css')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <body>
        <div class="container">
            <div class="row">
                @if (app('request')->input('submitTask'))
                    <div class="col-sm-12">
                        <div class="alert alert-success" role="alert">
                            Sikeresen beküldted a megoldásodat.
                        </div>
                    </div>
                @endif
                <div class="col-md-6 col-sm-12">
                    <div class="col-sm-12 title">
                        <h1>{{$task->title}}</h1>
                    </div>
                    @if ($creator)
                        <div class="col-sm-12 creator">
                            <h2>
                                Készítő: <a href="/user/{{$creator->name}}">{{$creator->name}}</a>
                                @if ($creator->currentBadge)
                                    <img src="/badges/{{$creator->currentBadge}}.png" class="user-badge">
                                @endif
                            </h2>
                        </div>
                    @endif
                    <div class="col-sm-12 description">
                        <p>{{$task->description}}</p>
                    </div>
                    @if (Auth::check())
                        @if (Auth::user()->id == $task->createdBy)
                            <div class="alert alert-danger" role="alert">
                                Általad készített feladatot nem tudsz megoldani! <a href="/task/{{$task->id}}/edit"><strong>Feladat szerkesztése</strong></a>
                            </div>

                            <div class="col-sm-12 feedback-box" style="max-height: 300px; overflow: auto;">
                                @if (count($feedbacks) == 0)
                                    Ehhez a feladathoz még nem érkezett visszajelzés.
                                @else
                                    <table><tbody>
                                    @foreach ($feedbacks as $item)
                                        <tr><td style="padding: 10px;"><i>({{$item->date}})</i> <a href="/user/{{$item->name}}"><strong>{{$item->name}}</strong></a>: {{$item->feedback}}<br></td></tr>
                                    @endforeach
                                    </tbody></table>
                                @endif
                            </div>
                        @else
                            <div class="col-sm-12 ide">
                                @if ($mytask)
                                    @if ($mytask->leftTime > 0)
                                        <p>Ezt a feladatot egyszer már elkezdted, a megoldás beküldéséig {{$mytask->leftTime}} másodperced maradt.</p>
                                        <a href="/task/{{$task->id}}/ide"><button type="button" class="btn btn-primary">Feladat folytatása</button></a>
                                    @else
                                        <p>Ezt a feladatot egyszer már megoldottad, amiért anno <strong>{{$mytask->points}} pontot</strong> kaptál. Újboli megoldásért már nem jár pont.</p>
                                        <a href="/task/{{$task->id}}/ide"><button type="button" class="btn btn-primary">Feladat újrakezdése</button></a>
                                    @endif
                                @else
                                <p>Ezt a feladatot még egyszer sem kezdted el. A megoldásra 15 perced van.</p>
                                <a href="/task/{{$task->id}}/ide"><button type="button" class="btn btn-primary">Feladat elkezdése</button></a>
                                @endif
                            </div>
                            
                            @if ($mytask && $mytask->leftTime == 0)
                                <div class="col-sm-12 ide">
                                    <p>Visszajelzés küldése</p>
                                    <textarea class="form-control" id="feedback" rows="3"></textarea>
                                    <button id="sendFeedback" class="btn btn-primary" onclick="sendFeedback()">Küldés</button>
                                    <div id="feedback-error" class="alert alert-danger" role="alert" style="display: none;"></div>
                                    <div id="feedback-success" class="alert alert-success" role="alert" style="display: none;"></div>
                                </div>
                            @endif
                        @endif
                    @else
                        <div class="alert alert-danger" role="alert">
                            A feladat megkezdéséhez jelentkezz be!
                        </div>
                    @endif
                </div>
                <div class="col-md-6 col-sm-12 usertask">
                    <h3>A feladatot legjobban megoldók</h3>
                    @if (count($usertask) > 0)
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Név</th>
                                    <th scope="col">Pont</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usertask as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td><a href="/user/{{$item->name}}">{{$item->name}}</a></td>
                                        <td>{{$item->points}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>A feladatot még senki sem oldotta meg. :(</p>
                    @endif
                </div>
            </div>
        </div>

        <script>
            function sendFeedback() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '/task/{{$task->id}}/sendFeedback',
                        type: 'POST',
                        data: {userid: '{{Auth::user()->id ?? -1}}', taskid: '{{$task->id}}', feedback: $('#feedback').val()},
                        success: function(result){
                            var result = JSON.parse(result);
                            $('#feedback-error').css("display", "none");
                            $('#feedback-success').css("display", "none");
                            if (result.success) {
                                $('#feedback-success').css("display", "block");
                                $('#feedback-success').text("Visszajelzés beküldve!");
                            } else {
                                $('#feedback-error').css("display", "block");
                                $('#feedback-error').text(result.error);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error)
                        }
                    })
            }
        </script>
    </body>
</html>