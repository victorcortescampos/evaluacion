<?php 
session_start();
include 'Config/database.php';
include 'Processes/session_verification.php';
$environment = 'preview_calendar';
include 'Processes/Processes_generate_appointments.php';
?>
<!DOCTYPE html>
<html lang="en" >
<?php $additional_styles = '<link rel="stylesheet" href="css/calendar.css">'; // activa en css
include 'Partials/header.php'; ?> 
<body>
    <div class="projects-section">
            <div class="timeline">
                <div class="step">Paso 1: Seleccionar Días</div>
                <div class="step">Paso 2: Elegir ranco horas</div>
                <div class="step">Paso 3: Previsualizar Horas</div>
                <div class="step active">Paso 4: Confirmar y guardar</div>
            </div>
            <form id="calendar-form" method="post">
                <div class="calendario-contenedor">
                    <div class="calendario-container" id="calendario-container">
                        <div class="top-calendar">
                            <div class="button-calendar">
                                <button id="anterior"><</button>
                                <button id="siguiente">></button>
                            </div>
                            <h2 id="mes-titulo"></h2>
                        </div>
                        <div id="dias-semana"></div>
                        <div id="calendario"></div>
                    </div>
                    <div id="horarios-container">
                    </div>
                </div>
                <div class="buttons-container" style="width: 100%; display: flex; justify-content:space-between; margin:34px 0 0px;" >
                    <button type="submit" id="btn-back">Atrás</button>
                    <button type="button" id="btn-generar-calendario" name="generate-calendar">Generar calendario</button>

                </div>   
                
            </form>
            <div id="loading-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
                <div class="loader"></div>
            </div>
            <div id="success-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
                <i class="fas fa-check-circle" style="color: #4caf50; font-size: 48px;"></i>
            </div>
            <div id="error-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
                <i class="fas fa-times-circle" style="color: #f44336; font-size: 48px;"></i>
            </div>
    </div>
    <script>
        const dateFrom = '<?php echo $date_from; ?>';
        const dateTo = '<?php echo $date_to; ?>';
        const customDaysToRemove = '<?php echo $custom_days_to_remove; ?>';
        const createdSlots = <?php echo json_encode($created_slots); ?>;
        const selectedSlots = <?php echo json_encode($selected_slots); ?>;

    </script>
    <script src="js/calendario.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
