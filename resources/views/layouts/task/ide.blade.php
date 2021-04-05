<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <title>{{config('app.title')}} - Feladat megoldása</title>
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
                @if ( !Auth::check() )
                    <script>window.location = "/login";</script>
                @elseif (Auth::check() && Auth::user()->id == $task->createdBy)
                    <script>window.location = "/task/{{$task->id}}";</script>
                @endif
                <div class="col-md-6 col-sm-12">
                    <div class="col-sm-12">
                        <h1>{{$task->title}}</h1>
                    </div>
                    <div class="col-sm-12">
                        <p id="description">{{$task->description}}</p>
                        @foreach ($images as $image)
                            <img src="{{ asset('storage/task-img/'.$image) }}" alt="Desc img" class="desc-img viewerjs">
                        @endforeach
                    </div>
                    <div class="col-sm-12 tests-box">
                        <h2>Tesztek</h2>
                        @foreach ($testCases as $key => $item)
                            <div class="test-button">
                                <button id="test_{{$item->id}}" class="btn" style="margin: 0" onclick="test({{$item->id}})">Teszt #{{$key+1}}</button>
                                <p><strong>Input:</strong> {{$item->test_input}}</p>
                                <p style="margin-bottom: 15px;"><strong>Output:</strong> {{$item->test_output}}</p>
                            </div>
                        @endforeach
                        <button id="sendTask" class="btn btn-danger" onclick="submitTask()">Feladat beküldése</button>
                    </div>
                    <div id="hints" class="col-sm-12 hints-box">
                        @if (count($hints) > 0)
                            <h2>Segítségek (összesen {{count($hints)}} db)</h2>
                            <button id="getHint" class="btn btn-primary" onclick="getNewHint()">Új segítség kérése</button>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div id="editor">a = input()
print(a)</div>
                    {{-- <div id="editor">lines = []
while True:
line = input()
if line:
    lines.append(line)
else:
    break
text = '\n'.join(lines)</div> --}}
                    <div id="outputs">
                        <div><p id="output"></p></div>
                        <div><p id="neededOutput"></p></div>
                    </div>

                    <div class="task-timer">
                        <p>Beküldésig: <span id="timer">??:??</span></p>
                    </div>
                </div>
            </div>
        </div>
        
        
        <script src="{{asset('js\ace.js')}}" type="text/javascript" charset="utf-8"></script>
        <script>
            var editor = ace.edit("editor");
            editor.setTheme("ace/theme/dracula");
            editor.session.setMode("ace/mode/python");
            editor.resize();
            editor.setAutoScrollEditorIntoView(true);
            editor.setOption("minLines", 20);
            editor.setOption("maxLines", 40);
        </script>
        
        <script>
            var isProcessRunning = false;
            function test(testID){
                if (!isProcessRunning) {
                    isProcessRunning = true;
                    
                    var img = $('<img id="preloader">');
                    img.attr('src', "{{asset('image/preloader.gif')}}");
                    img.appendTo('#test_'+testID);
                    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '/task/{{$task->id}}/ide/test',
                        type: 'POST',
                        data: {userid: '{{Auth::user()->id ?? -1}}', testID: testID, code: editor.getValue(), lang: "python"},
                        success: function(result){
                            console.log("result: " + result);
                            var json = $.parseJSON(result);
                            
                            if (json.success) {
                                $('#neededOutput').html('Helyes megoldás <i class="fas fa-check-circle"></i>');
                                $('#test_'+testID).css("background-color", "#4f834f");
                            } else {
                                if(json.foundForbiddenExpressions) {
                                    $('#neededOutput').html("");
                                } else {
                                    $('#neededOutput').html("Elvárt output: " + json.test_output);
                                }
                                $('#test_'+testID).css("background-color", "#c53838");
                            }
                            $('#output').html(json.text);
                            $("#preloader").remove();
                            isProcessRunning = false;
                        },
                        error: function(xhr, status, error) {
                            $('#output').html("Error: Timeout");
                            $('#test_'+testID).css("background-color", "#c53838");
                            $('#neededOutput').html("");
                            $("#preloader").remove();
                            isProcessRunning = false;
                        }
                    })
                }
            }
        </script>

        <script>
			let isTaskSubmitted = false;
			
            function submitTask(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/task/{{$task->id}}/ide/submitTask',
                    type: 'POST',
                    data: {userid: '{{Auth::user()->id ?? -1}}', taskid: '{{$task->id}}', code: editor.getValue(), lang: "python", timeLeft: timeLeft ?? 0, usedHintIndex: hintIndex, maxHint: '{{count($hints)}}'},
                    success: function(result){
						isTaskSubmitted = true;
                        var json = $.parseJSON(result);
                        if (json.success) {
                            window.location.href = '/task/{{$task->id}}?submitTask=true';
                        } else {
                            window.location.href = '/task/{{$task->id}}';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                    }
                })
            }
			
			$(window).on("beforeunload", function() { 
				if (!isTaskSubmitted) {
					submitTask()
				}
			})
        </script>

        <script>
            var hintIndex = '{{$usertask->hintIndex ?? 0}}'
            function getNewHint() {
                hintIndex++
                if (hintIndex <= {{count($hints)}}) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '/task/{{$task->id}}/ide/hint',
                        type: 'POST',
                        data: {userid: '{{Auth::user()->id ?? -1}}', taskid: '{{$task->id}}', hintIndex: hintIndex},
                        success: function(result){
                            console.log("result: " + result);
                            $('#hints').append('<div class="hint">#'+hintIndex+' '+result+'</div>');
                        },
                        error: function(xhr, status, error) {
                            console.log(error)
                        }
                    })
                }
                if (hintIndex == {{count($hints)}}) {
                    $('#getHint').addClass("disabled");
                    $('#getHint').text('Nincs több segítség');
                }
            }
        </script>

        <script>
            let timeLeft = '{{$usertask->leftTime ?? 900}}'
            if (timeLeft > 0) { // még nem oldotta meg egyszer sem a feladatot
                var x = setInterval(function() {
                    timeLeft--
                    let min = Math.floor(timeLeft / 60)
                    let sec = timeLeft - (Math.floor(timeLeft / 60)*60)
                    
                    if (sec < 10) sec = "0" + sec;
                    $('#timer').text(min+':'+sec);
                    if (timeLeft <= 0) { // ha lejár az idő, automatán beküldi a megoldást
                        clearInterval(x);
                        submitTask();
                    }
                }, 1000);
            } else { // már megoldotta legalább egyszer a feladatot, ezért nem kell neki countdown timer
                $('.task-timer').remove();
            }
            
        </script>
    </body>
</html>