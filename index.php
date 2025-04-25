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
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Dostępne gry planszowe:</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Opis</th>
                <th>Liczba graczy</th>
                <th>Wiek</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $results->fetchArray()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td>
                    <a href="details.php?id=<?= htmlspecialchars($row['id']) ?>">
                        <?= htmlspecialchars($row['title']) ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['players']) ?></td>
                <td><?= htmlspecialchars($row['age']) ?>+</td>
                <td><?= htmlspecialchars($row['status']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <p><a href="add_game.php">Dodaj nową grę</a></p>

</body>
</html>
