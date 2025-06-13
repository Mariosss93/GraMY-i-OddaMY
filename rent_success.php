<?php
session_start();
$order = $_GET['order'] ?? '';
$game = $_GET['game'] ?? '';
$adres = "WSPIA Rzeszowska Szkoła Wyższa Filia w Lublinie, ul. Bursaki 12, 20-150 Lublin";
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
            <b>Gra:</b> <?= htmlspecialchars($game) ?><br>
            <b>Numer zamówienia:</b> <span style="font-family:monospace"><?= htmlspecialchars($order) ?></span>
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
