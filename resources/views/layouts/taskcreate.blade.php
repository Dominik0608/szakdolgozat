<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <title>{{config('app.title')}} - Feladat készítés</title>
        <link rel="stylesheet" href="{{asset('css\tasks.css')}}">
    </head>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <body>
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-8 background">
                    <form method="POST" action="/tasks" id="taskCreateForm" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-header">Feladat készítése</div>
                        <div class="form-group">
                            <label for="title">Cím</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Leírás</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description') }}" rows="3" placeholder="Minden információ, amire a felhasználónak szüksége lehet." required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Képek</label>
                            <input type="file" class="@error('kép_1') is-invalid @enderror" id="kép_1" name="kép_1" value="{{ old('kép_1') }}" style="display: flex;">
                            @error('kép_1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <input type="file" class="@error('kép_2') is-invalid @enderror" id="kép_2" name="kép_2" value="{{ old('kép_2') }}" style="display: flex;">
                            @error('kép_2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                            <input type="file" class="@error('kép_3') is-invalid @enderror" id="kép_3" name="kép_3" value="{{ old('kép_3') }}" style="display: flex;">
                            @error('kép_3')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tags">Címkék <i>(vesszővel elválasztva)</i></label>
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags') }}">
                            @error('tags')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="test_input[]">Ellenőrzés</label>
                            <textarea class="form-control" id="test_input[]" name="test_input[]" rows="1" placeholder="Test input" required></textarea>
                            <textarea class="form-control" id="test_output[]" name="test_output[]" rows="1" placeholder="Test output" required></textarea>
                            <textarea class="form-control" id="validator_input[]" name="validator_input[]" rows="1" placeholder="Validator input" required></textarea>
                            <textarea class="form-control" id="validator_output[]" name="validator_output[]" rows="1" placeholder="Validator output" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Ellenőrzés</label>
                            <textarea class="form-control" id="test_input[]" name="test_input[]" rows="1" placeholder="Test input" required></textarea>
                            <textarea class="form-control" id="test_output[]" name="test_output[]" rows="1" placeholder="Test output" required></textarea>
                            <textarea class="form-control" id="validator_input[]" name="validator_input[]" rows="1" placeholder="Validator input" required></textarea>
                            <textarea class="form-control" id="validator_output[]" name="validator_output[]" rows="1" placeholder="Validator output" required></textarea>
                        </div>
                        <div id="addTestCase" class="" style=""><i class="fas fa-plus-circle" data-toggle="tooltip" data-placement="top" title="Teszt hozzáadása"></i></div>
                        <div id="addHint" class="" style=""><i class="fas fa-plus-circle" data-toggle="tooltip" data-placement="top" title="Tipp hozzáadása"></i></div>
                        <button type="submit" class="btn btn-primary">Beküldés</button>
                    </form>
                </div>
            </div>
        </div>
    </body>


    <!-- Test hozzáadás/törlés -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script> 

    <script id="testcase-template" type="text/x-handlebars-template">
        <div class="form-group" id="testCase">
            <label>Ellenőrzés <i class="fas fa-times-circle" id="removeTestCase" data-toggle="tooltip" data-placement="top" title="Teszt törlése"></i></label>
            <textarea class="form-control" id="test_input[]" name="test_input[]" rows="1" placeholder="Test input" required></textarea>
            <textarea class="form-control" id="test_output[]" name="test_output[]" rows="1" placeholder="Test output" required></textarea>
            <textarea class="form-control" id="validator_input[]" name="validator_input[]" rows="1" placeholder="Validator input" required></textarea>
            <textarea class="form-control" id="validator_output[]" name="validator_output[]" rows="1" placeholder="Validator output" required></textarea>
        </div>
    </script>
      
    <script type="text/javascript">
        $(document).on('click', '#addTestCase', function(){
            var source = $("#testcase-template").html();
            var template = Handlebars.compile(source);
            var data = {}

            var html = template(data);
            var ezElott = document.getElementById("addTestCase")
            ezElott.insertAdjacentHTML('beforebegin', html);
        });
      
        $(document).on('click', '#removeTestCase', function(event){
            $(this).closest('#testCase').remove();
        });                 
    </script>

    <!-- Test hozzáadás/törlés -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script> 

    <script id="hint-template" type="text/x-handlebars-template">
        <div class="form-group" id="hint">
            <label>Tipp <i class="fas fa-times-circle" id="removeHint" data-toggle="tooltip" data-placement="top" title="Tipp törlése"></i></label>
            <textarea class="form-control" id="hint[]" name="hint[]" rows="1" placeholder="Tipp leírása" required></textarea>
        </div>
    </script>
      
    <script type="text/javascript">
        $(document).on('click', '#addHint', function(){
            var source = $("#hint-template").html();
            var template = Handlebars.compile(source);
            var data = {}

            var html = template(data);
            var ezElott = document.getElementById("addHint")
            ezElott.insertAdjacentHTML('beforebegin', html);
        });
      
        $(document).on('click', '#removeHint', function(event){
            $(this).closest('#hint').remove();
        });                 
    </script>
</html>