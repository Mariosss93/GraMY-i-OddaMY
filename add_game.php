<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj nową grę – GraMY i Oddamy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5" style="max-width: 650px;">
    <h1 class="mb-4 text-center">➕ Dodaj nową grę planszową</h1>

    <form method="POST" action="add_game.php" class="shadow p-4 bg-white rounded">
        <div class="mb-3">
            <label class="form-label">Tytuł gry:</label>
            <div class="input-group">
                <input type="text" name="title" id="titleInput" class="form-control" required>
                <button type="button" onclick="fetchFromBGG()" class="btn btn-info">Szukaj w API (BGG)</button>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Opis gry:</label>
            <textarea name="description" id="descInput" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Liczba graczy:</label>
            <input type="text" name="players" id="playersInput" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Minimalny wiek:</label>
            <input type="number" name="age" id="ageInput" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Dodaj grę</button>
    </form>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-secondary">⬅ Powrót do listy gier</a>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new SQLite3('../database/games.db');
    $stmt = $db->prepare("INSERT INTO games (title, description, players, age, status) VALUES (:title, :description, :players, :age, 'available')");
    $stmt->bindValue(':title', $_POST['title'], SQLITE3_TEXT);
    $stmt->bindValue(':description', $_POST['description'], SQLITE3_TEXT);
    $stmt->bindValue(':players', $_POST['players'], SQLITE3_TEXT);
    $stmt->bindValue(':age', $_POST['age'], SQLITE3_INTEGER);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center mt-4'>✅ Gra została dodana poprawnie!</div>";
    } else {
        echo "<div class='alert alert-danger text-center mt-4'>❌ Błąd podczas dodawania gry.</div>";
    }
}
?>

<script>
function stripHtml(html) {
    var tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}

function fetchFromBGG() {
    const title = document.getElementById('titleInput').value;
    if (!title) {
        alert('Podaj tytuł gry!');
        return;
    }
    fetch('bgg_proxy.php?mode=search&q=' + encodeURIComponent(title))
        .then(response => response.text())
        .then(str => {
            const parser = new DOMParser();
            const xml = parser.parseFromString(str, 'application/xml');
            const boardgames = xml.getElementsByTagName('boardgame');
            if (boardgames.length === 0) {
                alert('Nie znaleziono gry na BGG!');
                return;
            }
            const objectid = boardgames[0].getAttribute('objectid');
            fetch('bgg_proxy.php?mode=details&q=' + objectid)
                .then(resp => resp.text())
                .then(str2 => {
                    const parser2 = new DOMParser();
                    const xml2 = parser2.parseFromString(str2, 'application/xml');
                    const game = xml2.getElementsByTagName('boardgame')[0];

                    document.getElementById('descInput').value = stripHtml(game.getElementsByTagName('description')[0]?.textContent || '');
                    const minPlayers = game.getElementsByTagName('minplayers')[0]?.textContent || '';
                    const maxPlayers = game.getElementsByTagName('maxplayers')[0]?.textContent || '';
                    document.getElementById('playersInput').value = minPlayers && maxPlayers ? (minPlayers + '–' + maxPlayers) : (minPlayers || maxPlayers);

                    let minAge = '';
                    if (game.getElementsByTagName('minage').length > 0 && game.getElementsByTagName('minage')[0].textContent) {
                        minAge = game.getElementsByTagName('minage')[0].textContent;
                    } else if (game.getElementsByTagName('age').length > 0 && game.getElementsByTagName('age')[0].textContent) {
                        minAge = game.getElementsByTagName('age')[0].textContent;
                    }
                    document.getElementById('ageInput').value = minAge;
                    if (!minAge) {
                        alert('API BGG nie podało minimalnego wieku. Wpisz wartość ręcznie!');
                    } else {
                        alert('Dane gry pobrane z BGG!');
                    }
                });
        });
}
</script>

</body>
</html>
