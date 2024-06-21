<?php
session_start();
include '../Config/database.php';
header('Content-Type: application/json');

if (isset($_POST['generate-calendar']) && $_POST['generate-calendar'] == '1') {

    // Obtén los datos de la sesión
    $date_from = $_SESSION['date_from'];
    $date_to = $_SESSION['date_to'];
    $selected_days = $_SESSION['selected_days'];
    $custom_days_to_remove = $_SESSION['custom_days_to_remove'];
    $created_slots = json_decode($_POST['created-slots-json'], true);

    // Aquí agregar el código para guardar los datos en la base de datos.
    $id_usuario = $_SESSION['usuario'];
    $selected_days_str = implode(",", $selected_days);
    $slots_config_json = json_encode($created_slots);

    $stmt = $conn->prepare("INSERT INTO calendarios (id_usuario, date_from, date_to, selected_days, custom_days_to_remove, slots_config) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $id_usuario, $date_from, $date_to, $selected_days_str, $custom_days_to_remove, $slots_config_json);
    
    if ($stmt->execute()) {
        // Obtén el último id_calendario insertado
        $last_inserted_id = $conn->insert_id;

        // Actualiza el nombre con el valor del id_calendario
        $update_stmt = $conn->prepare("UPDATE calendarios SET nombre = ? WHERE id_calendario = ?");
        $update_stmt->bind_param("si", $last_inserted_id, $last_inserted_id);

        if ($update_stmt->execute()) {
            // Redirecciona a la página de éxito
            echo json_encode(['status' => 'success', 'message' => 'Calendario guardado con éxito']);
        } else {
            // Manejar el error aquí
            echo json_encode(['status' => 'error', 'message' => "Error al actualizar el nombre: " . $conn->error]);
        }

        $update_stmt->close();
        $stmt->close();
        $conn->close();
    } else {
        // Manejar el error aquí
        echo json_encode(['status' => 'error', 'message' => "Error: " . $stmt->error]);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => "La solicitud no es válida"]);
}
?>

