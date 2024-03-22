<?php
// Establecer los encabezados CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include("../config/config.php");

$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    $json_data = file_get_contents('php://input');
    $post_data = json_decode($json_data, true);

    $nombre = $post_data['nombre'];
    $email = $post_data['email'];
    $edad = $post_data['edad'];

    // $nombre = $_POST["nombre"];
    // $email = $_POST["email"];

    $query = "INSERT INTO usuarios (nombre, email, edad) VALUES ('$nombre', '$email', '$edad')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo json_encode(array("message" => "Usuario creado con exito"));
    } else {
        echo json_encode(array("error" => "Error al crear usuario"));
    }
} else {
    echo json_encode(array("error" => "Metodo no permitido."));
}

mysqli_close($conn);
