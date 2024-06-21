<?php
session_start();
include 'Config/database.php';
include 'Processes/session_verification.php';

// Guardar datos en variables de sesión
if (isset($_POST['date-from'])) {
    $_SESSION['date_from'] = $_POST['date-from'];
  }
  
  if (isset($_POST['date-to'])) {
    $_SESSION['date_to'] = $_POST['date-to'];
  }
  
  if (isset($_POST['dias'])) {
    $_SESSION['dias'] = $_POST['dias'];
  }
  
  if (isset($_POST['eliminar-dias'])) {
    $_SESSION['eliminar_dias'] = $_POST['eliminar-dias'];
    $_SESSION['dias_personalizados_eliminar'] = $_POST['dias-personalizados-eliminar'];
  }

?>
<!DOCTYPE html>
<html lang="en" >
<?php include 'Partials/header.php'; ?>  
</html>
<body>
<div class="projects-section">
<div class="timeline">
    <div class="step active">Paso 1: Seleccionar Días</div>
    <div class="step">Paso 2: Elegir horas</div>
    <div class="step">Paso 3: Configurar otras opciones</div>
    <div class="step">Paso 4: Confirmar y guardar</div>
  </div>
    <div class="proyects-text">
        <h2>Generar calendario de citas</h2>
    </div>
    <div class="proyects-body">
     <form id="date-form" method="post" action="select_hours.php">
        <div class="date-div">
                <label for="date-from">Desde:</label>
                <input type="date" id="date-from" name="date-from" >

                <label for="date-to">Hasta:</label>
                <input type="date" id="date-to" name="date-to" >
        </div>
                
        <div class="option" style="display: none;">
            <div class="personalizado" >
                <div id="dias-semana-personalizado">
                    <div class="dias-semana-personalizado_title">
                    <h4>¿Que días habilitaras?</h4>
                    </div>
                    <div class="dias-semana-personalizado_semana">
                    <label><input type="checkbox" name="dias[]" value="lunes"> Lunes</label>
                    <label><input type="checkbox" name="dias[]" value="martes"> Martes</label>
                    <label><input type="checkbox" name="dias[]" value="miercoles"> Miércoles</label>
                    <label><input type="checkbox" name="dias[]" value="jueves"> Jueves</label>
                    <label><input type="checkbox" name="dias[]" value="viernes"> Viernes</label>
                    <label><input type="checkbox" name="dias[]" value="sabado"> Sábado</label>
                    <label><input type="checkbox" name="dias[]" value="domingo"> Domingo</label>
                    <label><input type="checkbox" id="toggle-all" /> Seleccionar todos</label>
                    </div>
                    

                </div>
                <div class="Dias_div">
                <h4>Seleccione si desea deshabilitar un día</h4>
                <label><input type="checkbox" id="eliminar-dias" name="eliminar-dias" /> Eliminar días</label>
                    <input type="text" id="dias-personalizados-eliminar" name="dias-personalizados-eliminar" placeholder="Seleccione días" style="display: none;" readonly /> 
                </div>         
            </div>       
        </div>
               
        <div class="div_buttom">
            <button type="submit" disabled>Siguiente</button>
        </div>       
        
    </form>
  </div>
</div>


<script src="js/script.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/l10n/es.js"></script>
   
</body>
</html>
