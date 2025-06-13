<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'worker'])) {
    header('Location: login.php');
    exit;
}
?>
$db = new SQLite3('../database/games.db');
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['json_file'])) {
    $json = file_get_contents($_FILES['json_file']['tmp_name']);
    $data = json_decode($json, true);
    if (is_array($data)) {
        foreach ($data as $game) {
            $stmt = $db->prepare("INSERT INTO games (title, description, players, age, status) VALUES (:title, :description, :players, :age, 'available')");
            $stmt->bindValue(':title', $game['title'], SQLITE3_TEXT);
            $stmt->bindValue(':description', $game['description'], SQLITE3_TEXT);
            $stmt->bindValue(':players', $game['players'], SQLITE3_TEXT);
            $stmt->bindValue(':age', $game['age'], SQLITE3_INTEGER);
            $stmt->execute();
        }
        $msg = "✅ Zaimportowano gry!";
    } else {
        $msg = "❌ Błąd importu (zły format JSON)";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Importuj gry – GraMY i Oddamy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5" style="max-width: 500px;">
    <h1 class="mb-4 text-center">📥 Importuj gry z JSON</h1>
    <?php if ($msg): ?>
        <div class="alert alert-info text-center"><?= $msg ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data" class="shadow p-4 bg-white rounded">
        <div class="mb-3">
            <label class="form-label">Wybierz plik JSON:</label>
            <input type="file" name="json_file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Importuj</button>
    </form>
    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-secondary">⬅ Powrót do listy gier</a>
    </div>
</div>
</body>
</html>
