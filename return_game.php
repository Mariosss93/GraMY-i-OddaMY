<?php
$db = new SQLite3('../database/games.db');
$id = $_GET['id'];
$stmt = $db->prepare("UPDATE games SET status = 'available' WHERE id = :id");
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
$stmt->execute();
header("Location: index.php");
exit;
?>
