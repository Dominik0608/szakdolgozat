<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('include/head')
    @include('include/navbar')
    <head>
        <title>{{config('app.title')}} - Főoldal</title>
        <link rel="stylesheet" href="{{asset('css\home.css')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h1>Üdvözöllek a TTKoding oldalán!</h1>
                <div class="tutorial col-sm-12">
                    <section>
                        <span>Mi az oldal lényege?</span>
                        <p>A diploma szerzés.</p>
                    </section>
                    <section>
                        <span>Mi a különbség a feladat készítésénél a test és a validator között?</span>
                        <p>Pont az.</p>
                    </section>
                    <section>
                        <span>Mi a különbség a feladat készítésénél az input és az output között?</span>
                        <p>Igen.</p>
                    </section>
                    <section>
                        <span>Mi alapján pontozza az oldal a feladat megoldást?</span>
                        <p>Igen.</p>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>