<?php
// Establecer los encabezados CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
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

if ($_SERVER["REQUEST_METHOD"] == 'DELETE') {
    $json_data = file_get_contents('php://input');
    $post_data = json_decode($json_data, true);

    $id = $post_data['id'];
    $query = "DELETE FROM usuarios WHERE id = $id";

    $result = pg_query($conn, $query);

    // if ($result) {
    //     echo json_encode(array("message"=> "El usuario ha sido borrado con éxito", "result" => $result));
    // } else {
    //     echo json_encode(array("error"=> "Error al borrar usuario"));
    // }
    
    if ($result) {
        $rows_affected = pg_affected_rows($result);

        if ($rows_affected > 0) {
            echo json_encode(array('message' => 'Usuario eliminado con éxito.'));
        } else {
            echo json_encode(array('message' => 'No se encontraron registros para eliminar.'));
            http_response_code(404);
        }
    }
} else {
    echo json_encode(array("error" => "Metodo no permitido."));
}

pg_close($conn);
