<?php
// Conectar a la base de datos y obtener la variable $conn
require '../Config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen_perfil'])) {
    $file = $_FILES['imagen_perfil'];
    $userId = $_POST['user_id'];

    // Validar y guardar la imagen
    $fileName = basename($file['name']);
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) { // 5MB
                $fileNameNew = uniqid('', true) . "." . $fileExt;
                $fileDestination = '../img/' . $fileNameNew;

                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    // Actualizar la base de datos con el nombre de la imagen
                    //  código para actualizar la base de datos aquí
                    $sql = "UPDATE usuarios SET imagen_perfil = 'img/$fileNameNew' WHERE id_usuario = $userId";
                    mysqli_query($conn, $sql);
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'success', 'message' => 'Imagen subida con éxito', 'file_name' => $fileNameNew]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al subir la imagen']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'El tamaño de la imagen es demasiado grande']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Error al subir la imagen']);
        }
    } else {
        
        echo json_encode(['status' => 'error', 'message' => 'Formato de archivo no permitido']);
    }
}
?>

