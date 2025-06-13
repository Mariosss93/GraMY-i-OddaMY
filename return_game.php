<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'worker'])) {
    header('Location: index.php');
    exit;
}

$db = new SQLite3('../database/games.db');
$id = (int)($_GET['id'] ?? 0);

// Przywróć 1 sztukę, ustaw status na "available" jeśli quantity >= 1
$stmt = $db->prepare("UPDATE games SET quantity = quantity + 1, status = 'available' WHERE id = :id");
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
$stmt->execute();

$_SESSION['success'] = "Gra została zwrócona i jest dostępna!";
header("Location: index.php");
exit;
?>
