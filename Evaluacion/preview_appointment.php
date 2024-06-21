
<?php
session_start();
include 'Config/database.php';
include 'Processes/session_verification.php';
$environment = 'preview_appointments';
include 'Processes/Processes_generate_appointments.php';
?>
<!DOCTYPE html>
<html lang="en" >
<?php $additional_styles = '<link rel="stylesheet" href="css/calendar_appointment.css">'; // activa en css
include 'Partials/header.php'; ?>  
<body>
    <div class="projects-section">
        <div class="timeline">
            <div class="step ">Paso 1: Seleccionar Días</div>
            <div class="step ">Paso 2: Elegir ranco horas</div>
            <div class="step active">Paso 3: Previsualizar Horas</div>
            <div class="step">Paso 4: Confirmar y guardar</div>
        </div>

        <div class="custom-container">
            <form id="date-form" method="post" action="preview_calendar.php" style="min-width:1000px;">
               <!--Datos select_hours.php llegan -->
               <input type="hidden" name="date-from" value="<?php echo $date_from; ?>">
               <input type="hidden" name="date-to" value="<?php echo $date_to; ?>">
               <input type="hidden" name="dias" value="<?php echo implode(',', $selected_days); ?>">
               <input type="hidden" name="eliminar-dias" value="<?php echo $eliminar_dias; ?>">
               <input type="hidden" name="dias-personalizados-eliminar" value="<?php echo $custom_days_to_remove; ?>">
               <input type="hidden" name="selected-slots-json" id="selected-slots-json">
               <input type="hidden" name="created-slots-json" id="created-slots-json">
               <div class="custom-container-top">
                  <div class="toggle-delete-container">
                     <input type="checkbox" id="toggle-delete-mode">
                     <label for="toggle-delete-mode">Eliminar horas</label>
                  </div>
                  <div class="custom-container-top-buttom">
                     <strong>Horas eliminadas:</strong>
                     <div class="hours-removed-container">
                        <span id="selected-slots"></span>
                     </div>
                  </div>
               </div>
               <!--function que contiene foreach de listado Días con horas-->
               <?php display_time_slots($selected_days, $start_times, $end_times, $intervals); ?>
               <div class="navigation-buttons">
                  <button type="submit" class="btn btn-back" >Atrás</button>
                  <button type="submit" class="btn btn-next">Siguiente</button>
               </div>
            </form>
        </div>
    </div>
    <script src="js/script.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/l10n/es.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
