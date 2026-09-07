<?php

/*
|--------------------------------------------------------------------------
| PROSTA LISTA ZADAŃ — PHP + MySQL
|--------------------------------------------------------------------------
|
| Ten plik pokazuje, jak:
| 1. Połączyć PHP z bazą danych MySQL,
| 2. Sprawdzić poprawność połączenia,
| 3. Obsługiwać dane przesyłane przez formularz,
| 4. Dodawać nowe zadania do bazy danych,
| 5. Usuwać zadania,
| 6. Pobierać i wyświetlać zadania.
|
| Kod PHP jest wykonywany na serwerze.
| Przeglądarka otrzymuje dopiero gotowy wynik działania programu.
|
*/


/*
|--------------------------------------------------------------------------
| 1. Dane potrzebne do połączenia z bazą danych
|--------------------------------------------------------------------------
|
| Znak "$" oznacza zmienną.
|
| Zmienna jest miejscem, w którym możemy przechowywać określoną wartość.
|
| Przykład:
|
| $imie = "Adam";
|
| "$imie" — nazwa zmiennej,
| "="     — operator przypisania,
| "Adam"  — wartość przypisana do zmiennej,
| ";"     — znak kończący instrukcję.
|
*/


// Adres serwera MySQL.
// "localhost" oznacza, że baza danych znajduje się na tym samym komputerze.
$host = 'localhost';

// Nazwa użytkownika bazy danych.
// W standardowej instalacji XAMPP jest to zazwyczaj "root".
$uzytkownik = 'root';

// Hasło użytkownika bazy danych.
// W domyślnej instalacji XAMPP hasło może być puste.
$haslo = '';

// Nazwa bazy danych utworzonej wcześniej w phpMyAdmin.
$baza = 'nauka_php';


/*
|--------------------------------------------------------------------------
| 2. Połączenie z bazą danych
|--------------------------------------------------------------------------
|
| Funkcja mysqli_connect() służy do nawiązania połączenia
| pomiędzy PHP a bazą danych MySQL.
|
| Funkcja otrzymuje cztery informacje:
|
| 1. Adres serwera,
| 2. Nazwę użytkownika,
| 3. Hasło użytkownika,
| 4. Nazwę bazy danych.
|
| Wynik działania funkcji zapisujemy w zmiennej $polaczenie.
|
*/


$polaczenie = mysqli_connect(
    $host,
    $uzytkownik,
    $haslo,
    $baza
);


/*
|--------------------------------------------------------------------------
| 3. Sprawdzenie połączenia
|--------------------------------------------------------------------------
|
| Instrukcja if oznacza "jeżeli".
|
| Przykładowa konstrukcja:
|
| if (warunek) {
|     instrukcje;
| }
|
| Instrukcje znajdujące się wewnątrz klamr zostaną wykonane,
| jeśli określony warunek będzie prawdziwy.
|
| Znak "!" oznacza zaprzeczenie, czyli "nie".
|
| Warunek !$polaczenie oznacza:
| "jeżeli połączenie nie istnieje".
|
*/


if (!$polaczenie) {
    die('Nie udało się połączyć z bazą danych.');
}


/*
|--------------------------------------------------------------------------
| Ustawienie kodowania znaków
|--------------------------------------------------------------------------
|
| Dzięki ustawieniu kodowania UTF-8 polskie znaki, takie jak:
| ą, ć, ę, ł, ń, ó, ś, ź oraz ż,
| będą poprawnie zapisywane w bazie danych i wyświetlane na stronie.
|
*/

mysqli_set_charset($polaczenie, 'utf8mb4');


/*
|--------------------------------------------------------------------------
| 4. Sprawdzenie metody wysłania formularza
|--------------------------------------------------------------------------
|
| Zmienna $_SERVER zawiera informacje dotyczące bieżącego żądania.
|
| $_SERVER['REQUEST_METHOD'] przechowuje metodę,
| za pomocą której strona została otwarta lub wysłana.
|
| Formularze wysyłające dane zazwyczaj korzystają z metody POST.
|
| Pamiętaj:
|
| "="  — przypisuje wartość,
| "==" — porównuje dwie wartości.
|
| Przykład:
|
| $liczba = 5;       // przypisanie wartości
| $liczba == 5;      // porównanie wartości
|
| Poniższy warunek oznacza:
| "Jeżeli strona została wysłana metodą POST,
| wykonaj instrukcje znajdujące się w klamrach".
|
*/


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    /*
    |--------------------------------------------------------------------------
    | Pobranie danych z formularza
    |--------------------------------------------------------------------------
    |
    | $_POST to specjalna zmienna zawierająca dane przesłane
    | przez formularz metodą POST.
    |
    | ['tresc'] oznacza:
    | "pobierz wartość pola formularza o nazwie tresc".
    |
    | W formularzu znajduje się pole:
    |
    | <input type="text" name="tresc">
    |
    | Atrybut name="tresc" określa nazwę,
    | pod którą wartość pola będzie dostępna w PHP.
    |
    | Dzięki temu możemy odczytać ją za pomocą:
    |
    | $_POST['tresc']
    |
    */


    $tresc = $_POST['tresc'];


    /*
    |--------------------------------------------------------------------------
    | Tworzenie polecenia SQL
    |--------------------------------------------------------------------------
    |
    | Polecenie SQL INSERT INTO służy do dodawania nowych rekordów
    | do tabeli w bazie danych.
    |
    | INSERT INTO zadania
    |
    | oznacza dodanie nowego rekordu do tabeli "zadania".
    |
    | (tresc)
    |
    | określa nazwę kolumny, do której chcemy wpisać dane.
    |
    | VALUES
    |
    | określa wartości, które mają zostać zapisane w tabeli.
    |
    | Zmienna $tresc zawiera tekst wpisany przez użytkownika
    | w formularzu.
    |
    */


    $sql = "INSERT INTO zadania (tresc) VALUES ('$tresc')";


    /*
    |--------------------------------------------------------------------------
    | Wykonanie zapytania SQL
    |--------------------------------------------------------------------------
    |
    | Funkcja mysqli_query() wysyła zapytanie SQL do serwera MySQL.
    |
    | Funkcja otrzymuje dwa argumenty:
    |
    | 1. $polaczenie — połączenie z bazą danych,
    | 2. $sql        — zapytanie SQL, które ma zostać wykonane.
    |
    | Wynik wykonania zapytania zapisujemy w zmiennej $wynik.
    |
    */


    $wynik = mysqli_query($polaczenie, $sql);
}


