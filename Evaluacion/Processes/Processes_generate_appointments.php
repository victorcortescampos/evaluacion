<?php


if ($environment === 'shedule_appointments') {
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

} elseif ($environment === 'select_hours') {
    // Accede a los valores de las variables de sesión aquí
    if (isset($_POST['date-from'])) {
        $date_from = $_POST['date-from'];
        $date_to = $_POST['date-to'];
        $selected_days = isset($_POST['dias']) ? $_POST['dias'] : [];
    
        $eliminar_dias = isset($_POST['eliminar-dias']);
        $custom_days_to_remove = isset($_POST['dias-personalizados-eliminar']) ? $_POST['dias-personalizados-eliminar'] : '';
    } else {
        header("Location: schedule_appointments.php");
        exit;
    }

    // Por ejemplo, imprimirlos para verificación
    echo "Fecha desde: " . $date_from . "<br>";
    echo "Fecha hasta: " . $date_to . "<br>";
    echo "Días seleccionados: " . implode(", ", $selected_days) . "<br>";
    echo "Eliminar días: " . ($eliminar_dias ? "Sí" : "No") . "<br>";
    echo "Días personalizados a eliminar: " . $custom_days_to_remove . "<br>";
} elseif ($environment === 'preview_appointments') {
    
if (isset($_POST['date-from'])) {
    $date_from = $_POST['date-from'];
    $date_to = $_POST['date-to'];
    $selected_days = isset($_POST['dias']) ? explode(',', $_POST['dias']) : [];

    $eliminar_dias = isset($_POST['eliminar-dias']);
    $custom_days_to_remove = isset($_POST['dias-personalizados-eliminar']) ? $_POST['dias-personalizados-eliminar'] : '';

    $start_times = [];
    $end_times = [];
    $intervals = [];

    foreach ($selected_days as $day) {
        $start_times[$day] = isset($_POST['start_time'][$day]) ? $_POST['start_time'][$day] : [];
        $end_times[$day] = isset($_POST['end_time'][$day]) ? $_POST['end_time'][$day] : [];
        $intervals[$day] = isset($_POST['interval'][$day]) ? $_POST['interval'][$day] : [];
    }

    // Almacenar los datos del formulario en las variables de sesión
    $_SESSION['date_from'] = $date_from;
    $_SESSION['date_to'] = $date_to;
    $_SESSION['selected_days'] = $selected_days;
    $_SESSION['eliminar_dias'] = $eliminar_dias;
    $_SESSION['custom_days_to_remove'] = $custom_days_to_remove;
    $_SESSION['start_times'] = $start_times;
    $_SESSION['end_times'] = $end_times;
    $_SESSION['intervals'] = $intervals;

} else {
    header("Location: schedule_appointments.php");
    exit;
}

function calculate_time_slots($start_time, $end_time, $interval) {
    $start = new DateTime($start_time);
    $end = new DateTime($end_time);
    $interval = new DateInterval("PT" . $interval . "M");
    $slots = [];

    // Comprueba si el horario de finalización es al día siguiente
    if ($start > $end) {
        $end->add(new DateInterval("P1D"));
    }

    for ($time = $start; $time < $end; $time->add($interval)) {
        $slots[] = $time->format('H:i');
    }

    return $slots;
}

function sort_time_asc($a, $b) {
    $time_a = strtotime($a);
    $time_b = strtotime($b);
    
    return $time_a - $time_b;
}


function display_time_slots($selected_days, $start_times, $end_times, $intervals) {
    foreach ($selected_days as $day) {
        echo '<div class="container-hors">';
        echo '<div class="day">';
        echo '<h4 class="btn btn-link" type="button" aria-controls="' . 'collapse-' . $day . '">' . $day . '</h4>';
        echo '</div>';
        echo '<div class="hors">';

        $all_slots = [];
        for ($i = 0; $i < count($start_times[$day]); $i++) {
            $slots = calculate_time_slots($start_times[$day][$i], $end_times[$day][$i], $intervals[$day][$i]);
            $all_slots = array_merge($all_slots, $slots);
        }
        usort($all_slots, 'sort_time_asc');
        foreach ($all_slots as $slot) {
            echo '<input type="checkbox" class="slot-checkbox" data-day="' . $day . '" value="' . $slot . '" hidden>';
            echo '<span class="slot-label" data-day="' . $day . '">' . $slot . '</span> ';
        }
        echo '</div>';
        echo '</div>';
    }
}



echo "Fecha desde: " . $date_from . "<br>";
echo "Fecha hasta: " . $date_to . "<br>";
echo "Días seleccionados: " . implode(", ", $selected_days) . "<br>";

echo "Eliminar días: " . ($eliminar_dias ? "Sí" : "No") . "<br>";
echo "Días personalizados a eliminar: " . $custom_days_to_remove . "<br>";

foreach ($selected_days as $day) {
    echo "Día: " . $day . "<br>";
    if (isset($start_times[$day])) {
        echo "Horarios de inicio: " . implode(", ", $start_times[$day]) . "<br>";
    }
    if (isset($end_times[$day])) {
        echo "Horarios de finalización: " . implode(", ", $end_times[$day]) . "<br>";
    }
    if (isset($intervals[$day])) {
        echo "Intervalos: " . implode(", ", $intervals[$day]) . "<br>";
    }
    echo "<br>";
}
} elseif ($environment === 'preview_calendar'){

    
if (isset($_SESSION['date_from'])) {
    $date_from = $_SESSION['date_from'];
    $date_to = $_SESSION['date_to'];
    $selected_days = $_SESSION['selected_days'];
    $eliminar_dias = $_SESSION['eliminar_dias'];
    $custom_days_to_remove = $_SESSION['custom_days_to_remove'];
    $start_times = $_SESSION['start_times'];
    $end_times = $_SESSION['end_times'];
    $intervals = $_SESSION['intervals'];
    if (isset($_POST['selected-slots-json'])) {
        $_SESSION['selected_slots'] = json_decode($_POST['selected-slots-json'], true);
    }
    if (isset($_POST['created-slots-json'])) {
        $_SESSION['created_slots'] = json_decode($_POST['created-slots-json'], true);
    }
    
    
} else {
    header("Location: schedule_appointments.php");
    exit;
}
$raw_selected_slots = isset($_SESSION['selected_slots']) ? array_change_key_case($_SESSION['selected_slots'], CASE_LOWER) : [];

$created_slots = isset($_SESSION['created_slots']) ? array_change_key_case($_SESSION['created_slots'], CASE_LOWER) : [];


echo "Fecha desde: " . $date_from . "<br>";
echo "Fecha hasta: " . $date_to . "<br>";
echo "Días seleccionados: " . implode(", ", $selected_days) . "<br>";

echo "Eliminar días: " . ($eliminar_dias ? "Sí" : "No") . "<br>";
echo "Días personalizados a eliminar: " . $custom_days_to_remove . "<br>";


//imprime las horas eliminada de cada dias en el array
$selected_slots = [];
foreach ($raw_selected_slots as $slot) {
    if (is_array($slot) && isset($slot['day']) && isset($slot['slot'])) {
        $day = $slot['day'];
        $time = $slot['slot'];
        if (!isset($selected_slots[$day])) {
            $selected_slots[$day] = [];
        }
        $selected_slots[$day][] = $time;
    }
}
foreach ($selected_slots as $day => $slots_to_remove) {
    if (isset($created_slots[$day])) {
        $created_slots[$day] = array_values(array_diff($created_slots[$day], $slots_to_remove));
    }
}



echo "Horas eliminadas: <br>";
foreach ($selected_slots as $day => $slots) {
    echo $day . ": " . implode(", ", $slots) . "<br>";
}

echo "Horas creadas: ";
foreach ($created_slots as $day => $slots) {
    echo $day . ": " . implode(", ", $slots) . "<br>";
}




foreach ($selected_days as $day) {
    echo "Día: " . $day . "<br>";
    if (isset($start_times[$day])) {
        echo "Horarios de inicio: " . implode(", ", $start_times[$day]) . "<br>";
    }
    if (isset($end_times[$day])) {
        echo "Horarios de finalización: " . implode(", ", $end_times[$day]) . "<br>";
    }
    if (isset($intervals[$day])) {
        echo "Intervalos: " . implode(", ", $intervals[$day]) . "<br>";
    }
    
}




}

?>