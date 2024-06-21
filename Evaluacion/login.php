<?php
include 'Config/database.php';
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: default.php");
    exit();
}

if (isset($_GET['cerrar_sesion'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse">Regístrarse</button>
                </div>
            </div>

            <div class="contenedor__login-register">
                <!-- Login -->
                <form action="Processes/verify_login.php" method="POST" class="formulario__login" enctype="multipart/form-data">
                    <h2>Iniciar Sesión</h2>
                    <input type="email" placeholder="Correo Electrónico" name="correo" required>
                    <div class="input-container">
                        <input type="password" placeholder="Contraseña" name="contraseña" id="passwordLogin" required>
                        <i class="fas fa-eye" id="togglePasswordLogin"></i>
                    </div>
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <button type="submit">Entrar</button>
                </form>

                <!-- Register -->
                <form action="Processes/register_user.php" method="POST" class="formulario__register" enctype="multipart/form-data">
                    <h2>Regístrarse</h2>
                    <input type="text" placeholder="Nombre" name="nombre" required>
                    <input type="text" placeholder="Apellido" name="apellido" required>
                    <input type="email" placeholder="Correo Electrónico" name="correo_electronico" required>
                    <input type="tel" placeholder="Celular" name="celular" pattern="[0-9]{8}" maxlength="8" class="celular-input" required>
                    <div class="input-container">
                        <input type="password" placeholder="Contraseña" name="contraseña" id="passwordRegister" required>
                        <i class="fas fa-eye" id="togglePasswordRegister"></i>
                    </div>
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <button type="submit">Regístrarse</button>
                </form>
            </div>
        </div>
    </main>
    <script src="js/script.js"></script>
</body>
</html>
