<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj nową grę – GraMY i Oddamy</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Dodaj nową grę planszową</h1>

    <form method="POST" action="add_game.php">
        <label>Tytuł gry: <input type="text" name="title" required></label><br><br>
        <label>Opis gry: <textarea name="description"></textarea></label><br><br>
        <label>Liczba graczy: <input type="number" name="players" required></label><br><br>
        <label>Minimalny wiek: <input type="number" name="age" required></label><br><br>
        <button type="submit">Dodaj grę</button>
    </form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Połączenie z bazą danych SQLite
    $db = new SQLite3('../database/games.db');

    // Przygotowanie zapytania SQL
    $stmt = $db->prepare("INSERT INTO games (title, description, players, age) VALUES (:title, :description, :players, :age)");

    // Powiązanie parametrów formularza z SQL
    $stmt->bindValue(':title', $_POST['title'], SQLITE3_TEXT);
    $stmt->bindValue(':description', $_POST['description'], SQLITE3_TEXT);
    $stmt->bindValue(':players', $_POST['players'], SQLITE3_INTEGER);
    $stmt->bindValue(':age', $_POST['age'], SQLITE3_INTEGER);

    // Wykonanie zapytania i obsługa błędu
    if ($stmt->execute()) {
        echo "<p><strong>✅ Gra została dodana poprawnie!</strong></p>";
    } else {
        echo "<p><strong>❌ Błąd podczas dodawania gry.</strong></p>";
    }
}
?>

<p><a href="index.php">Powrót do listy gier</a></p>

</body>
</html>
