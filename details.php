<?php
$db = new SQLite3('../database/games.db');
$id = $_GET['id'];
$stmt = $db->prepare("SELECT * FROM games WHERE id = :id");
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
$row = $stmt->execute()->fetchArray();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Szczegóły gry – GraMY i Oddamy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5" style="max-width:600px;">
    <h1 class="mb-4 text-center">📋 Szczegóły gry</h1>
    <div class="card shadow">
        <div class="card-body">
            <h3 class="card-title"><?= htmlspecialchars($row['title']) ?></h3>
            <p class="card-text"><strong>Opis:</strong> <?= nl2br(htmlspecialchars($row['description'])) ?></p>
            <p class="card-text"><strong>Liczba graczy:</strong> <?= htmlspecialchars($row['players']) ?></p>
            <p class="card-text"><strong>Minimalny wiek:</strong> <?= htmlspecialchars($row['age']) ?>+</p>
            <p class="card-text">
                <strong>Status:</strong>
                <?php if ($row['status'] == 'available' || empty($row['status'])): ?>
                    <span class="badge bg-success">Dostępna</span>
                <?php else: ?>
                    <span class="badge bg-danger">Wypożyczona</span>
                <?php endif; ?>
            </p>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-secondary">⬅ Powrót do listy gier</a>
    </div>
</div>
</body>
</html>
