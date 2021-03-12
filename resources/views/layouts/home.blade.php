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
                        <p>Kezdő, illetve haladó szintű programozók önkéntesen tudják fejleszteni tudásukat. Az oldalon lehetőség van feladatokat létrehozni és megoldani. A megírt kódokat a weboldalon keresztül, online tudják futtatni, így nem szükséges a felhasználó részéről ehhez se erőforrás, se az adott nyelv fordítója.</p>
                    </section>
                    <section>
                        <span>Mi a szerepe a feladat készítésénél a test és a validator mezőknek?</span>
                        <p>Mindkettő egy feladat megoldásánál az algoritmus tesztelésére szolgál. A "test" input-output párok a feladatot megoldó felhasználó számára megjelenített segítség. Ezekkel tudják tesztelni, hogy az algoritmusok a feladat szerint jól lett elkészítve. Ezzel szemben a "validator" input-output párok el vannak rejtve a megoldók elől, ezek a végső ellenőrzésre szolgálnak, ezek alapján kapják a pontokat. Ezzel elkerülhető az esetleges csalás.</p>
                    </section>
                    <section>
                        <span>Mi a szerepe a feladat készítésénél az input és az output mezőknek?</span>
                        <p>Az inputok a feladatok megoldásához szükséges bemeneti értékek. Ezekkel az értékekkel kell dolgoznia a feladatot megoldó felhasználónak és a feladat leírása szerint kell előállítani kimeneti értékeket, azaz outputokat.<br>Ha például a feladatunk egy számnak a négyzetét előállítani és az input 4, akkor az output 16 kell legyen.</p>
                    </section>
                    <section>
                        <span>Mi alapján pontozza az oldal a feladat megoldást?</span>
                        <p>Minden feladaton maximum 100 pont érhető el.<br>Input-output párokért arányosan lehet szerezni 100 pontot. Ha például 4 validator pár van, akkor mindegyikért 25 pont jár.<br>Alapvetően minden feladatra 15 perc áll rendelkezésre. Az első 5 percért nem vesztünk pontot, azonban a maradék 10 percért arányosan maximum 25 pontot veszíthetünk.<br>A feladatoknál lehetőség van segítséget kérni, ennek száma a feladat készítőjétől függ. A segítségek felhasználásáért arányosan maximum 25 pontot lehet veszíteni.</p>
                    </section>
                    <section>
                        <span>Hogyan lehet több soros inputot beolvastatni? (Python)</span>
                        <p>
                            Pythonban két egyszerűbb módja van beolvastatni több sort:
                            <br>
                            <br>
                            1. Az első inputnál megadjuk, hány sorból fog állni az input, majd egy véges ciklussal beolvassuk őket.
                            <br>
                            <img class="viewerjs" src="{{asset('image/python_input_1.png')}}" alt="Több sor beolvasása">
                            <br>
                            <br>
                            2. Végtelen ciklusban olvassuk be az inputok, amíg nem kapunk üres értéket. Hátránya, hogy üres sor esetén (0 karakter hosszú string) megáll a ciklus.
                            <br>
                            <img class="viewerjs" src="{{asset('image/python_input_2.png')}}" alt="Több sor beolvasása">
                        </p>
                    </section>
                    <section>
                        <span></span>
                        <p></p>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>