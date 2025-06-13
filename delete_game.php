<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'worker'])) {
    header('Location: login.php');
    exit;
}
?>
$db = new SQLite3('../database/games.db');
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("DELETE FROM games WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
$stmt = $db->prepare("SELECT * FROM games WHERE id = :id");
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
$row = $stmt->execute()->fetchArray();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Usuń grę – GraMY i Oddamy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5" style="max-width:500px;">
    <h1 class="mb-4 text-center text-danger">❌ Usuń grę</h1>
    <div class="alert alert-warning">
        <strong>Czy na pewno chcesz usunąć tę grę?</strong>
        <br>
        <strong><?= htmlspecialchars($row['title']) ?></strong>
    </div>
    <form method="POST" class="text-center">
        <button type="submit" class="btn btn-danger">Usuń</button>
        <a href="index.php" class="btn btn-secondary">Anuluj</a>
    </form>
</div>
</body>
</html>
