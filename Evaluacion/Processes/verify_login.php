<?php

session_start();

ini_set('session.cookie_httponly', 1);

if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    // El token CSRF no coincide, finaliza el script
    die('Operación no autorizada');
}

include '../Config/database.php';

$correo = htmlspecialchars($_POST['correo']);
$contraseña = htmlspecialchars($_POST['contraseña']);

$query = "SELECT * FROM usuarios WHERE correo_electronico = ?";
$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, 's', $correo);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $stored_password = $row['contraseña'];
    
    if (password_verify($contraseña, $stored_password)) {
        $_SESSION['usuario'] = $row['id_usuario'];
        switch ($row['rol']) {
            case 'usuario_normal':
                header('location: ../default.php');
                break;

            case 'administrador':
                header('location: ../inicio_admin.php');
                break;

            default:
                exit;
        }
    } else {
        echo '
        <script>
            alert("Correo electrónico o contraseña incorrectos. Por favor, verifique los datos introducidos.");
            window.location = "../login.php";
        </script>
        ';
        exit();
    }
} else {
    echo '
        <script>
            alert("Correo electrónico o contraseña incorrectos. Por favor, verifique los datos introducidos.");
            window.location = "../login.php";
        </script>
        ';
        exit();
}

?>
