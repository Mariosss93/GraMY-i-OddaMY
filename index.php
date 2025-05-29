<?php
// Połączenie z bazą danych SQLite
$db = new SQLite3('../database/games.db');
$results = $db->query('SELECT * FROM games');
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>GraMY i Oddamy – Biblioteka gier planszowych</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <h1 class="mb-4 text-center">🎲 GraMY i Oddamy – Biblioteka gier planszowych</h1>
    <div class="d-flex justify-content-between mb-3">
        <a href="add_game.php" class="btn btn-success">➕ Dodaj nową grę</a>
        <div>
            <a href="export_json.php" class="btn btn-outline-primary">Eksportuj JSON</a>
            <a href="import_json.php" class="btn btn-outline-secondary">Importuj JSON</a>
        </div>
    </div>
    <table class="table table-striped table-hover align-middle shadow">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Opis</th>
                <th>Liczba graczy</th>
                <th>Wiek</th>
                <th>Status</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $results->fetchArray()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td style="max-width: 350px; white-space:pre-line;"><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['players']) ?></td>
                <td><?= htmlspecialchars($row['age']) ?>+</td>
                <td>
                    <?php if ($row['status'] == 'available' || empty($row['status'])): ?>
                        <span class="badge bg-success">Dostępna</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Wypożyczona</span>
                    <?php endif; ?>
                </td>
                <td class="d-flex gap-1">
                    <a href="details.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-primary btn-sm">Szczegóły</a>
                    <a href="edit_game.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-warning btn-sm">Edytuj</a>
                    <a href="delete_game.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Na pewno usunąć?')">Usuń</a>
                    <?php if ($row['status'] == 'available' || empty($row['status'])): ?>
                        <a href="rent_game.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-outline-success btn-sm">Wypożycz</a>
                    <?php elseif ($row['status'] == 'rented'): ?>
                        <a href="return_game.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-outline-secondary btn-sm">Zwróć</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
