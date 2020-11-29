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
                        <p>Kezdő, illetve haladó szintű programozók önkéntesen tudják fejleszteni tudásukat.</p>
                    </section>
                    <section>
                        <span>Mi a különbség a feladat készítésénél a test és a validator között?</span>
                        <p>Mindkettő egy feladat megoldásánál az algoritmus tesztelésére szolgál. A "test" input-output párok a feladatot megoldó felhasználó számára megjelenített segítség. Ezekkel tudják tesztelni, hogy az algoritmusok a feladat szerint jól lett elkészítve. Ezzel szemben a "validator" input-output párok el vannak rejtve a megoldók elől, ezek a végső ellenőrzésre szolgálnak, ezek alapján kapják a pontokat. Ezzel elkerülhető az esetleges csalás.</p>
                    </section>
                    <section>
                        <span>Mi a különbség a feladat készítésénél az input és az output között?</span>
                        <p>Az inputok a feladatok megoldásához szükséges bemeneti értékek. Ezekkel az értékekkel kell dolgoznia a feladatot megoldó felhasználónak és a feladat leírása szerint kell előállítani kimeneti értékeket, azaz outputokat.<br>Ha például a feladatunk egy számnak a négyzetét előállítani és az input 4, akkor az output 16 kell legyen.</p>
                    </section>
                    <section>
                        <span>Mi alapján pontozza az oldal a feladat megoldást?</span>
                        <p>Minden feladaton maximum 100 pont érhető el.<br>Input-output párokért arányosan lehet szerezni 100 pontot. Ha például 4 validator pár van, akkor mindegyikért 25 pont jár.<br>Alapvetően minden feladatra 15 perc áll rendelkezésre. Az első 5 percért nem vesztünk pontot, azonban a maradék 10 percért arányosan maximum 25 pontot veszíthetünk.<br>A feladatoknál lehetőség van segítséget kérni, ennek száma a feladat készítőjétől függ. A segítségek felhasználásáért arányosan maximum 25 pontot lehet veszíteni.</p>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>