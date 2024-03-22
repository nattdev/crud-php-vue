<?php
// Establecer los encabezados CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include("../config/config.php");

$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

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
    $query = "SELECT * FROM usuarios ORDER BY fecha_registro DESC";
}

$result = mysqli_query($conn, $query);

$usuarios = array();

while ($row = mysqli_fetch_assoc($result)) {
    $usuarios[] = $row;
}

echo (json_encode($usuarios));

mysqli_close($conn);
