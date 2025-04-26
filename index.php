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
<?php
// Połączenie z bazą danych SQLite
$db = new SQLite3('../database/games.db');
$results = $db->query('SELECT * FROM games');
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>GraMY i OddaMY – Biblioteka gier planszowych</title>
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
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $results->fetchArray()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['players']) ?></td>
                <td><?= htmlspecialchars($row['age']) ?>+</td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td>
                    <a href="details.php?id=<?= htmlspecialchars($row['id']) ?>">Szczegóły</a> |
                    <a href="edit_game.php?id=<?= htmlspecialchars($row['id']) ?>">Edytuj</a> |
                    <a href="delete_game.php?id=<?= htmlspecialchars($row['id']) ?>" onclick="return confirm('Czy na pewno chcesz usunąć tę grę?');">Usuń</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br>

    <p><a href="add_game.php">➕ Dodaj nową grę</a></p>

</body>
</html>
