<?php
include("../config/config.php");

$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = explode( '/', $uri );

$id = $uri[4];

if ($id) {
    $query = "SELECT * FROM usuarios where id = $id";
} else {
    $query = "SELECT * FROM usuarios";
}

$result = mysqli_query($conn, $query);

$usuarios = array();

while ($row = mysqli_fetch_assoc($result)) {
    $usuarios[] = $row;
}

echo (json_encode($usuarios));

mysqli_close($conn);
