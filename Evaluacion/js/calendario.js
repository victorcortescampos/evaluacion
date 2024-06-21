const calendarioContainer = document.getElementById("calendario-container");
const calendario = document.getElementById("calendario");
const mesTitulo = document.getElementById("mes-titulo");
const botonAnterior = document.getElementById("anterior");
const botonSiguiente = document.getElementById("siguiente");
const diasSemana = document.getElementById("dias-semana");

let fechaActual = new Date(2023, 3, 1); // Comienza en abril de 2023
let primerDia;

botonAnterior.addEventListener("click", () => {
    fechaActual.setMonth(fechaActual.getMonth() - 1);
    mostrarCalendario();
});

botonSiguiente.addEventListener("click", () => {
    fechaActual.setMonth(fechaActual.getMonth() + 1);
    mostrarCalendario();
});

let diaSeleccionado = null;
let horaSeleccionada = null;

function ajustarNombreDia(dia) {
    const ajustes = {
        'miércoles': 'miercoles',
        'sábado': 'sabado',
        'domingo': 'domingo'
    };

    return ajustes[dia] || dia;
}

function seleccionarDia(celda) {
    const anioActual = fechaActual.getFullYear();
    const mesActual = fechaActual.getMonth();

    if (diaSeleccionado) {
        diaSeleccionado.classList.remove("dia-seleccionado");
    }
    diaSeleccionado = celda;
    diaSeleccionado.classList.add("dia-seleccionado");

    let horasActual = document.getElementById("horas-actual");
    if (!horasActual) {
        horasActual = document.createElement("div");
        horasActual.setAttribute("id", "horas-actual");
        calendarioContainer.parentNode.insertBefore(horasActual, calendarioContainer.nextSibling);
    }

    const fechaSeleccionada = new Date(anioActual, mesActual, parseInt(celda.textContent));
    const diaSemana = ajustarNombreDia(fechaSeleccionada.toLocaleString("es-ES", { weekday: "long" }).toLowerCase());
    const horasCreadas = createdSlots[diaSemana] || [];
    //console.log("Horas creadas para el día:", horasCreadas);

    let tituloHoras = document.createElement("div");
    tituloHoras.classList.add("titulo-horas-calendario");
    tituloHoras.textContent = `Horas para el día ${celda.textContent} de ${fechaSeleccionada.toLocaleString("es-ES", { month: "long" })}:`;
    horasActual.innerHTML = "";
    horasActual.appendChild(tituloHoras);

    let contenedorHoras = document.createElement("div");
    contenedorHoras.classList.add("horas-calendario");
    horasCreadas.forEach((hora) => {
        const divHora = document.createElement("div");
        divHora.textContent = hora;
        
        // Añadir un evento de clic a cada div de hora
        divHora.addEventListener("click", () => {
            if (horaSeleccionada) {
                horaSeleccionada.classList.remove("hora-seleccionada");
            }
            horaSeleccionada = divHora;
            horaSeleccionada.classList.add("hora-seleccionada");
        });

        contenedorHoras.appendChild(divHora);
    });
    horasActual.appendChild(contenedorHoras);
}





function mostrarDiasSemana() {
    const abreviaturasDias = ["lun", "mar", "mié", "jue", "vie", "sáb", "dom"];
    for (const dia of abreviaturasDias) {
        const diaElemento = document.createElement("div");
        diaElemento.textContent = dia;
        diaElemento.classList.add("dia-semana");
        diasSemana.appendChild(diaElemento);
    }
}

// ...

function mostrarCalendario() {
    calendario.innerHTML = "";
    primerDia = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), 1);
    const ultimoDia = new Date(fechaActual.getFullYear(), fechaActual.getMonth() + 1, 0);

    if (primerDia < new Date(2023, 3, 1)) {
        primerDia.setDate(1);
    }

    if (ultimoDia > new Date(2023, 11, 31)) {
        ultimoDia.setDate(31);
    }

    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0);

    const dateFromObj = new Date(dateFrom);
    const dateToObj = new Date(dateTo);
    dateToObj.setDate(dateToObj.getDate() + 1); // Sumamos un día al objeto dateToObj

const customDaysToRemoveArray = customDaysToRemove ? customDaysToRemove.split(", ") : []; //verifica si esta vacio
//const customDaysToRemoveArray = customDaysToRemove.split(', '); asume que siempre tiene valor
//console.log("customDaysToRemoveArray:", customDaysToRemoveArray);

let horasBloqueadas = {};

    // Rellenar con espacios vacíos antes del primer día del mes
    for (let i = 1; i < primerDia.getDay(); i++) {
        calendario.appendChild(document.createElement("div"));
    }

    // Iterar a través de los días del mes
    for (let i = primerDia.getDate(); i <= ultimoDia.getDate(); i++) {
        const celda = document.createElement("div");
        celda.textContent = i;
        const celdaFecha = new Date(primerDia.getFullYear(), primerDia.getMonth(), i);

        if (celdaFecha >= dateFromObj && celdaFecha < dateToObj && !customDaysToRemoveArray.includes(celdaFecha.toISOString().substring(0, 10))) {
            const diaSemana = ajustarNombreDia(celdaFecha.toLocaleString("es-ES", { weekday: "long" }).toLowerCase());
            if (createdSlots[diaSemana] && createdSlots[diaSemana].length > 0) {
                //console.log("Celda habilitada:", celdaFecha);
                celda.addEventListener("click", () => seleccionarDia(celda));
            } else {
                //console.log("Celda bloqueada (sin horas disponibles):", celdaFecha);
                celda.classList.add("dia-bloqueado");
            }
        } else {
            //console.log("Celda bloqueada (fuera del rango):", celdaFecha);
            celda.classList.add("dia-bloqueado");
        }

        calendario.appendChild(celda);
    }

    // Establecer el título del mes y el año
    mesTitulo.textContent = `${primerDia.toLocaleString("es-ES", { month: "long" })} ${primerDia.getFullYear()}`;
}



    
    mostrarDiasSemana();
    mostrarCalendario();
    
