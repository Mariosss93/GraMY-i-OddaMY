<?php
if (!isset($_GET['mode']) || !isset($_GET['q'])) {
    http_response_code(400);
    exit('Brak parametrów.');
}
$mode = $_GET['mode'];
$q = urlencode($_GET['q']);

if ($mode == 'search') {
    $url = "https://boardgamegeek.com/xmlapi/search?search=$q";
} elseif ($mode == 'details') {
    $url = "https://boardgamegeek.com/xmlapi/boardgame/$q";
} else {
    http_response_code(400);
    exit('Zły tryb.');
}

$xml = file_get_contents($url);
header('Content-Type: application/xml');
echo $xml;