/*
|--------------------------------------------------------------------------
| 5. Usuwanie zadania
|--------------------------------------------------------------------------
|
| Zadanie będziemy usuwać za pomocą parametru przekazanego
| w adresie strony.
|
| Przykład:
|
| index.php?usun=3
|
| Znak "?" rozpoczyna listę parametrów adresu.
|
| "usun=3" oznacza, że:
|
| - nazwa parametru to "usun",
| - wartość parametru to "3".
|
| Parametry znajdujące się w adresie są dostępne w PHP
| za pomocą specjalnej tablicy $_GET.
|
| Funkcja isset() sprawdza, czy określony parametr istnieje.
|
| Przykład:
|
| isset($_GET['usun'])
|
| oznacza:
| "sprawdź, czy w adresie istnieje parametr o nazwie usun".
|
*/


if (isset($_GET['usun'])) {

    /*
    |--------------------------------------------------------------------------
    | Pobranie identyfikatora zadania
    |--------------------------------------------------------------------------
    |
    | Pobieramy identyfikator zadania z adresu strony.
    |
    | Jeżeli adres wygląda tak:
    |
    | index.php?usun=3
    |
    | to wartość parametru "usun" wynosi 3.
    | Ta wartość zostanie zapisana w zmiennej $id.
    |
    */


    $id = (int) $_GET['usun'];


    /*
    |--------------------------------------------------------------------------
    | Tworzenie polecenia usuwającego rekord
    |--------------------------------------------------------------------------
    |
    | Polecenie DELETE służy do usuwania rekordów z tabeli.
    |
    | DELETE FROM zadania
    |
    | oznacza usunięcie rekordu z tabeli "zadania".
    |
    | WHERE określa warunek, który musi zostać spełniony.
    |
    | id = $id
    |
    | oznacza, że zostanie usunięty rekord
    | o identyfikatorze zapisanym w zmiennej $id.
    |
    | Jeżeli $id wynosi 3, MySQL otrzyma zapytanie:
    |
    | DELETE FROM zadania WHERE id = 3
    |
    */


    $sql = "DELETE FROM zadania WHERE id=$id";


    /*
    |--------------------------------------------------------------------------
    | Wykonanie polecenia usuwającego
    |--------------------------------------------------------------------------
    |
    | Wysyłamy przygotowane polecenie SQL do serwera MySQL.
    |
    */


    $wynik = mysqli_query($polaczenie, $sql);
}


/*
|--------------------------------------------------------------------------
| 6. Pobranie wszystkich zadań
|--------------------------------------------------------------------------
|
| Polecenie SELECT służy do pobierania danych z tabeli.
|
| Znak "*" oznacza wszystkie kolumny.
|
| FROM oznacza, z której tabeli mają zostać pobrane dane.
|
| Zapytanie:
|
| SELECT * FROM zadania
|
| oznacza:
| "pobierz wszystkie kolumny ze wszystkich rekordów
| znajdujących się w tabeli zadania".
|
*/


$sql = "SELECT * FROM zadania";


/*
|--------------------------------------------------------------------------
| Wykonanie zapytania pobierającego dane
|--------------------------------------------------------------------------
|
| Wysyłamy zapytanie do serwera MySQL.
|
| Tym razem wynik zapytania będzie nam potrzebny,
| ponieważ zawiera pobrane zadania.
|
| Dlatego zapisujemy go w zmiennej $wynik.
|
*/


$wynik = mysqli_query($polaczenie, $sql);


