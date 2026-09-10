<?php

// ============================================================
//                 PROSTA LISTA ZADAŃ
//                    PHP + MySQL
// ============================================================
//
// Znacznik <?php oznacza:
// "od tego miejsca zaczyna się kod języka PHP".
//
// Kod PHP jest wykonywany na SERWERZE.
// Przeglądarka nie wykonuje tego kodu bezpośrednio.
// PHP wykonuje polecenia, a do przeglądarki wysyła gotowy wynik.
//
// W tym programie będziemy:
// 1. łączyć się z bazą danych,
// 2. dodawać zadania,
// 3. pobierać zadania z bazy,
// 4. wyświetlać je,
// 5. usuwać wybrane zadania.
//
// ============================================================



// ============================================================
// 1. ZMIENNE I DANE POTRZEBNE DO POŁĄCZENIA Z BAZĄ
// ============================================================
//
// Znak $ oznacza w PHP ZMIENNĄ.
//
// Zmienna to miejsce, w którym możemy przechowywać jakąś wartość.
//
// Przykład:
//
// $imie = "Adam";
//
// $imie      - nazwa zmiennej
// =          - operator przypisania
// "Adam"     - wartość, którą zapisujemy w zmiennej
// ;          - średnik kończy instrukcję PHP
//
// Czytamy to:
// "do zmiennej imie przypisz tekst Adam".
//
// Tekst zapisujemy pomiędzy cudzysłowami " ".
//

$host = "localhost";

// localhost oznacza:
// "ten komputer".
//
// Nasz serwer WWW i serwer MySQL działają
// na tym samym komputerze.


$uzytkownik = "root";

// Nazwa użytkownika bazy danych.
// W typowej instalacji XAMPP użytkownik nazywa się root.


$haslo = "";

// Puste cudzysłowy "" oznaczają pusty tekst.
// Czyli w tym przykładzie nie podajemy hasła.


$baza = "nauka_php";

// Jest to nazwa bazy danych,
// którą wcześniej utworzyliśmy w phpMyAdmin.



// ============================================================
// 2. ŁĄCZENIE PHP Z BAZĄ MYSQL
// ============================================================
//
// mysqli_connect() jest gotową FUNKCJĄ języka PHP.
//
// Funkcja wykonuje określone zadanie.
//
// Nawiasy:
//
// ( )
//
// służą tutaj do przekazania funkcji informacji,
// których potrzebuje.
//
// Funkcji mysqli_connect przekazujemy cztery informacje:
//
// 1. adres serwera
// 2. użytkownika
// 3. hasło
// 4. nazwę bazy
//
// Poszczególne wartości oddzielamy PRZECINKAMI.
//
// Czyli:
//
// mysqli_connect($host, $uzytkownik, $haslo, $baza)
//
// oznacza:
//
// "połącz się z serwerem zapisanym w $host,
// używając użytkownika $uzytkownik,
// hasła $haslo
// i bazy $baza".
//
// Wynik działania funkcji zapisujemy w zmiennej
// $polaczenie.
//
// Znak = oznacza:
// "przypisz wynik po prawej stronie
// do zmiennej po lewej stronie".

$polaczenie = mysqli_connect($host, $uzytkownik, $haslo, $baza);



// ============================================================
// 3. SPRAWDZENIE, CZY POŁĄCZENIE SIĘ UDAŁO
// ============================================================
//
// if oznacza "JEŻELI".
//
// Konstrukcja:
//
// if (warunek) {
//     instrukcje
// }
//
// oznacza:
//
// JEŻELI warunek jest spełniony,
// wykonaj instrukcje znajdujące się pomiędzy { }.
//
// Nawiasy klamrowe:
//
// { }
//
// wyznaczają początek i koniec grupy instrukcji.
//
// Znak:
//
// !
//
// oznacza negację, czyli można go czytać jako "NIE".
//
// !$polaczenie
//
// oznacza więc:
//
// "jeżeli NIE ma połączenia".

if (!$polaczenie) {

    // die() kończy działanie programu.
    //
    // Tekst znajdujący się pomiędzy:
    //
    // " "
    //
    // zostanie wyświetlony użytkownikowi.

    die("Nie udało się połączyć z bazą danych.");
}



// Jeżeli program dotarł do tego miejsca,
// oznacza to, że połączenie z bazą działa.



