<?php
session_start();

// Conexión a la base de datos
require '../Config/database.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $profesion = $_POST['profesion'];
    $descripcion = $_POST['descripcion'];
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $instagram = $_POST['instagram'];
    $linkedin = $_POST['linkedin'];
    $direccion = $_POST['direccion'];


    // Actualizar la tabla cartas_presentacion
    $query1 = "UPDATE cartas_presentacion SET profesion = ?, descripcion = ?, facebook = ?, twitter = ?, instagram = ?, linkedin = ?, direccion = ? WHERE id_usuario = ?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("sssssssi", $profesion, $descripcion, $facebook, $twitter, $instagram, $linkedin, $direccion, $_SESSION['usuario']);
    $stmt1->execute();


    if ($stmt1->affected_rows > 0 ) {
        $_SESSION['message'] = "Datos actualizados exitosamente.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error al actualizar los datos.";
        $_SESSION['message_type'] = "error";
    }

    $stmt1->close();
    $conn->close();

    header('Location: ../profile.php'); 
}
?>

