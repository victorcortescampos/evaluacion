<?php
session_start();
include 'Config/database.php';
include 'Processes/session_verification.php';
$environment = 'select_hours';
include 'Processes/Processes_generate_appointments.php';
?>
<!DOCTYPE html>
<html lang="en" >
<?php $additional_styles = '<link rel="stylesheet" href="css/calendar_appointment.css">'; // activa en css
include 'Partials/header.php'; ?> 
<body>
  <div class="projects-section">
    <form  id="select-hours-form" method="POST" action="preview_appointment.php">
      <!--Datos schedule_appointments.php llegan -->
      <input type="hidden" name="date-from" value="<?php echo $date_from; ?>">
      <input type="hidden" name="date-to" value="<?php echo $date_to; ?>">
      <input type="hidden" name="dias" value="<?php echo implode(',', $selected_days); ?>">
      <input type="hidden" name="eliminar-dias" value="<?php echo $eliminar_dias ? '1' : '0'; ?>">
      <input type="hidden" name="dias-personalizados-eliminar" value="<?php echo $custom_days_to_remove; ?>">

      <div class="timeline">
        <div class="step ">Paso 1: Seleccionar Días</div>
        <div class="step active">Paso 2: Elegir horas</div>
        <div class="step">Paso 3: Configurar otras opciones</div>
        <div class="step">Paso 4: Confirmar y guardar</div>
      </div>
          <div class="custom-container">

            <?php foreach ($selected_days as $day): ?>
              <div class="item">
                <div class="col">
                  <div class="card" data-day="<?php echo $day; ?>">
                    <div class="card-header" id="<?php echo 'heading-' . $day; ?>" data-day="<?php echo $day; ?>">
                      <h4 class="btn btn-link" type="button" aria-controls="<?php echo 'collapse-' . $day; ?>">
                      <?php echo $day; ?></h4>
                    </div>
                    <div id="<?php echo 'collapse-' . $day; ?>" class="collapse" aria-labelledby="<?php echo 'heading-' . $day; ?>" data-parent="#accordion">
                        <div class="card-body" id="<?php echo 'card-body-' . $day; ?>">
                          <div class="times-container">
                              <div class="form-group-left" >
                                  <div class="form-group">
                                    <label>Hora de inicio:</label>
                                    <input type="time" class="form-control start-time" name="start_time[<?php echo $day; ?>][0]">
                                  </div>
                                  <div class="form-group">
                                    <label>Hora de finalización:</label>
                                    <input type="time" class="form-control end-time" name="end_time[<?php echo $day; ?>][0]">
                                  </div>
                              </div>
                              <div class="form-group">
                                <label>Intervalo (minutos):</label>
                                <input type="number" class="form-control interval" min="1" value="30" name="interval[<?php echo $day; ?>][0]">
                              </div>
                          </div>
                          <div class="buttoncontainer">
                            <button type="button" class="btn generate-times">+</button>
                            <button type="button" class="btn delete-times" style="display:none;">-</button>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <div class="navigation-buttons">
          <button type="button" class="btn btn-back">Atrás</button>
          <button type="submit" class="btn btn-next">Siguiente</button>
        </div>
      </form> 
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/l10n/es.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
