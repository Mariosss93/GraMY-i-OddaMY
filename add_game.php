<?php
session_start();
$db = new SQLite3('../database/games.db');

// Tylko admin/worker mogą dodać grę
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'worker'])) {
    header("Location: index.php");
    exit;
}

// Obsługa formularza dodawania gry
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $players = $_POST['players'] ?? '';
    $age = $_POST['age'] ?? '';
    $quantity = $_POST['quantity'] ?? 1;

    if ($title && $players && $age && $quantity > 0) {
        $stmt = $db->prepare("INSERT INTO games (title, description, players, age, quantity) VALUES (:title, :description, :players, :age, :quantity)");
        $stmt->bindValue(':title', $title, SQLITE3_TEXT);
        $stmt->bindValue(':description', $description, SQLITE3_TEXT);
        $stmt->bindValue(':players', $players, SQLITE3_TEXT);
        $stmt->bindValue(':age', $age, SQLITE3_INTEGER);
        $stmt->bindValue(':quantity', $quantity, SQLITE3_INTEGER);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Gra została dodana!";
            header("Location: index.php");
            exit;
        } else {
            $msg = "Błąd podczas dodawania gry!";
        }
    } else {
        $msg = "Uzupełnij wszystkie wymagane pola!";
    }
}

// Automatyczne pobieranie danych z API po wyszukaniu
$api_game = null;
$api_info = $api_error = null;

// ---- USTAW SWÓJ ADRES! ----
$myProxyURL = "http://127.0.0.1/graMY/bgg_proxy.php"; // <-- ZMIEŃ NA SWÓJ jeśli nie działa!

if (!empty($_GET['api_search'])) {
    $search = urlencode($_GET['api_search']);
    $apiUrl = $myProxyURL . "?mode=search&q=" . $search;
    $xml = @file_get_contents($apiUrl);

    if ($xml) {
        $results = @simplexml_load_string($xml);
        if ($results && isset($results->item[0])) {
            $first = $results->item[0];
            $id = (string)$first['id'];
            // Pobierz szczegóły pierwszego wyniku
            $detailsUrl = $myProxyURL . "?mode=details&q=" . $id;
            $details_xml = @file_get_contents($detailsUrl);
            if ($details_xml) {
                $details = @simplexml_load_string($details_xml);
                if ($details && isset($details->item)) {
                    $bg = $details->item;
                    // Nazwa gry (szukaj primary!)
                    $title = '';
                    foreach ($bg->name as $name) {
                        if ((string)$name['type'] === 'primary') {
                            $title = (string)$name['value'];
                            break;
                        }
                    }
                    if (!$title && isset($bg->name['value'])) {
                        $title = (string)$bg->name['value'];
                    }
                    $desc = (string)$bg->description ?? '';
                    $players_min = isset($bg->minplayers['value']) ? (string)$bg->minplayers['value'] : '';
                    $players_max = isset($bg->maxplayers['value']) ? (string)$bg->maxplayers['value'] : '';
                    $players_str = $players_min;
                    if ($players_min && $players_max && $players_min !== $players_max) {
                        $players_str .= '-' . $players_max;
                    }
                    $age = isset($bg->minage['value']) ? (string)$bg->minage['value'] : '';
                    $api_game = [
                        'title' => $title,
                        'description' => $desc,
                        'players' => $players_str,
                        'age' => $age,
                    ];
                    $api_info = "Automatycznie uzupełniono dane gry: <b>" . htmlspecialchars($title) . "</b>";
                } else {
                    $api_error = 'Nie znaleziono szczegółów gry w API.';
                }
            } else {
                $api_error = 'Błąd połączenia z API (details). URL: '.$detailsUrl;
            }
        } else {
            $api_error = 'Nie znaleziono gry w API.';
        }
    } else {
        $error = error_get_last();
        $api_error = 'Błąd połączenia z API. URL: '.$apiUrl . '<br>file_get_contents error: ' . print_r($error,1);
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj nową grę – GraMY i Oddamy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <h2>➕ Dodaj nową grę planszową</h2>
    <?php if (isset($msg)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label class="form-label">Tytuł gry:</label>
            <input type="text" name="title" class="form-control" required
                value="<?= htmlspecialchars($api_game['title'] ?? ($_POST['title'] ?? '')) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Opis gry:</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($api_game['description'] ?? ($_POST['description'] ?? '')) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Liczba graczy:</label>
            <input type="text" name="players" class="form-control" required
                value="<?= htmlspecialchars($api_game['players'] ?? ($_POST['players'] ?? '')) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Minimalny wiek:</label>
            <input type="number" name="age" min="1" class="form-control" required
                value="<?= htmlspecialchars($api_game['age'] ?? ($_POST['age'] ?? '')) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Ilość sztuk:</label>
            <input type="number" name="quantity" min="1" class="form-control"
                value="<?= htmlspecialchars($_POST['quantity'] ?? 1) ?>">
        </div>
        <button type="submit" class="btn btn-success">Dodaj grę</button>
        <a href="index.php" class="btn btn-secondary">Wróć</a>
    </form>

    <hr>
    <h4>🎲 Wyszukaj grę w BoardGameGeek API</h4>
    <form method="get" action="add_game.php" class="mb-3">
        <div class="input-group">
            <input type="text" name="api_search" class="form-control" placeholder="Tytuł gry" value="<?= htmlspecialchars($_GET['api_search'] ?? '') ?>">
            <button class="btn btn-outline-primary" type="submit">Szukaj w API</button>
        </div>
    </form>

    <?php
    if (isset($api_info)) {
        echo "<div class='alert alert-info'>$api_info</div>";
    }
    if (isset($api_error)) {
        echo "<div class='alert alert-danger'>$api_error</div>";
    }
    ?>
</div>
</body>
</html>
