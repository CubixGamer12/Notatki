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
| 5. Sprawdzenie metody wysłania formularza
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
| "JEŻELI strona została wysłana metodą POST wykonaj instrukcje znajdujace się w { }"
|
*/

if ($_SERVER("REQUEST_METHOD") == "POST") {

    /*
    | $_POST zawiera dane przesłane przez formularz
    |
    | ("tresc") oznaca:
    | pobierz pole formlarza o nazwie "tresc"
    |
    | Za chwilę w HTML utworzymy:
    |
    | <input type="text" name="tresc">
    |
    | Właśie name="tresc" powoduje że PHP może póżniej odczytać
    |
    | $_POST("tresc")
    |
    */

    $tresc = $_POST("tresc");

    /*
    |
    |
    |
    */

}
