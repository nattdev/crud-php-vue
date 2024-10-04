<?php
// Establecer los encabezados CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include("../config/config.php");

$host = $_ENV['PG_HOST'];
$port = $_ENV['PG_PORT'];
$db = $_ENV['PG_DB'];
$user = $_ENV['PG_USER'];
$password = $_ENV['PG_PASSWORD'];
$endpoint = $_ENV['PG_ENDPOINT'];

$connection_string = "host=" . $host . " port=" . $port . " dbname=" . $db . " user=" . $user . " password=" . $password;

// Puedes habilitar la opción endpoint y sslmode requeridos descomentando la siguiente línea si es necesario:

// $connection_string .= " options='endpoint=" . $endpoint . "' sslmode=require";

$conn = pg_connect($connection_string);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = explode('/', $uri);

$uriSize = count($uri);

$id = null;

if ($uriSize >= 5) {
    $id = $uri[4];
}

if ($id) {
    $query = "SELECT * FROM usuarios where id = $id";
} else {
    $query = "SELECT * FROM usuarios ORDER BY id ASC";
}

$result = pg_query($conn, $query);

$usuarios = array();

while ($row = pg_fetch_assoc($result)) {
    $usuarios[] = $row;
}

echo (json_encode($usuarios));

pg_close($conn);