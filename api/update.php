<?php
include('../config/config.php');

$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($_SERVER["REQUEST_METHOD"] == "PUT") {

    $json_data = file_get_contents('php://input');
    $post_data = json_decode($json_data, true);

    $id = $post_data['id'];
    $nombre = $post_data['nombre'];

    $query = "UPDATE usuarios SET nombre = '$nombre' WHERE id = $id ";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $rows_affected = mysqli_affected_rows($conn);

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