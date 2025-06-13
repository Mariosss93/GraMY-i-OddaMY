<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['mode']) || !isset($_GET['q'])) {
    http_response_code(400);
    exit('Brak parametrów.');
}
$mode = $_GET['mode'];
$q = urlencode($_GET['q']);

if ($mode == 'search') {
    $url = "https://boardgamegeek.com/xmlapi2/search?query=$q&type=boardgame";
} elseif ($mode == 'details') {
    $url = "https://boardgamegeek.com/xmlapi2/thing?id=$q&stats=1";
} else {
    http_response_code(400);
    exit('Zły tryb.');
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$xml = curl_exec($ch);
$err = curl_error($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($xml === false || $http_code !== 200) {
    http_response_code(500);
    exit('Błąd pobierania z API BGG: ' . htmlspecialchars($err) . " [$http_code]");
}

header('Content-Type: application/xml; charset=utf-8');
echo $xml;
