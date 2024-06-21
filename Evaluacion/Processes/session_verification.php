<?php
    if (!isset($_SESSION['usuario'])) {
        header("location: login.php");
        exit();
    }
    $userId = $_SESSION['usuario'];

$query = "SELECT * FROM usuarios WHERE id_usuario = ?";
$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Usuario no encontrado
    header("Location: login.php");
    exit();
}
?>
