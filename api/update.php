<?php
// Establecer los encabezados CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$host = $_ENV['PG_HOST'];
$port = $_ENV['PG_PORT'];
$db = $_ENV['PG_DB'];
$user = $_ENV['PG_USER'];
$password = $_ENV['PG_PASSWORD'];
$endpoint = $_ENV['PG_ENDPOINT'];

$connection_string = "host=" . $host . " port=" . $port . " dbname=" . $db . " user=" . $user . " password=" . $password . " options='endpoint=" . $endpoint . "' sslmode=require";

$conn = pg_connect($connection_string);

if ($_SERVER["REQUEST_METHOD"] == "PUT") {

    $json_data = file_get_contents('php://input');
    $post_data = json_decode($json_data, true);

    $id = $post_data['id'];
    $nombre = $post_data['nombre'];
    $email = $post_data['email'];

    $query = "UPDATE usuarios SET nombre = '$nombre', email = '$email' WHERE id = $id ";

    $result = pg_query($conn, $query);

    if ($result) {
        $rows_affected = pg_affected_rows($result);

        if ($rows_affected > 0) {
            echo json_encode(array('message' => 'Usuario actualizado con éxito.(nombre)'));
        } else {
            echo json_encode(array('message' => 'No se encontraron registros para actualizar.'));
            http_response_code(404);
        }
    }

} else {
    echo json_encode(array("error" => "Metodo no permitido."));
}
?>