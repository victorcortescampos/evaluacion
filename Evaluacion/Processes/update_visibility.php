<?php
session_start();
// Incluir el archivo de conexión
include '../Config/database.php';

// Obtener el JSON enviado desde JavaScript
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Extraer la visibilidad del JSON
$visibility = $data['visibility'];

// Aquí debes usar el ID de usuario que corresponda, por ejemplo, puedes obtenerlo desde la sesión
$user_id = $_SESSION['usuario'];

// Preparar la consulta para actualizar la visibilidad en la base de datos
$query = "UPDATE cartas_presentacion SET visibilidad = ? WHERE id_usuario = ?";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $visibility, $user_id);

if ($stmt->execute()) {
    // La consulta se ejecutó correctamente
    $response = [
        'success' => true,
    ];
} else {
    // Hubo un error al ejecutar la consulta
    $response = [
        'success' => false,
        'message' => 'Error al actualizar la visibilidad: ' . $stmt->error,
    ];
}

// Cerrar la conexión y liberar recursos
$stmt->close();
$conn->close();

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