// ============================================================
// 4. SPRAWDZENIE, CZY UŻYTKOWNIK WYSŁAŁ FORMULARZ
// ============================================================
//
// $_SERVER jest specjalną zmienną PHP.
//
// Znaki:
//
// [ ]
//
// pozwalają pobrać konkretną informację
// znajdującą się wewnątrz tej zmiennej.
//
// $_SERVER["REQUEST_METHOD"]
//
// mówi nam, jaką metodą została otwarta/wysłana strona.
//
// Formularz, który stworzymy niżej,
// będzie używał metody POST.
//
// Operator:
//
// ==
//
// oznacza PORÓWNANIE.
//
// UWAGA:
//
// =    przypisuje wartość
// ==   porównuje dwie wartości
//
// Czyli:
//
// $x = 5;
//
// oznacza:
// "wstaw 5 do zmiennej x".
//
// Natomiast:
//
// $x == 5
//
// oznacza:
// "czy wartość x jest równa 5?"
//
// Cały poniższy warunek oznacza:
//
// "JEŻELI strona została wysłana metodą POST,
// wykonaj instrukcje znajdujące się w { }".

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // $_POST zawiera dane przesłane przez formularz.
    //
    // ["tresc"] oznacza:
    // pobierz pole formularza o nazwie "tresc".
    //
    // Za chwilę w HTML utworzymy:
    //
    // <input type="text" name="tresc">
    //
    // Właśnie name="tresc" powoduje,
    // że PHP może później odczytać:
    //
    // $_POST["tresc"]

    $tresc = $_POST["tresc"];


    // --------------------------------------------------------
    // TWORZENIE POLECENIA SQL
    // --------------------------------------------------------
    //
    // Polecenie SQL:
    //
    // INSERT INTO
    //
    // oznacza:
    //
    // "dodaj nowy rekord do tabeli".
    //
    // zadania
    //
    // to nazwa naszej tabeli.
    //
    // (tresc)
    //
    // określa kolumnę, do której chcemy coś wpisać.
    //
    // VALUES
    //
    // oznacza wartości, które chcemy zapisać.
    //
    // $tresc jest zmienną PHP zawierającą tekst
    // wpisany przez użytkownika.

    $sql = "INSERT INTO zadania (tresc) VALUES ('$tresc')";


    // mysqli_query() wysyła polecenie SQL
    // do serwera MySQL.
    //
    // Funkcja otrzymuje dwie informacje:
    //
    // $polaczenie - z jakiej bazy korzystamy
    // $sql        - jakie polecenie SQL ma wykonać

    mysqli_query($polaczenie, $sql);
}



// ============================================================
// 5. USUWANIE ZADANIA
// ============================================================
//
// Zadanie będziemy usuwać za pomocą adresu:
//
// index.php?usun=3
//
// Znak:
//
// ?
//
// w adresie rozpoczyna PARAMETRY adresu.
//
// usun=3
//
// oznacza:
// parametr "usun" ma wartość 3.
//
// PHP może odczytać parametry z adresu
// za pomocą specjalnej zmiennej:
//
// $_GET
//
// Czyli:
//
// $_GET["usun"]
//
// dla adresu:
//
// index.php?usun=3
//
// będzie zawierało wartość 3.
//
// ------------------------------------------------------------
//
// isset() sprawdza, czy dana wartość istnieje.
//
// Czyli:
//
// isset($_GET["usun"])
//
// oznacza:
//
// "czy w adresie istnieje parametr usun?"

if (isset($_GET["usun"])) {


    // Pobieramy numer rekordu z adresu.
    //
    // Jeżeli adres wygląda tak:
    //
    // index.php?usun=3
    //
    // to do zmiennej $id trafi liczba 3.

    $id = $_GET["usun"];


    // DELETE oznacza usuwanie rekordu.
    //
    // FROM zadania
    //
    // oznacza:
    // "z tabeli zadania".
    //
    // WHERE oznacza WARUNEK.
    //
    // id=$id
    //
    // określa, który rekord ma zostać usunięty.
    //
    // Jeżeli $id wynosi 3,
    // MySQL otrzyma:
    //
    // DELETE FROM zadania WHERE id=3

    $sql = "DELETE FROM zadania WHERE id=$id";


    // Wysyłamy przygotowane polecenie do MySQL.

    mysqli_query($polaczenie, $sql);
}



// ============================================================
// 6. POBRANIE WSZYSTKICH ZADAŃ
// ============================================================
//
// SELECT oznacza:
// "pobierz dane".
//
// Znak:
//
// *
//
// oznacza:
// "wszystkie kolumny".
//
// FROM oznacza:
// "z tabeli".
//
// Czyli:
//
// SELECT * FROM zadania
//
// czytamy:
//
// "pobierz wszystkie kolumny
// ze wszystkich rekordów tabeli zadania".

$sql = "SELECT * FROM zadania";


// Wysyłamy zapytanie do MySQL.
//
// Tym razem wynik jest nam potrzebny,
// dlatego zapisujemy go w zmiennej $wynik.

$wynik = mysqli_query($polaczenie, $sql);



