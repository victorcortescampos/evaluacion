<?php
session_start();
include 'Config/database.php';

include 'Processes/session_verification.php';

$userId = $_SESSION['usuario'];

// Consulta para obtener los datos del usuario
$query_usuario = "SELECT * FROM usuarios WHERE id_usuario = ?";
$stmt_usuario = mysqli_prepare($conn, $query_usuario);
mysqli_stmt_bind_param($stmt_usuario, 'i', $userId);
mysqli_stmt_execute($stmt_usuario);
$result_usuario = mysqli_stmt_get_result($stmt_usuario);

// Consulta para obtener los datos de la carta de presentación
$query_carta = "SELECT * FROM cartas_presentacion WHERE id_usuario = ?";
$stmt_carta = mysqli_prepare($conn, $query_carta);
mysqli_stmt_bind_param($stmt_carta, 'i', $userId);
mysqli_stmt_execute($stmt_carta);
$result_carta = mysqli_stmt_get_result($stmt_carta);

if (mysqli_num_rows($result_usuario) > 0) {
    $user = mysqli_fetch_assoc($result_usuario);

    // Asigna los valores de nombre y apellido
    $nombre = $user['nombre_1'];
    $apellido = $user['apellido_1'];
    $celular = $user['celular'];
    $email = $user['correo_electronico'];

    // Verificar si existe una carta de presentación para el usuario
    if (mysqli_num_rows($result_carta) > 0) {
        $carta_presentacion = mysqli_fetch_assoc($result_carta);
        $visibility = $carta_presentacion['visibilidad'];
        
    } else {
        // No hay carta de presentación para este usuario
    }
} else {
    // Usuario no encontrado
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en" >
    <?php include 'Partials/header.php'; ?>

            <div class="projects-section projects-profile">
            <div class="button-container">
                <button id="perfil-btn" data-section="#perfil" class="is-active">Perfil</button>
                <button id="carta-presentacion-btn" data-section="#carta_presentacion">Carta Presentación</button>
            </div>
            <div class="profile-container" onclick="redirige()">
                <button class="profile-main-btn">
                    <img src="<?php echo $user['imagen_perfil'];?>" class="img_profile" alt="Imagen de perfil">
                </button>
                <div class="profile-buttons" id="profile-buttons" style="display:none;">
                    <button id="insert-img-btn">Insertar imagen</button>
                    <input type="file" id="hidden-file-input" accept="image/*" style="display:none;">

                    <button id="delete-img-btn">Eliminar imagen</button>
                    <button id="close-btn">Cerrar</button>
                </div>
            </div>
            <?php
                if (isset($_SESSION['message'])) {
                ?>
                    <div id="alert-message" class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                        <?php
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                        unset($_SESSION['message_type']);
                        ?>
                    </div>
                <?php
                }
                ?>


                <div class="profile_input">
                    <form class="formulario_1 is-active" data-state="#perfil" action="Processes/update_profile_data.php" method="POST" enctype="multipart/form-data">

                        <label for="descripcion">Datos Perdonales</label>
                        <div class="input_profile">
                            <input type="text" name="nombre_1" placeholder="Primer Nombre" value="<?php echo $user['nombre_1'];?>" id="nombre_1" required>
                            <input type="text" name="nombre_2" placeholder="Segundo Nombre" value="<?php echo $user['nombre_2'];?>" id="nombre_2" >
                        </div>
                        <div class="input_profile">
                            <input type="text" name="apellido_1" placeholder="Primer Apellido" value="<?php echo $user['apellido_1'];?>" id="apellido_1" required>
                            <input type="text" name="apellido_2" placeholder="Segundo Apellido" value="<?php echo $user['apellido_2'];?>"  id="apellido_2" >
                        </div>
                        <div class="input_profile">
                            <input type="text" name="celular" placeholder="Celular" value="<?php echo $user['celular'];?>" id="celular">
                            <input type="text" placeholder="Teléfono" name="telefono" value="<?php echo $user['telefono'];?>" id="telefono">
                        </div>
                        <input type="email" name="correo_electronico" placeholder="Correo Electrónico" value="<?php echo $user['correo_electronico'];?>" id="correo_electronico" required>
                        <input type="password" placeholder="Contraseña" name="contraseña" value="" id="contraseña" required>
                        <div class="input_profile">

                        <input type="submit" value="Actualizar Datos" id="update-button" disabled>

                        </div>
                        </form>

                        <form class="formulario_2" id="perfilForm" style="display:none;" data-state="#carta_presentacion" action="Processes/update_cover_letter.php" method="POST" enctype="multipart/form-data">
                         <label for="descripcion">Carta de Presentación:</label>
                         <div  class="input_profile_2"> 
                            <input type="text" placeholder ="Nombres" value="<?php echo $user['nombre_1']." ";  echo $user['apellido_1']; ?>" name="Nombres" id="Nombres" disabled>
                            <input type="text" placeholder="profesión" value="<?php echo $carta_presentacion['profesion']; ?>"name="profesion" id="profesion">
                         </div>
                        
                        <textarea name="descripcion" placeholder="Descripcion" id="descripcion"   maxlength="250" rows="10" cols="50" style="resize: none;"><?php echo $carta_presentacion['descripcion']; ?></textarea>
                        
                        <label for="Redes_Sociales">Redes Sociales:</label>
                        <input type="text" name="facebook" placeholder="Link Facebook" value ="<?php echo $carta_presentacion['facebook']; ?>"id="facebook">
                        <input type="text" name="twitter" placeholder="Link Twitter" value ="<?php echo $carta_presentacion['instagram']; ?>  "id="twitter">
                        <input type="text" name="instagram" placeholder="Link instagram"  value ="<?php echo $carta_presentacion['twitter']; ?>" id="instagram">
                        <input type="text" name="linkedin" placeholder="Link linkedin" value ="<?php echo $carta_presentacion['linkedin']; ?>"id="linkedin">

                        <label for="descripcion">Contacto:</label>
                        <input type="text" name="direccion" value ="<?php echo $carta_presentacion['direccion']; ?>" placeholder="Direccion" id="direccion">
                        <input type="text" name="numero_cel" placeholder="Numero Celular" value="<?php echo $user['celular']; ?>" id="numero_cel" disabled>
                        <input type="text" name="email" placeholder="Email" value="<?php echo $user['correo_electronico']; ?>" id="email" disabled>
                        <div class="input_profile">
                            <input type="submit" value="Actualizar Datos" id="update-button-2" disabled>
                        </div>
                    </form>
                </div>
            </div>
            <div class="messages-section profil">
            <p class="name">Carta de Presentacion</p>
            <div class="button-vis">
            <section title=".slideThree">
    <!-- .slideThree -->
    <div class="slideThree">  
    <input type="checkbox" value="None" id="visibilityToggle" name="check" <?php echo ($visibility === 'visible') ? 'checked' : ''; ?> />

        <label for="visibilityToggle"></label>
    </div>
    <!-- end .slideThree -->
</section>

            </div>
            <div class="card" data-state="#about">
                <div class="card-header">
                    <div class="card-cover" style="background-image: url('<?php echo $user['imagen_perfil'];?>')"></div>
                    <img class="card-avatar" src="<?php echo $user['imagen_perfil'];?>" alt="avatar" />
                    <h1 class="card-fullname"><?php echo $user['nombre_1']." ";  echo $user['apellido_1']; ?></h1>
                    <h2 class="card-jobtitle"><?php echo $carta_presentacion['profesion']; ?></h2>
                </div>
                <div class="card-main">
                    <div class="card-section is-active" id="about">
                    <div class="card-content">
                        <div class="card-subtitle">ACERCA DE</div>
                        <p class="card-desc" id="carta"><?php echo $carta_presentacion['descripcion']; ?>
                        </p>
                    </div>
                    <div class="card-social">

                        <!--- ICONO FACE--->
                        <?php if (!empty($carta_presentacion['facebook'])): ?>
                        <a href="<?php echo $carta_presentacion['facebook']; ?>"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.997 3.985h2.191V.169C17.81.117 16.51 0 14.996 0c-3.159 0-5.323 1.987-5.323 5.639V9H6.187v4.266h3.486V24h4.274V13.267h3.345l.531-4.266h-3.877V6.062c.001-1.233.333-2.077 2.051-2.077z" /></svg></a>
                                <?php endif; ?>

                                <!--- ICONO twitter--->
                                <?php if (!empty($carta_presentacion['twitter'])): ?>
                        <a href="<?php echo $carta_presentacion['twitter']; ?> "><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M512 97.248c-19.04 8.352-39.328 13.888-60.48 16.576 21.76-12.992 38.368-33.408 46.176-58.016-20.288 12.096-42.688 20.64-66.56 25.408C411.872 60.704 384.416 48 354.464 48c-58.112 0-104.896 47.168-104.896 104.992 0 8.32.704 16.32 2.432 23.936-87.264-4.256-164.48-46.08-216.352-109.792-9.056 15.712-14.368 33.696-14.368 53.056 0 36.352 18.72 68.576 46.624 87.232-16.864-.32-33.408-5.216-47.424-12.928v1.152c0 51.008 36.384 93.376 84.096 103.136-8.544 2.336-17.856 3.456-27.52 3.456-6.72 0-13.504-.384-19.872-1.792 13.6 41.568 52.192 72.128 98.08 73.12-35.712 27.936-81.056 44.768-130.144 44.768-8.608 0-16.864-.384-25.12-1.44C46.496 446.88 101.6 464 161.024 464c193.152 0 298.752-160 298.752-298.688 0-4.64-.16-9.12-.384-13.568 20.832-14.784 38.336-33.248 52.608-54.496z" /></svg></a>
                            <?php endif; ?>

                            <!--- ICONO instagram--->                 
                            <?php if (!empty($carta_presentacion['instagram'])): ?>
                        <a href="<?php echo $carta_presentacion['instagram']; ?>"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                            <path d="M301 256c0 24.852-20.148 45-45 45s-45-20.148-45-45 20.148-45 45-45 45 20.148 45 45zm0 0" />
                            <path d="M332 120H180c-33.086 0-60 26.914-60 60v152c0 33.086 26.914 60 60 60h152c33.086 0 60-26.914 60-60V180c0-33.086-26.914-60-60-60zm-76 211c-41.355 0-75-33.645-75-75s33.645-75 75-75 75 33.645 75 75-33.645 75-75 75zm86-146c-8.285 0-15-6.715-15-15s6.715-15 15-15 15 6.715 15 15-6.715 15-15 15zm0 0" />
                            <path d="M377 0H135C60.562 0 0 60.563 0 135v242c0 74.438 60.563 135 135 135h242c74.438 0 135-60.563 135-135V135C512 60.562 451.437 0 377 0zm45 332c0 49.625-40.375 90-90 90H180c-49.625 0-90-40.375-90-90V180c0-49.625 40.375-90 90-90h152c49.625 0 90 40.375 90 90zm0 0" /></svg></a>
                            <?php endif; ?>

                            <!--- ICONO linkedin--->  
                            <?php if (!empty($carta_presentacion['linkedin'])): ?>
                        <a href="<?php echo $carta_presentacion['linkedin']; ?>"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.994 24v-.001H24v-8.802c0-4.306-.927-7.623-5.961-7.623-2.42 0-4.044 1.328-4.707 2.587h-.07V7.976H8.489v16.023h4.97v-7.934c0-2.089.396-4.109 2.983-4.109 2.549 0 2.587 2.384 2.587 4.243V24zM.396 7.977h4.976V24H.396zM2.882 0C1.291 0 0 1.291 0 2.882s1.291 2.909 2.882 2.909 2.882-1.318 2.882-2.909A2.884 2.884 0 002.882 0z" /></svg></a>
                            <?php endif; ?>

                    </div>
                    </div>
                    
                    <div class="card-section" id="contact">
                    <class="card-content">
                        <div class="card-subtitle">CONTACTO</div>
                        <div class="card-contact-wrapper">
                        <div class="card-contact">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                            <circle cx="12" cy="10" r="3" /></svg>
                            <?php echo $carta_presentacion['direccion']; ?>
                        </div>
                        <div class="card-contact">
                            <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" /></svg><?php echo $user['celular']; ?></div>
                        <div class="card-contact">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <path d="M22 6l-10 7L2 6" /></svg>
                            <?php echo $user['correo_electronico']; ?>
                        </div>
                        <!---<button class="contact-me">WORK TOGETHER</button>--->
                        </div>
                    </div>
                    </div>
                    <div class="card-buttons">
                    <button data-section="#about" class="is-active">ACERCA DE</button>
                    <button data-section="#contact">CONTACTO</button>
                    </div>
                </div>
                </div>
            </div>
        </main>
        <script>
    var userId = <?php echo $user['id_usuario']; ?>;
</script>

        <script src="js/script.js"></script>
        <script src="js/es.js"></script>
</body>
</html>