<?php
// Establecer los encabezados CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$host = $_ENV['PG_HOST'];
$port = $_ENV['PG_PORT'];
$db = $_ENV['PG_DB'];
$user = $_ENV['PG_USER'];
$password = $_ENV['PG_PASSWORD'];
$endpoint = $_ENV['PG_ENDPOINT'];

$connection_string = "host=" . $host . " port=" . $port . " dbname=" . $db . " user=" . $user . " password=" . $password . " options='endpoint=" . $endpoint . "' sslmode=require";

$conn = pg_connect($connection_string);

if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    $json_data = file_get_contents('php://input');
    $post_data = json_decode($json_data, true);

    $nombre = $post_data['nombre'];
    $email = $post_data['email'];
    $edad = $post_data['edad'];

    // $nombre = $_POST["nombre"];
    // $email = $_POST["email"];

    $query = "INSERT INTO usuarios (nombre, email, edad) VALUES ('$nombre', '$email', '$edad')";
    $result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());

    if ($result) {
        echo json_encode(array("message" => "Usuario creado con exito"));
    } else {
        echo json_encode(array("error" => "Error al crear usuario"));
    }
} else {
    echo json_encode(array("error" => "Metodo no permitido."));
}

pg_close($conn);