/*
|--------------------------------------------------------------------------
| Koniec pierwszego fragmentu PHP
|--------------------------------------------------------------------------
|
| Znacznik:
|
| ?>
|
| oznacza zakończenie tego fragmentu kodu PHP.
|
| Od następnej linii będziemy pisać kod HTML,
| który odpowiada za strukturę strony.
|
*/

?>

<!DOCTYPE html>
<html lang="pl">

<head>

    <meta charset="UTF-8">

    <title>Moja lista zadań</title>

</head>

<body>

    <h1>Moja lista zadań</h1>

    <!--
    |--------------------------------------------------------------------------
    | 7. Formularz HTML
    |--------------------------------------------------------------------------
    |
    | Od tego miejsca znajdujemy się w zwykłym kodzie HTML.
    |
    | Znacznik <form> tworzy formularz.
    |
    | Atrybut method="POST" określa sposób przesyłania danych
    | do kodu PHP.
    |
    | Po kliknięciu przycisku "Dodaj" przeglądarka wyśle dane
    | z formularza do serwera metodą POST.
    |
    -->

    <form method="POST">

        <!--
        |
        | Znacznik <label> tworzy opis pola formularza.
        | Informuje użytkownika, jakie dane powinien wpisać.
        |
        -->

        <label>Wpisz nowe zadanie</label>


        <!--
        |--------------------------------------------------------------------------
        | Pole tekstowe formularza
        |--------------------------------------------------------------------------
        |
        | Znacznik <input> tworzy pole formularza.
        |
        | type="text" oznacza standardowe pole tekstowe,
        | w którym użytkownik może wpisać tekst.
        |
        | name="tresc" określa nazwę tego pola.
        |
        | Atrybut name jest bardzo ważny, ponieważ dzięki niemu
        | PHP może odczytać przesłaną wartość.
        |
        | W tym przypadku wartość będzie dostępna jako:
        |
        | $_POST['tresc']
        |
        | Nazwa "tresc" w formularzu musi być taka sama
        | jak nazwa użyta później w kodzie PHP.
        |
        -->

        <input type="text" name="tresc">


        <!--
        |--------------------------------------------------------------------------
        | Przycisk wysyłający formularz
        |--------------------------------------------------------------------------
        |
        | type="submit" oznacza przycisk wysyłający formularz.
        |
        | Po jego kliknięciu dane zostaną przesłane do PHP.
        |
        -->

        <button type="submit">Dodaj</button>

    </form>


<?php

/*
|--------------------------------------------------------------------------
| 8. Ponowne rozpoczęcie kodu PHP
|--------------------------------------------------------------------------
|
| Znacznik <?php oznacza, że od tego miejsca ponownie
| rozpoczyna się wykonywanie kodu PHP.
|
*/


/*
|--------------------------------------------------------------------------
| 9. Pętla while
|--------------------------------------------------------------------------
|
| Pętla while wykonuje instrukcje tak długo,
| jak długo określony warunek jest prawdziwy.
|
| Przykład:
|
| while (warunek) {
|     instrukcje;
| }
|
| W naszym przypadku pętla będzie służyła do przechodzenia
| przez wszystkie zadania pobrane z bazy danych.
|
| mysqlo_fetch_assoc($wynik)
|
| pobiera JEDEN kolejny rekord z wyników naszego SELECT
|
| Jeżeli tabela zawiera
|
| id  |  tresc
|  1  | Nauczyć się PHP
|  2  | Zrobić zadanie
|  3  | Kupić kabel
|      
| pętla wykona się trzy razy
| za każdym razem zmienna $zadanie
| będzie zawierało jeden rekord.
|
| Pierwszy obrót:
| 
| $zadanie("id")     -> 1
| $zadanie("tresc")  -> Nauczyć się PHP
|
| Drugi obrót:
| 
| $zadanie("id")     -> 2
| $zadanie("tresc")  -> Zrobić zadanie
|
| itd.
*/

while ($zadanie = mysqli_fetch_assoc($wynik)) {

    /*
    | echo jest poleceniem PHP
    | które wyświetla coś na stronie
    |
    | ("tresc") oznacza:
    | pobierz wartośc kolumny "tresc"
    | z aktualnego rekordu
    */

    echo $zadanie("tresc");

    /*
        teraz tworzymy link "Usun"
        <a href="..."> jest znacznikiem HTML tworzącym odnośnik

        Problem polega na tym ze czesc adresu
        jest zwykłym tekstem
        a cześć pochodzi ze zmiennej PHP

        Operator:

        . = oznacza w PHP łacznie tekstów

        Przykład:

        "JAN" . " Kowalski"

        da:

        JAN Kowalski

        dlatego poniżej łaczymy:

        "index.php?usun="

        z:

        $zadanie("id")

        Jeżeli id wynosi 3 powstaje

        index.php?usun=3
    */

    echo " <a href='index.php?usun=" . $zadanie("id") . "'Usuń</a>";

    /*
        <br> jest znacznikiem HTML
        oznaczającym przejście do nowej linii

        PHP za pomocą echo może również
        wysyłać do przeglądarki kod HTML
    */

    echo "<br>";

}

/*
 10. zamkniecie połaczenia
*/
