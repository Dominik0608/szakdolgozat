<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <link rel="stylesheet" href="{{asset('css\tasks.css')}}">
    </head>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <script type="text/javascript" src="{{ asset('js/taskcreate.js') }}"></script>
    <body>
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-8 background">
                    <form method="POST" action="/tasks" id="taskCreateForm">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="title">Cím</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Leírás</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description') }}" rows="3" placeholder="Minden információ, amire a felhasználónak szüksége lehet.">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="test_input[0]">Ellenőrzés</label>
                            <textarea class="form-control @error('test_input.0') is-invalid @enderror" id="test_input[0]" name="test_input[0]" rows="1" placeholder="Test input">{{ old('test_input.0') }}</textarea>
                            @error('test_input.0')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <textarea class="form-control @error('test_output.0') is-invalid @enderror" id="test_output[0]" name="test_output[0]" rows="1" placeholder="Test output">{{ old('test_output.0') }}</textarea>
                            @error('test_output.0')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <textarea class="form-control @error('validator_input.0') is-invalid @enderror" id="validator_input[0]" name="validator_input[0]" rows="1" placeholder="Validator input">{{ old('validator_input.0') }}</textarea>
                            @error('validator_input.0')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <textarea class="form-control @error('validator_output.0') is-invalid @enderror" id="validator_output[0]" name="validator_output[0]" rows="1" placeholder="Validator output">{{ old('validator_output.0') }}</textarea>
                            @error('validator_output.0')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!--
                        <div class="form-group">
                            <label for="test_input[1]">Ellenőrzés</label>
                            <textarea class="form-control @error('test_input.1') is-invalid @enderror" id="test_input[1]" name="test_input[1]" rows="1" placeholder="Test input">{{ old('test_input.1') }}</textarea>
                            @error('test_input.1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <textarea class="form-control @error('test_output.1') is-invalid @enderror" id="test_output[1]" name="test_output[1]" rows="1" placeholder="Test output">{{ old('test_output.1') }}</textarea>
                            @error('test_output.1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <textarea class="form-control @error('validator_input.1') is-invalid @enderror" id="validator_input[1]" name="validator_input[1]" rows="1" placeholder="Validator input">{{ old('validator_input.1') }}</textarea>
                            @error('validator_input.1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <textarea class="form-control @error('validator_output.1') is-invalid @enderror" id="validator_output[1]" name="validator_output[1]" rows="1" placeholder="Validator output">{{ old('validator_output.1') }}</textarea>
                            @error('validator_output.1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        -->
                        <div id="addTestCase" class="" style="float: right;"><i class="fas fa-plus-circle"></i></div>
                        <button type="submit" class="btn btn-primary">Beküldés</button>
                    </form>
                </div>
            </div>
        </div>
    </body>

    <script src="//code.jquery.com/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script> 

    <script id="document-template" type="text/x-handlebars-template">
        <div class="form-group">
            <label for="test_input[1]">Ellenőrzés</label>
            <textarea class="form-control @error('test_input.1') is-invalid @enderror" id="test_input[1]" name="test_input[1]" rows="1" placeholder="Test input">{{ old('test_input.1') }}</textarea>
            @error('test_input.1')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <textarea class="form-control @error('test_output.1') is-invalid @enderror" id="test_output[1]" name="test_output[1]" rows="1" placeholder="Test output">{{ old('test_output.1') }}</textarea>
            @error('test_output.1')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <textarea class="form-control @error('validator_input.1') is-invalid @enderror" id="validator_input[1]" name="validator_input[1]" rows="1" placeholder="Validator input">{{ old('validator_input.1') }}</textarea>
            @error('validator_input.1')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <textarea class="form-control @error('validator_output.1') is-invalid @enderror" id="validator_output[1]" name="validator_output[1]" rows="1" placeholder="Validator output">{{ old('validator_output.1') }}</textarea>
            @error('validator_output.1')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
       </script>
      
      <script type="text/javascript">
       
       $(document).on('click','#addTestCase',function(){
            var test_input = $("#test_input").val();
            
            var source = $("#document-template").html();
            console.log(source);
            var template = Handlebars.compile(source);

            var data = {
                test_input: test_input,
            }

            var html = template(data);
            console.log(html);
            $("#taskCreateForm").append(html)

            total_ammount_price();
       });
      
        $(document).on('click','.removeaddmore',function(event){
          $(this).closest('.delete_add_more_item').remove();
          total_ammount_price();
        });
      
        function total_ammount_price() {
          var sum = 0;
          $('.cost').each(function(){
            var value = $(this).val();
            if(value.length != 0)
            {
              sum += parseFloat(value);
            }
          });
          $('#estimated_ammount').val(sum);
        }
                             
      </script>
</html>