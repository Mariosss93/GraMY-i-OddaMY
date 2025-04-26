<?php
if (!isset($_GET['id'])) {
    echo "Nie podano ID gry!";
    exit;
}

$db = new SQLite3('../database/games.db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare('UPDATE games SET title = :title, description = :description, players = :players, age = :age WHERE id = :id');
    $stmt->bindValue(':title', $_POST['title'], SQLITE3_TEXT);
    $stmt->bindValue(':description', $_POST['description'], SQLITE3_TEXT);
    $stmt->bindValue(':players', $_POST['players'], SQLITE3_INTEGER);
    $stmt->bindValue(':age', $_POST['age'], SQLITE3_INTEGER);
    $stmt->bindValue(':id', $_GET['id'], SQLITE3_INTEGER);

    if ($stmt->execute()) {
        echo "<p><strong>✅ Gra została zaktualizowana!</strong></p>";
        echo '<p><a href="index.php">Powrót do listy gier</a></p>';
        exit;
    } else {
        echo "<p><strong>❌ Błąd podczas aktualizacji gry.</strong></p>";
    }
}

$stmt = $db->prepare('SELECT * FROM games WHERE id = :id');
$stmt->bindValue(':id', $_GET['id'], SQLITE3_INTEGER);
$result = $stmt->execute()->fetchArray();

if (!$result) {
    echo "Gra nie znaleziona!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edycja gry – GraMY i OddaMY</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Edytuj grę: <?= htmlspecialchars($result['title']) ?></h1>

    <form method="POST" action="">
        <label>Tytuł gry: <input type="text" name="title" value="<?= htmlspecialchars($result['title']) ?>" required></label><br><br>
        <label>Opis gry: <textarea name="description"><?= htmlspecialchars($result['description']) ?></textarea></label><br><br>
        <label>Liczba graczy: <input type="number" name="players" value="<?= htmlspecialchars($result['players']) ?>" required></label><br><br>
        <label>Minimalny wiek: <input type="number" name="age" value="<?= htmlspecialchars($result['age']) ?>" required></label><br><br>
        <button type="submit">Zapisz zmiany</button>
    </form>

    <p><a href="index.php">Powrót do listy gier</a></p>

</body>
</html>