// ============================================================
// KONIEC PIERWSZEGO FRAGMENTU PHP
// ============================================================
//
// Znacznik:
//
// ?>
//
// oznacza:
// "w tym miejscu kończy się kod PHP".
//
// Od następnej linii będziemy pisać zwykły HTML.

?>


<!DOCTYPE html>

<html lang="pl">

<head>

    <meta charset="UTF-8">

    <title>Moja lista zadań</title>

</head>

<body>


<h1>Moja lista zadań</h1>


<!-- =========================================================
     7. FORMULARZ HTML
     =========================================================

     To NIE JEST PHP.

     Jesteśmy teraz w zwykłym HTML.

     <form> oznacza formularz.

     method="POST"

     określa sposób przesłania danych do PHP.

     Po kliknięciu przycisku "Dodaj"
     przeglądarka wyśle dane metodą POST.
-->

<form method="POST">


    <!--
        <label> jest opisem pola formularza.
    -->

    <label>Wpisz nowe zadanie:</label>


    <!--
        <input> tworzy pole tekstowe.

        type="text"

        oznacza zwykłe pole do wpisywania tekstu.

        name="tresc"

        jest BARDZO WAŻNE.

        To nazwa, pod którą przesłana wartość
        będzie dostępna w PHP.

        Dlatego PHP może użyć:

        $_POST["tresc"]

        Nazwa "tresc" musi się zgadzać.
    -->

    <input type="text" name="tresc">


    <!--
        type="submit"

        oznacza przycisk wysyłający formularz.
    -->

    <button type="submit">Dodaj</button>


</form>



<h2>Zapisane zadania</h2>


<?php

// ============================================================
// 8. PONOWNIE WCHODZIMY DO PHP
// ============================================================
//
// <?php oznacza, że od tego miejsca
// ponownie wykonujemy kod PHP.



// ============================================================
// 9. PĘTLA WHILE
// ============================================================
//
// while oznacza:
// "wykonuj coś TAK DŁUGO, jak warunek jest prawdziwy".
//
// mysqli_fetch_assoc($wynik)
//
// pobiera JEDEN kolejny rekord
// z wyników naszego SELECT.
//
// Jeżeli tabela zawiera:
//
// id | tresc
// --------------------------
// 1  | Nauczyć się PHP
// 2  | Zrobić zadanie
// 3  | Kupić kabel
//
// pętla wykona się trzy razy.
//
// Za każdym razem zmienna $zadanie
// będzie zawierała jeden rekord.
//
// Pierwszy obrót:
//
// $zadanie["id"]    -> 1
// $zadanie["tresc"] -> Nauczyć się PHP
//
// Drugi obrót:
//
// $zadanie["id"]    -> 2
// $zadanie["tresc"] -> Zrobić zadanie
//
// itd.

while ($zadanie = mysqli_fetch_assoc($wynik)) {


    // echo jest poleceniem PHP,
    // które WYŚWIETLA coś na stronie.
    //
    // ["tresc"] oznacza:
    // pobierz wartość kolumny "tresc"
    // z aktualnego rekordu.

    echo $zadanie["tresc"];


    // Teraz tworzymy link "Usuń".
    //
    // <a href="..."> jest znacznikiem HTML
    // tworzącym odnośnik.
    //
    // Problem polega na tym, że część adresu
    // jest zwykłym tekstem,
    // a część pochodzi ze zmiennej PHP.
    //
    // Operator:
    //
    // .
    //
    // oznacza w PHP ŁĄCZENIE TEKSTÓW.
    //
    // Przykład:
    //
    // "Jan" . " Kowalski"
    //
    // da:
    //
    // Jan Kowalski
    //
    // Dlatego poniżej łączymy:
    //
    // "index.php?usun="
    //
    // z:
    //
    // $zadanie["id"]
    //
    // Jeżeli id wynosi 5,
    // powstanie:
    //
    // index.php?usun=5

    echo " <a href='index.php?usun=" . $zadanie["id"] . "'>Usuń</a>";


    // <br> jest znacznikiem HTML
    // oznaczającym przejście do nowej linii.
    //
    // PHP za pomocą echo może również
    // wysyłać do przeglądarki kod HTML.

    echo "<br>";
}



// ============================================================
// 10. ZAMKNIĘCIE POŁĄCZENIA
// ============================================================
//
// mysqli_close() zamyka wcześniej utworzone
// połączenie z bazą danych.
//
// Do funkcji przekazujemy zmienną $polaczenie,
// ponieważ właśnie to połączenie chcemy zamknąć.

mysqli_close($polaczenie);

?>


</body>

</html>

<!--
DODATKOWE INFORMACJE:
PODSTAWOWE ZNAKI I ZAPISY W PHP
================================

