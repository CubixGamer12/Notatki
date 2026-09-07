<?php


// =========================================
// PROSTA LISTA ZADAN PHP + MYSQL
// =========================================
// Znacznik <?php oznacza ze od tego miejsca zaczyna sie kod jezyka PHP 
// Kod PHP jest wykonywany na serwerze, przegladarka nie wykonuje tego kodu bezposrednio, PHP wykonuje polecenia a do przegladarki wysyla gotowy wynik
//
// W tym programie bedziemy:
// 1, laczyc sie baza danych
// 2. dodawaca zadania
// 3. pobierac zadania z bazy
// 4. wyswietlac je
// 5. usuwac wybrane zadania 
//
// ========================================


// =========================================
// 1. Zmienne i Dane potrzebne do polaczenia
// =========================================
//
// Znak $ oznacza w PHP zmienna 
//
// Zmienna to miejsce w ktorym mozemy przechowywac jakas wartosc
//
// Przyklad:
// $imie = "Adam";
//
// $imie     - nazwa zmiennej
// =         - operator przypisania
// "Adam"    - wartosc ktora zapisyjemy w zmiennej
// ;         - srednik konczy instrukcje PHP
//
// czytamy to "do zmiennej imie przypisz tekst adam"
//
// Tekst zapisujemy pomiedzy cudzyslowami 

$host = "localhost";

// localhost oznacza;
// 'ten komputer'
//
// Nasz serwer WWW i serwer MySQL działają
// na tym samym serwerze  

$uzytkownik = "root";

// Nazwa użytkownika bazy danych
// W typowej instalacji XAMPP użytkownik nazywa się root

$haslo = "";

// Pusty "" oznacza pusty tekst czyli w tym przykładzie nie podajymy hasła

$baza = "nauka_php";

// Jest to nazwa bazy danych którą wcześniej utworzyliśmy w phpMyAdmin

// =========================================
// 2. ŁACZENIE PHP Z BAZĄ MYSQL
// =========================================
//
// mysqli_connect() jest gotową FUNKCJĄ języka PHP
//
// Funkcja wykonuje określone zadanie
// 
// Nawiasy ()   - służą tutaj do przekazania funkcji informacji któych potrzebuje
//
// Funkcji mysqli_connect przekazujemy cztery informacje:
// 
// 1. adres serwera
// 2. użytkownik
// 3. hasło
// 4. nazwę bazy
//
// Poszczególne wartości odzielamy przecinkami,
// Czyli:
// mysqli_connect($host, $uzytkownik, $haslo, $baza)
//
// oznacza: "połacz sie z serwerem zapisanym w $host, używając użytkownika $uzytkownik oraz hasło $haslo i bazy $baza"
//
// Wynik działania funkcji zapisujemy w zmiennej $polazenie
//
// Znak = oznacza: "przypisz wynik po prawej stronie do zmiennej po lewej stronie"

$polaczenie = mysqli_connect($host, $uzytkownik, $haslo, $baza);

// =========================================
// 3. Sprawdzenie czy połaczenie się udało
// =========================================
//
// if oznaza "Jeżeli"
//
// konstrukcja
//
// if (warunek) {
//     instrukcje
// }
//
// oznacza: Jeżeli warunek jest spełniony, wykonaj instrukcje znajdujace sie pomiedzy { },
//
// Nawiasy klamrowe:
//
// { }
//
// wyznaczaja początek i koniec grupy instrukcji,
// 
// Znak:
//
// !
//
// oznacza negacje czyli mozna go czyaj jako "NIE"
//
// !$polaczenie
//
// oznacza więc:
//
// "jeżeli nie ma połaczenia"

if (!$polaczenie) {
    
    // die() kończy działanie programy
    // Tekst znajdujacy sie pomiedzy "" zostanie wyświetlony użytkownikowi

    die("Nie udało połaczyć się z bazą danych");
}

// =================================================
// 4. Sprawdzenie, czy użytkownik wysyła formularze
// =================================================
//
// $_SERVER jest specjalną zmienna PHP,
//
// znaki:
//
// { }
//
// pozwalają pobrać konkretną informacje znajdujaca sie wewnatrz zmiennej
//
// $_SERVER{"REQUEST_METHOD"}
//
// mówi nam jaką metodą została otwarta/wysłana stona.
//
// formularz ktory stworzymy niżej bedzie używał metody POST
//
// Operator:
//
// ==
//
// oznacza PORÓWNANIE
//
// UWAGA:
//
// =   przypisuje wartość
// ==  porównuje dwie wartości
//
// Czyli
//
// $x = 5;
//
// oznacza: "wstaw 5 do zmiennej x"
