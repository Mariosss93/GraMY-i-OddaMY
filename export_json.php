<?php
$db = new SQLite3('../database/games.db');
$results = $db->query('SELECT * FROM games');
$games = [];
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $games[] = $row;
}
header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="gry.json"');
echo json_encode($games, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;
