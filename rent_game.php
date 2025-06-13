<?php
session_start();

// Tylko zalogowany użytkownik (user, admin, worker) może wypożyczyć
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'worker', 'user'])) {
    header('Location: index.php');
    exit;
}

$db = new SQLite3('../database/games.db');
$id = (int)($_GET['id'] ?? 0);

// Pobierz dane gry
$stmt = $db->prepare("SELECT * FROM games WHERE id = :id");
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
$result = $stmt->execute();
$game = $result->fetchArray(SQLITE3_ASSOC);

if (!$game || $game['quantity'] < 1) {
    $_SESSION['error'] = "Brak dostępnych egzemplarzy tej gry!";
    header("Location: index.php");
    exit;
}

// Zmniejsz quantity o 1, zmień status jeśli ostatni egzemplarz
$new_quantity = $game['quantity'] - 1;
$new_status = ($new_quantity == 0) ? 'rented' : 'available';

$update = $db->prepare("UPDATE games SET quantity = :q, status = :s WHERE id = :id");
$update->bindValue(':q', $new_quantity, SQLITE3_INTEGER);
$update->bindValue(':s', $new_status, SQLITE3_TEXT);
$update->bindValue(':id', $id, SQLITE3_INTEGER);
$update->execute();

// Numer zamówienia: ID gry + timestamp
$order_number = $id . '-' . time();
$adres = "WSPIAbridge, ul. Bursaki 12, 20-150 Lublin";

// Wyświetl stronę potwierdzenia!
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Potwierdzenie rezerwacji gry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="alert alert-success">
        <h2>✅ Rezerwacja przyjęta!</h2>
        <p>
            <b>Gra:</b> <?= htmlspecialchars($game['title']) ?><br>
            <b>Numer zamówienia:</b> <span style="font-family:monospace"><?= htmlspecialchars($order_number) ?></span>
        </p>
        <p>
            Twoja gra jest gotowa do odbioru pod adresem:<br>
            <b><?= $adres ?></b>
        </p>
        <p>
            Zgłoś się do biblioteki i podaj numer zamówienia.<br>
            Dziękujemy za rezerwację!
        </p>
        <a href="index.php" class="btn btn-primary mt-3">Powrót do listy gier</a>
    </div>
</div>
</body>
</html>
