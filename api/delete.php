<?php
// Establecer los encabezados CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include("../config/config.php");

$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($_SERVER["REQUEST_METHOD"] == 'DELETE') {
    $json_data = file_get_contents('php://input');
    $post_data = json_decode($json_data, true);

    $id = $post_data['id'];
    $query = "DELETE FROM usuarios WHERE id = $id";

    $result = mysqli_query($conn, $query);

    // if ($result) {
    //     echo json_encode(array("message"=> "El usuario ha sido borrado con éxito", "result" => $result));
    // } else {
    //     echo json_encode(array("error"=> "Error al borrar usuario"));
    // }
    
    if ($result) {
        $rows_affected = mysqli_affected_rows($conn);

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

mysqli_close($conn);
