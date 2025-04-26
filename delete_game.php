<?php
if (!isset($_GET['id'])) {
    echo "Nie podano ID gry!";
    exit;
}

$db = new SQLite3('../database/games.db');
$stmt = $db->prepare('DELETE FROM games WHERE id = :id');
$stmt->bindValue(':id', $_GET['id'], SQLITE3_INTEGER);

if ($stmt->execute()) {
    echo "<p><strong>✅ Gra została usunięta!</strong></p>";
} else {
    echo "<p><strong>❌ Błąd podczas usuwania gry.</strong></p>";
}
?>

<p><a href="index.php">Powrót do listy gier</a></p>

