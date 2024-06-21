<?php
include '../Config/database.php';

// Sanitizar y validar los datos del formulario
$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
$apellido = filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_STRING);
$correo_electronico = filter_input(INPUT_POST, 'correo_electronico', FILTER_VALIDATE_EMAIL);
$celular = "+569" . filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_NUMBER_INT);
$contraseña = filter_input(INPUT_POST, 'contraseña', FILTER_SANITIZE_STRING);
$imagen_perfil = 'img/user.jpg';
$rol = 'usuario_normal';

if (!$correo_electronico) {
    echo '
        <script>
            alert("Correo electrónico no válido");
            window.location = "../login.php";
        </script>
    ';
    exit();
}

// Verifica si el correo electrónico ya existe
$verificar_correo = mysqli_query($conn, "SELECT * FROM usuarios WHERE correo_electronico = '$correo_electronico'");
if (mysqli_num_rows($verificar_correo) > 0) {
    echo '
        <script>
            alert("Este correo ya existe");
            window.location = "../login.php";
        </script>
    ';
    exit();
}

// Cifrar la contraseña antes de insertarla en la base de datos
$contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

$query = "INSERT INTO usuarios(nombre_1, apellido_1, correo_electronico, celular, contraseña, rol, imagen_perfil) VALUES(?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'sssssss', $nombre, $apellido, $correo_electronico, $celular, $contraseña_hash, $rol, $imagen_perfil);

mysqli_stmt_execute($stmt);

// Obtener el id_usuario del nuevo registro
$id_usuario = mysqli_insert_id($conn);
$query = "INSERT INTO cartas_presentacion (id_usuario) VALUES (?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id_usuario);
mysqli_stmt_execute($stmt);

// Redirigir al usuario a la página de inicio de sesión
echo '
    <script>
        alert("Usuario registrado exitosamente");
        window.location = "../login.php";
    </script>
';


    // Verifica si el celular ya existe
    $verificar_celular = mysqli_query($conn, "SELECT * FROM usuarios WHERE celular = '$celular'");
    if (mysqli_num_rows($verificar_celular) > 0) {
        echo '
        <script>
            alert("Este celular ya está registrado, intente con otro");
            window.location = "../login.php";
        </script>
        ';
        exit();
    }

    // Ejecuta la inserción de datos
    $ejecutar = mysqli_stmt_execute($stmt);
    if ($ejecutar) {
        echo '
        <script>
            alert("Usuario registrado exitosamente");
            window.location = "../login.php";
        </script>
        ';
    } else {
        echo '
        <script>
            alert("Inténtelo nuevamente");
            window.location = "../login.php";
        </script>
        ';
    }

    mysqli_close($conn);
?>

