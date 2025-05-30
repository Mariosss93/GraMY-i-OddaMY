<?php
$db = new SQLite3('../database/games.db');
$id = $_GET['id'];
$stmt = $db->prepare("SELECT * FROM games WHERE id = :id");
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
$row = $stmt->execute()->fetchArray();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("UPDATE games SET title = :title, description = :description, players = :players, age = :age WHERE id = :id");
    $stmt->bindValue(':title', $_POST['title'], SQLITE3_TEXT);
    $stmt->bindValue(':description', $_POST['description'], SQLITE3_TEXT);
    $stmt->bindValue(':players', $_POST['players'], SQLITE3_TEXT);
    $stmt->bindValue(':age', $_POST['age'], SQLITE3_INTEGER);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $error = "❌ Błąd podczas edycji gry.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj grę – GraMY i Oddamy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5" style="max-width:650px;">
    <h1 class="mb-4 text-center">✏️ Edytuj grę</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" class="shadow p-4 bg-white rounded">
        <div class="mb-3">
            <label class="form-label">Tytuł gry:</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($row['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Opis gry:</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($row['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Liczba graczy:</label>
            <input type="text" name="players" class="form-control" value="<?= htmlspecialchars($row['players']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Minimalny wiek:</label>
            <input type="number" name="age" class="form-control" value="<?= htmlspecialchars($row['age']) ?>" required>
        </div>
        <button type="submit" class="btn btn-warning w-100">Zapisz zmiany</button>
    </form>
    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-secondary">⬅ Powrót do listy gier</a>
    </div>
</div>
</body>
</html>
