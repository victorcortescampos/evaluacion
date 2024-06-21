<?php
session_start();

include '../Config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_1 = $_POST['nombre_1'];
    $nombre_2 = $_POST['nombre_2'];
    $apellido_1 = $_POST['apellido_1'];
    $apellido_2 = $_POST['apellido_2'];
    $celular = $_POST['celular'];
    $telefono = $_POST['telefono'];
    $correo_electronico = $_POST['correo_electronico'];
    $contraseña = $_POST['contraseña'];

    // Consulta para obtener la contraseña almacenada en la base de datos
    $stmt = $conn->prepare("SELECT contraseña FROM usuarios WHERE correo_electronico = ?");
    $stmt->bind_param("s", $correo_electronico);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Verificar si la contraseña ingresada es igual a la almacenada
    if (password_verify($contraseña, $row['contraseña'])) {
        // Si las contraseñas coinciden, actualizar los datos del usuario
        $stmt = $conn->prepare("UPDATE usuarios SET nombre_1 = ?, nombre_2 = ?, apellido_1 = ?, apellido_2 = ?, celular = ?, telefono = ? WHERE correo_electronico = ?");
        $stmt->bind_param("sssssss", $nombre_1, $nombre_2, $apellido_1, $apellido_2, $celular, $telefono, $correo_electronico);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Datos actualizados exitosamente
            // 
            $_SESSION['message'] = "Datos actualizados exitosamente.";
            $_SESSION['message_type'] = "success";
        } else {
            // Error al actualizar los datos
            //
            $_SESSION['message'] = "Error al actualizar los datos.";
             $_SESSION['message_type'] = "error";
        }
    } else {
        // Las contraseñas no coinciden
        // 
        $_SESSION['message'] = "Las contraseñas no coinciden.";
        $_SESSION['message_type'] = "error";
    }

    $stmt->close();
    $conn->close();
    header("Location: ../profile.php");
    exit;

}

?>
