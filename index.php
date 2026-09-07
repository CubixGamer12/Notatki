<?php

/*
|--------------------------------------------------------------------------
| PROSTA LISTA ZADAŃ — PHP + MySQL
|--------------------------------------------------------------------------
|
| Ten plik pokazuje, jak:
| 1. Połączyć PHP z bazą danych MySQL,
| 2. Sprawdzić poprawność połączenia,
| 3. Obsługiwać dane przesyłane przez formularz.
|
| Kod PHP jest wykonywany na serwerze. Przeglądarka otrzymuje dopiero
| gotowy wynik działania programu.
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
| Funkcja mysqli_connect() przyjmuje cztery wartości:
|
| 1. Adres serwera,
| 2. Nazwę użytkownika,
| 3. Hasło,
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
| Instrukcja if oznacza: "jeżeli".
|
| Zapis:
|
| if (warunek) {
|     instrukcje;
| }
|
| oznacza, że instrukcje znajdujące się wewnątrz klamr zostaną wykonane,
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
| Dzięki temu polskie znaki, takie jak ą, ć, ę, ł, ń, ó, ś, ź oraz ż,
| będą poprawnie zapisywane i wyświetlane.
*/

mysqli_set_charset($polaczenie, 'utf8mb4');


/*
|--------------------------------------------------------------------------
| 4. Sprawdzenie metody wysłania formularza
|--------------------------------------------------------------------------
|
| Zmienna $_SERVER zawiera informacje dotyczące bieżącego żądania.
|
| $_SERVER['REQUEST_METHOD'] przechowuje metodę, za pomocą której
| została otwarta lub wysłana strona.
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
| Cały poniższy warunek oznacza:
| "JEŻELI strona została wysłana metodą POST, wykonaj instrukcje
| znajdujące się w { }".
|
*/


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    /*
    | $_POST zawiera dane przesłane przez formularz.
    |
    | ['tresc'] oznacza:
    | pobierz pole formularza o nazwie "tresc".
    |
    | Za chwilę w HTML utworzymy:
    |
    | <input type="text" name="tresc">
    |
    | Właśnie name="tresc" powoduje, że PHP może później odczytać:
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
    | Polecenie SQL:
    |
    | INSERT INTO
    |
    | oznacza: "dodaj nowy rekord do tabeli".
    |
    | "zadania" to nazwa naszej tabeli.
    |
    | "(tresc)" określa kolumnę, do której chcemy coś wpisać.
    |
    | VALUES oznacza wartości, które chcemy zapisać.
    |
    | $tresc jest zmienną PHP zawierającą tekst wpisany przez użytkownika.
    |
    */


    $sql = "INSERT INTO zadania (tresc) VALUES ('$tresc')";


    /*
    | mysqli_query() wysyła polecenie SQL do serwera MySQL.
    |
    | Funkcja otrzymuje dwie informacje:
    |
    | 1. $polaczenie — połączenie z bazą danych,
    | 2. $sql        — polecenie SQL, które ma zostać wykonane.
    |
    */

    $wynik = mysqli_query($polaczenie, $sql);

}


/*
|--------------------------------------------------------------------------
| 5. Usuwanie zadania
|--------------------------------------------------------------------------
|
| Zadanie będziemy usuwać za pomocą adresu:
|
| index.php?usun=3
|
| Znak "?" w adresie rozpoczyna parametry adresu.
|
| "usun=3" oznacza, że parametr "usun" ma wartość 3.
|
| PHP może odczytać parametry z adresu za pomocą specjalnej zmiennej:
|
| $_GET
|
| Czyli:
|
| isset($_GET['usun'])
|
| oznacza:
| "czy w adresie istnieje parametr usun?".
|
*/


if (isset($_GET['usun'])) {

    /*
    | Pobieramy numer rekordu z adresu.
    |
    | Jeżeli adres wygląda tak:
    |
    | index.php?usun=3
    |
    | to do zmiennej $id trafi liczba 3.
    */


    $id = (int) $_GET['usun'];


    /*
    | DELETE oznacza usuwanie rekordu.
    |
    | FROM zadania oznacza:
    | "z tabeli zadania".
    |
    | WHERE oznacza warunek.
    |
    | id=$id określa, który rekord ma zostać usunięty.
    |
    | Jeżeli $id wynosi 3, MySQL otrzyma:
    |
    | DELETE FROM zadania WHERE id=3
    */


    $sql = "DELETE FROM zadania WHERE id=$id";


    /*
    | Wysyłamy przygotowane polecenie MySQL.
    */

    $wynik = mysqli_query($polaczenie, $sql);

}

/*
|--------------------------------------------------------------------------
| 6. Pobranie wszystkich zadań
|--------------------------------------------------------------------------
|
| SELECT oznacza:
| "pobierz dane",
|
| Znak: *
| Oznacza "wszystkie kolumny"
|
| FROM oznacza: "z tabeli",
| Czyli:
| SELECT * FROM zadania
|
| czytamy: "pobierz wszystkie kolumny ze wszystkich rekordów tabeli zadania"
*/

$sql = "SELECT * FROM zadania";

/*
| Wysyłamy zapytanie do MySQL
| Tym razem wynik jest name potrzebny
| dlatego zapisujemy go w zmiennej $wynik
*/

$wynik = mysqli_query($polaczenie, $sql);

/*
|--------------------------------------------------------------------------
| Koniec Pierwszego fragmentu PHP
|--------------------------------------------------------------------------
|
| Znacznik:
|
| ?>
|
| oznacza: "w tym miejscu kończy się kod PHP"
| Od nastepcnej linijki będziemy pisać w zwykłym HTML
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
    | 7. Formularz HTMl
    |--------------------------------------------------------------------------
    |
    | To nie jest PHP
    | Jesteśmy teraz w zwykłym HTML
    | <form> oznacza formularz,
    | method="POST"
    | określa sposób przesłana danych do PHP
    | Po kliknięciu przycisku "Dodaj"
    | przeglądarka wyśle dane metodą POST
    -->

    <form method="POST">

    <!--
    |
    | <label> jest opisem pola formularza
    |
    -->

    <label>Wpisz nowe zadanie</label>

    <!--
    | <input> tworzy pole tekstowe
    |
    | type="text"
    |
    | oznacza zwykle pole do wpisania tekstu
    |
    | name="tresc"
    |
    | jest BARDZO WAŻNE, to nazwa pod którą przesłana wartość będzie dostępna w PHP
    | dlatego PHP może użyć:
    |
    | $_POST("tresc")
    |
    | Nazwa "tresc" mysu sue zgadzać
    -->

    <input type="text" name="tresc">
