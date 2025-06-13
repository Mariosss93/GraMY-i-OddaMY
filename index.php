<?php
session_start();
$db = new SQLite3('../database/games.db');

// Obsługa wyszukiwania
$search = $_GET['search'] ?? '';
if ($search) {
    $query = "SELECT * FROM games WHERE title LIKE :search OR description LIKE :search";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':search', '%' . $search . '%', SQLITE3_TEXT);
    $results = $stmt->execute();
} else {
    $results = $db->query('SELECT * FROM games');
}
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

    <!-- Komunikaty sukces/błąd -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <!-- Informacja o zalogowanym użytkowniku -->
    <?php if (isset($_SESSION['username'])): ?>
        <div class="alert alert-success d-flex justify-content-between align-items-center">
            <div>
                Zalogowany jako: <b><?= htmlspecialchars($_SESSION['username']) ?></b> (<?= htmlspecialchars($_SESSION['role']) ?>)
            </div>
            <a href="logout.php" class="btn btn-sm btn-outline-danger">Wyloguj</a>
        </div>
    <?php else: ?>
        <div class="mb-3">
            <a href="login.php" class="btn btn-primary">Zaloguj się</a>
            <a href="register.php" class="btn btn-outline-secondary">Rejestracja</a>
        </div>
    <?php endif; ?>

    <!-- Wyszukiwarka -->
    <form class="mb-4" method="get" action="">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Wyszukaj grę..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-outline-primary" type="submit">Szukaj</button>
        </div>
    </form>

    <div class="d-flex justify-content-between mb-3">
        <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'worker'])): ?>
            <a href="add_game.php" class="btn btn-success">➕ Dodaj nową grę</a>
        <?php endif; ?>
        <div>
            <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'worker'])): ?>
                <a href="export_json.php" class="btn btn-outline-primary">Eksportuj JSON</a>
                <a href="import_json.php" class="btn btn-outline-secondary">Importuj JSON</a>
            <?php endif; ?>
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
                <th>Ilość</th>
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
                <td><?= htmlspecialchars($row['quantity']) ?></td>
                <td>
                    <?php if ($row['quantity'] > 0): ?>
                        <span class="badge bg-success">Dostępna</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Wypożyczona</span>
                    <?php endif; ?>
                </td>
                <td class="d-flex gap-1 flex-wrap">
                    <a href="details.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-primary btn-sm">Szczegóły</a>
                    <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'worker'])): ?>
                        <a href="edit_game.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-warning btn-sm">Edytuj</a>
                        <a href="delete_game.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Na pewno usunąć?')">Usuń</a>
                        <?php if ($row['quantity'] > 0): ?>
                            <a href="rent_game.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-outline-success btn-sm">Wypożycz</a>
                        <?php endif; ?>
                        <a href="return_game.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-outline-secondary btn-sm">Zwróć</a>
                    <?php else: ?>
                        <?php if ($row['quantity'] > 0): ?>
                            <a href="rent_game.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-outline-success btn-sm">Wypożycz</a>
                        <?php else: ?>
                            <span class="text-muted small">Brak dostępnych egzemplarzy</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
