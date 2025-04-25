<?php
if (!isset($_GET['id'])) {
    echo "Nie podano ID gry!";
    exit;
}

$db = new SQLite3('../database/games.db');
$stmt = $db->prepare('SELECT * FROM games WHERE id = :id');
$stmt->bindValue(':id', $_GET['id'], SQLITE3_INTEGER);
$result = $stmt->execute()->fetchArray();

if (!$result) {
    echo "Gra nie znaleziona!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($result['title']) ?> – Szczegóły gry</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1><?= htmlspecialchars($result['title']) ?></h1>
    <p><strong>Opis:</strong> <?= htmlspecialchars($result['description']) ?></p>
    <p><strong>Liczba graczy:</strong> <?= htmlspecialchars($result['players']) ?></p>
    <p><strong>Minimalny wiek:</strong> <?= htmlspecialchars($result['age']) ?>+</p>
    <p><strong>Status:</strong> <?= htmlspecialchars($result['status']) ?></p>

    <a href="index.php">Powrót do listy gier</a>
</body>
</html>