$
Początek nazwy zmiennej w PHP.
Przykład:
$imie = "Adam";


=
Operator przypisania.
Przypisuje wartość znajdującą się po prawej stronie do zmiennej po lewej stronie.
Przykład:
$wiek = 18;


==
Operator porównania.
Sprawdza, czy dwie wartości są równe.
Przykład:
$wiek == 18


!
Oznacza negację, czyli „NIE”.
Przykład:
!$polaczenie
Możemy to przeczytać jako: „nie ma połączenia”.


;
Średnik oznacza koniec instrukcji PHP.
Przykład:
$imie = "Adam";


()
Nawiasy okrągłe.
Są używane między innymi przy funkcjach i warunkach.
Przykład funkcji:
mysqli_connect(...)

Przykład warunku:
if ($wiek == 18)


{ }
Nawiasy klamrowe.
Oznaczają początek i koniec bloku instrukcji.
Przykład:
if ($wiek == 18) {
    echo "Masz 18 lat";
}


[ ]
Nawiasy kwadratowe.
Pozwalają dostać się do konkretnego elementu tablicy lub innej struktury danych.
Przykład:
$_POST["tresc"]

Oznacza:
pobierz element o nazwie „tresc” z danych przesłanych metodą POST.


" "
Cudzysłowy oznaczają tekst.
Przykład:
$imie = "Adam";


' '
Apostrofy również mogą oznaczać tekst.
Przykład:
$imie = 'Adam';


.
Kropka w PHP służy do łączenia tekstów.
Przykład:
$imie = "Adam";
echo "Witaj " . $imie;

Wynik:
Witaj Adam


,
Przecinek służy między innymi do oddzielania argumentów przekazywanych do funkcji.
Przykład:
mysqli_connect($host, $uzytkownik, $haslo, $baza);


*
Gwiazdka może mieć różne znaczenia.

W zapytaniu:
SELECT * FROM zadania

oznacza:
pobierz wszystkie kolumny z tabeli „zadania”.


<?php
Znacznik rozpoczynający kod PHP.

Wszystko po tym znaczniku jest traktowane jako kod PHP aż do zakończenia kodu znacznikiem ?>.


?>
Znacznik kończący kod PHP.

Po nim możemy ponownie pisać zwykły kod HTML.


$_POST
Specjalna zmienna PHP zawierająca dane przesłane przez formularz metodą POST.

Jeżeli w HTML mamy:
<input type="text" name="tresc">

to w PHP możemy odczytać wpisaną wartość za pomocą:
$_POST["tresc"]


$_GET
Specjalna zmienna PHP zawierająca dane przekazane w adresie strony.

Przykładowy adres:
index.php?usun=5

W PHP możemy odczytać liczbę 5 za pomocą:
$_GET["usun"]


// 
Początek komentarza jednoliniowego.

Komentarz nie jest wykonywany przez PHP.
Służy do umieszczania opisów i wyjaśnień w kodzie.

Przykład:
// To jest komentarz
$wiek = 18;


/*
 ...
 */
Komentarz wieloliniowy.

Wszystko pomiędzy /* oraz */ jest komentarzem i nie zostanie wykonane przez PHP.

Przykład:
/*
To jest komentarz
zajmujący kilka
linii.
*/


echo
Polecenie służące do wyświetlania informacji na stronie.

Przykład:
echo "Witaj świecie";


if
Instrukcja warunkowa.
Możemy ją rozumieć jako „JEŻELI”.

Przykład:
if ($wiek == 18) {
    echo "Masz 18 lat";
}


while
Pętla.
Powtarza określone instrukcje tak długo, jak długo podany warunek jest spełniony.

Przykład:
while (...) {
    // instrukcje wykonywane wielokrotnie
}


die()
Kończy wykonywanie programu PHP.

Przykład:
die("Wystąpił błąd");


isset()
Sprawdza, czy dana zmienna lub wartość istnieje.

Przykład:
isset($_GET["usun"])

Możemy to przeczytać jako:
„sprawdź, czy istnieje parametr usun”.


mysqli_connect()
Funkcja służąca do połączenia PHP z bazą danych MySQL.

Przykład:
mysqli_connect($host, $uzytkownik, $haslo, $baza);


mysqli_query()
Funkcja wysyłająca polecenie SQL do bazy danych.

Przykład:
mysqli_query($polaczenie, $sql);


mysqli_fetch_assoc()
Funkcja pobierająca kolejny rekord z wyniku zapytania do bazy danych.

Przykład:
$zadanie = mysqli_fetch_assoc($wynik);


mysqli_close()
Funkcja zamykająca połączenie z bazą danych.

Przykład:
mysqli_close($polaczenie);
-->