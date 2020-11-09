<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <title>{{config('app.title')}} - Profil módosítás</title>
        <link rel="stylesheet" href="{{asset('css\auth.css')}}">
    </head>
    <body>
        <div class="container">
            @if ( Auth::check() )
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Profil módosítás</div>

                            <div class="card-body">
                                <form method="POST" action="/user/{{ Auth::user()->name }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="form-group row">
                                        <label for="school" class="col-md-4 col-form-label text-md-right">{{ __('Iskola') }}</label>

                                        <div class="col-md-6">
                                            <input id="school" type="text" class="form-control @error('school') is-invalid @enderror" name="school" value="{{ old('school') ?? Auth::user()->school }}" autocomplete="school" autofocus>

                                            @error('school')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Mentés') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            <div class="alert alert-danger" role="alert">
                Nem vagy bejelentkezve!
            </div>
            @endif
        </div>
    </body>
</html>