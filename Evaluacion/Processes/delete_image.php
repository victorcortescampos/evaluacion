<?php
require '../Config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $defaultImage = 'img/user.jpg';

    // Obtén la imagen actual del usuario
    $sql = "SELECT imagen_perfil FROM usuarios WHERE id_usuario = $userId";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $currentImage = $row['imagen_perfil'];

    // Elimina la imagen actual si no es la predeterminada
    if ($currentImage !== $defaultImage) {
        $imagePath = "../" . $currentImage; // Asegúrate de que la ruta sea correcta
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Actualiza la base de datos con la imagen predeterminada
    $sql = "UPDATE usuarios SET imagen_perfil = '$defaultImage' WHERE id_usuario = $userId";
    mysqli_query($conn, $sql);

    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Imagen eliminada con éxito']);
}
?>


