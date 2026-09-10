<?php

$host = "localhost";
$uzytkownik = "root";
$haslo = "";
$baza = "nauka_php";
$polaczenie = mysqli_connect($host, $uzytkownik, $haslo, $baza);

if (!$polaczenie) {
    die("Nie udało się połączyć z bazą danych.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tresc = $_POST["tresc"];
    $sql = "INSERT INTO zadania (tresc) VALUES ('$tresc')";
    mysqli_query($polaczenie, $sql);
}

if (isset($_GET["usun"])) {
    $id = $_GET["usun"];
    $sql = "DELETE FROM zadania WHERE id=$id";
    mysqli_query($polaczenie, $sql);
}

$sql = "SELECT * FROM zadania";
$wynik = mysqli_query($polaczenie, $sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Moja lista zadań</title>
</head>

<body>
<h1>Moja lista zadań</h1>
<form method="POST">
    <label>Wpisz nowe zadanie:</label>
    <input type="text" name="tresc">
    <button type="submit">Dodaj</button>
</form>
<h2>Zapisane zadania</h2>

<?php
while ($zadanie = mysqli_fetch_assoc($wynik)) {
    echo $zadanie["tresc"];
    echo " <a href='index.php?usun=" . $zadanie["id"] . "'>Usuń</a>";
    echo "<br>";
}
mysqli_close($polaczenie);
?>

</body>
</html>