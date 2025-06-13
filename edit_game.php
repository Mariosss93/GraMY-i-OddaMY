<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'worker'])) {
    header('Location: index.php');
    exit;
}

$db = new SQLite3('../database/games.db');

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

// Pobierz dane gry
$id = (int)$_GET['id'];
$stmt = $db->prepare("SELECT * FROM games WHERE id = :id");
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
$result = $stmt->execute();
$game = $result->fetchArray(SQLITE3_ASSOC);

if (!$game) {
    echo "<div class='alert alert-danger'>Nie znaleziono gry.</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("UPDATE games SET title = :title, description = :description, players = :players, age = :age, quantity = :quantity WHERE id = :id");
    $stmt->bindValue(':title', $_POST['title'], SQLITE3_TEXT);
    $stmt->bindValue(':description', $_POST['description'], SQLITE3_TEXT);
    $stmt->bindValue(':players', $_POST['players'], SQLITE3_TEXT);
    $stmt->bindValue(':age', $_POST['age'], SQLITE3_INTEGER);
    $stmt->bindValue(':quantity', $_POST['quantity'], SQLITE3_INTEGER);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);

    if ($stmt->execute()) {
        $success = "Gra została zaktualizowana!";
        // Pobierz ponownie dane po edycji
        $result = $db->query("SELECT * FROM games WHERE id = $id");
        $game = $result->fetchArray(SQLITE3_ASSOC);
    } else {
        $error = "Błąd podczas edycji gry.";
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
<div class="container my-5">
    <h1 class="mb-4">✏️ Edytuj grę</h1>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Tytuł gry:</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($game['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Opis gry:</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($game['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Liczba graczy:</label>
            <input type="text" name="players" class="form-control" value="<?= htmlspecialchars($game['players']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Minimalny wiek:</label>
            <input type="number" name="age" class="form-control" value="<?= htmlspecialchars($game['age']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ilość sztuk:</label>
            <input type="number" name="quantity" class="form-control" min="0" value="<?= htmlspecialchars($game['quantity']) ?>" required>
        </div>
        <button type="submit" class="btn btn-warning">Zapisz zmiany</button>
        <a href="index.php" class="btn btn-secondary">Anuluj</a>
    </form>
</div>
</body>
</html>
