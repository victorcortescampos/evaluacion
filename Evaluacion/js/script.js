//---------------------------------Funciones---------------- {
function uploadImage(file) {
    const formData = new FormData();
    formData.append("image", file);

    // Reemplaza la URL con la dirección de tu archivo PHP para procesar la subida de imágenes
    const uploadUrl = "upload_image.php";

    fetch(uploadUrl, {
        method: "POST",
        body: formData,
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            // Actualizar la imagen de perfil y guardar la dirección en la base de datos
            const imageUrl = "img/" + data.imageName;
            document.querySelector(".img_profile").src = imageUrl;
            // Aquí puedes guardar la dirección de la imagen en la base de datos
        } else {
            console.error("Error al subir la imagen:", data.message);
        }
    })
    .catch((error) => {
        console.error("Error al subir la imagen:", error);
    });
}
function toggleDropdown(event) {
    event.stopPropagation();
    var dropdown = document.getElementById("dropdown");
    var button = event.currentTarget;
    var buttonRect = button.getBoundingClientRect();
    
    dropdown.style.left = buttonRect.left + "px";
    dropdown.style.top = buttonRect.bottom + "px";
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
  }
  
  
  document.addEventListener("click", function() {
    var dropdown = document.getElementById("dropdown");
    dropdown.style.display = "none";
  });
  

/*-----DACK-----*/
function toggleDarkMode() {
  const bodyElement = document.querySelector('html');
  bodyElement.classList.toggle('dark');
}

function redirige() {
  window.location.href = 'profile.php';
}

function getDisabledDates() {
  const startDateElement = document.getElementById('fecha-inicio');
  const endDateElement = document.getElementById('fecha-fin');

  if (!startDateElement || !endDateElement) {
      return [];
  }

  const startDate = new Date(startDateElement.value);
  const endDate = new Date(endDateElement.value);
  const checkboxes = document.querySelectorAll('#dias-semana-personalizado input[type="checkbox"]');

  let disabledDates = [];
  let currentDate = new Date(startDate);

  while (currentDate <= endDate) {
      const currentWeekday = currentDate.getDay();
      const currentDayLabel = getDayLabel(currentWeekday);

      const isDisabled = Array.from(checkboxes).some(checkbox => {
          return checkbox.checked && checkbox.value === currentDayLabel;
      });

      if (!isDisabled) {
          disabledDates.push(new Date(currentDate));
      }

      currentDate.setDate(currentDate.getDate() - 1);
  }

  return disabledDates;
}

//---------------------------------login------------------------------
//Ejecutando funciones
if (window.location.pathname.endsWith('login.php')) {
document.getElementById("btn__iniciar-sesion").addEventListener("click", iniciarSesion);
document.getElementById("btn__registrarse").addEventListener("click", register);
window.addEventListener("resize", anchoPage);

//Declarando variables
var formulario_login = document.querySelector(".formulario__login");
var formulario_register = document.querySelector(".formulario__register");
var contenedor_login_register = document.querySelector(".contenedor__login-register");
var caja_trasera_login = document.querySelector(".caja__trasera-login");
var caja_trasera_register = document.querySelector(".caja__trasera-register");

    //FUNCIONES

function anchoPage(){

    if (window.innerWidth > 850){
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "block";
    }else{
        caja_trasera_register.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.display = "none";
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";   
    }
}

anchoPage();


    function iniciarSesion(){
        if (window.innerWidth > 850){
            formulario_login.style.display = "block";
            contenedor_login_register.style.left = "10px";
            formulario_register.style.display = "none";
            caja_trasera_register.style.opacity = "1";
            caja_trasera_login.style.opacity = "0";
        }else{
            formulario_login.style.display = "block";
            contenedor_login_register.style.left = "0px";
            formulario_register.style.display = "none";
            caja_trasera_register.style.display = "block";
            caja_trasera_login.style.display = "none";
        }
    }

    function register(){
        if (window.innerWidth > 850){
            formulario_register.style.display = "block";
            contenedor_login_register.style.left = "410px";
            formulario_login.style.display = "none";
            caja_trasera_register.style.opacity = "0";
            caja_trasera_login.style.opacity = "1";
        }else{
            formulario_register.style.display = "block";
            contenedor_login_register.style.left = "0px";
            formulario_login.style.display = "none";
            caja_trasera_register.style.display = "none";
            caja_trasera_login.style.display = "block";
            caja_trasera_login.style.opacity = "1";
        }
}
//---- mostrar contraseña ----
document.getElementById("togglePasswordLogin").addEventListener("click", function () {
    togglePasswordVisibility("passwordLogin", this);
});

document.getElementById("togglePasswordRegister").addEventListener("click", function () {
    togglePasswordVisibility("passwordRegister", this);
});

function togglePasswordVisibility(passwordId, eyeIcon) {
    const passwordInput = document.getElementById(passwordId);
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}
}
/*--------------------listView-------------------------*/



if (window.location.pathname.endsWith('profile.php')) {
    /*-----profile-card----*/
    const buttons = document.querySelectorAll(".card-buttons button");
    const sections = document.querySelectorAll(".card-section");
    const card = document.querySelector(".card");

    function handleButtonClick(e) {
        const targetSection = e.target.getAttribute("data-section");
        const section = document.querySelector(targetSection);
        if (targetSection !== "#about") {
            card.classList.add("is-active");
        } else {
            card.classList.remove("is-active");
        }
        card.setAttribute("data-state", targetSection);
        sections.forEach(function(s) {
            s.classList.remove("is-active");
        });
        buttons.forEach(function(b) {
            b.classList.remove("is-active");
        });
        e.target.classList.add("is-active");
        section.classList.add("is-active");
    }

    buttons.forEach(function(btn) {
        btn.addEventListener("click", handleButtonClick);
    });


    const perfilBtn = document.getElementById('perfil-btn');
    const cartaPresentacionBtn = document.getElementById('carta-presentacion-btn');
    const formulario1 = document.querySelector('.formulario_1');
    const formulario2 = document.querySelector('.formulario_2');
    
    function toggleFormVisibility() {
      if (formulario1.classList.contains('is-active')) {
        formulario1.classList.remove('is-active');
        formulario1.style.display = 'none';
        formulario2.style.display = 'block';
        perfilBtn.classList.remove('is-active');
        cartaPresentacionBtn.classList.add('is-active');
        localStorage.setItem('activeForm', 'carta_presentacion');
      } else {
        formulario1.classList.add('is-active');
        formulario1.style.display = 'block';
        formulario2.style.display = 'none';
        perfilBtn.classList.add('is-active');
        cartaPresentacionBtn.classList.remove('is-active');
        localStorage.setItem('activeForm', 'perfil');
      }
    }
    
    function restoreFormVisibility() {
      const activeForm = localStorage.getItem('activeForm');
      if (activeForm === 'carta_presentacion') {
        toggleFormVisibility();
      }
    }
    
    document.addEventListener('DOMContentLoaded', restoreFormVisibility);
    

  perfilBtn.addEventListener('click', toggleFormVisibility);
  cartaPresentacionBtn.addEventListener('click', toggleFormVisibility);



    function redirige() {
        const profileButtons = document.getElementById("profile-buttons");
        profileButtons.style.display = "flex"; 
        profileButtons.style.justifyContent = "space-evenly"; 
    }
    

    document.getElementById("insert-img-btn").addEventListener("click", function () {
        const hiddenFileInput = document.getElementById("hidden-file-input");
        hiddenFileInput.click();
    
        hiddenFileInput.addEventListener("change", function () {
            const file = this.files[0];
    
            if (file) {
                const formData = new FormData();
                formData.append('imagen_perfil', file);
                formData.append('user_id', userId);
    
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'Processes/upload_image.php', true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
    
                        if (response.status === 'success') {
                            const imgProfile = document.querySelector('.img_profile');
                            imgProfile.src = 'img/' + response.file_name;
                            location.reload(); // Agrega esta línea para recargar la página
                        } else {
                            // Muestra el mensaje de error
                            alert(response.message);
                        }
                    }
                };
    
                xhr.send(formData);
            }
        });
    });
    
    
    
    document.getElementById("delete-img-btn").addEventListener("click", function () {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "Processes/delete_image.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
    
                if (response.status === "success") {
                    const imgProfile = document.querySelector(".img_profile");
                    imgProfile.src = "img/user.jpg";
                    location.reload(); // Agrega esta línea para recargar la página
                } else {
                    alert(response.message);
                }
            }
        };
    
        xhr.send(`user_id=${userId}`);
    });
    


    
    document.getElementById("close-btn").addEventListener("click", function(event) {
        event.stopPropagation(); // Detener la propagación del evento para evitar que se muestren de nuevo los botones
        document.getElementById("profile-buttons").style.display = "none";
    });
    

// -------------------visible ocultar-------------------
function updateVisibilityStatus() {
    const isChecked = document.getElementById("visibilityToggle").checked;
    const visibilityStatus = isChecked ? "visible" : "ocultar";

    // Reemplaza la URL con la dirección de tu archivo PHP para procesar la actualización de la visibilidad
    const updateUrl = "Processes/update_visibility.php";

    fetch(updateUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ visibility: visibilityStatus }),
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            console.log("Visibilidad actualizada:", visibilityStatus);
        } else {
            console.error("Error al actualizar la visibilidad:", data.message);
        }
    })
    .catch((error) => {
        console.error("Error al actualizar la visibilidad:", error);
    });
}

document.getElementById("visibilityToggle").addEventListener("change", updateVisibilityStatus);

    


//-------------------------------------ALERTAS----------------------------------
document.addEventListener('DOMContentLoaded', function() {
    const alertMessage = document.getElementById('alert-message');

    if (alertMessage) {
        setTimeout(function() {
            alertMessage.remove();
        }, 3000);
    }
});



//--------------verifica que se modifico el formulario-----------------------------

document.addEventListener('DOMContentLoaded', function() {
    const form1 = document.querySelector('.formulario_1');
    const form2 = document.getElementById('perfilForm');
    const forms = [form1, form2];

    const updateButton1 = document.getElementById('update-button');
    const updateButton2 = document.getElementById('update-button-2');
    const updateButtons = [updateButton1, updateButton2];

    forms.forEach((form, index) => {
        const inputs = form.querySelectorAll('input');
        let isFormModified = false;

        function checkFormChanges() {
            for (const input of inputs) {
                if (input.value !== input.defaultValue) {
                    isFormModified = true;
                    break;
                } else {
                    isFormModified = false;
                }
            }
            updateButtons[index].disabled = !isFormModified;
        }

        for (const input of inputs) {
            input.addEventListener('input', checkFormChanges);
        }

        window.addEventListener('beforeunload', function(event) {
            if (isFormModified) {
                event.preventDefault();
                event.returnValue = '¿Seguro que quieres salir sin guardar los cambios?';
            }
        });
    });
});

}



if (window.location.pathname.endsWith('default.php')) {


  function applyListView() {
      // Remueve la clase "active" del botón de "Grid View"
      document.getElementById("gridViewBtn").classList.remove("active");
    
      // Agrega la clase "active" al botón de "List View"
      document.getElementById("listViewBtn").classList.add("active");
    
      // Agrega la clase "active" a los elementos relevantes
      const elements = document.querySelectorAll(".project-box-wrapper, .project-boxes.jsGridView, .project-box, .project-box-header, .more-wrapper, .project-box-content-header, .box-content-header, .box-content-subheader, .project-box-footer, .box-progress-wrapper");
      elements.forEach(element => {
        element.classList.add("active");
      });
    }
    
    function applyGridView() {
      // Remueve la clase "active" del botón de "List View"
      document.getElementById("listViewBtn").classList.remove("active");
    
      // Agrega la clase "active" al botón de "Grid View"
      document.getElementById("gridViewBtn").classList.add("active");
    
      // Remueve la clase "active" de los elementos relevantes
      const elements = document.querySelectorAll(".project-box-wrapper, .project-boxes.jsGridView, .project-box, .project-box-header, .more-wrapper, .project-box-content-header, .box-content-header, .box-content-subheader, .project-box-footer, .box-progress-wrapper");
      elements.forEach(element => {
        element.classList.remove("active");
      });
    }
    
    document.getElementById("listViewBtn").addEventListener("click", function() {
      applyListView();
      localStorage.setItem("view", "list");
    });
    
    document.getElementById("gridViewBtn").addEventListener("click", function() {
      applyGridView();
      localStorage.setItem("view", "grid");
    });
    
    // Cargar la selección guardada al cargar la página
    document.addEventListener("DOMContentLoaded", function() {
      const savedView = localStorage.getItem("view");
      if (savedView === "list") {
        applyListView();
      } else if (savedView === "grid") {
        applyGridView();
      }
    });
    


}



if (window.location.pathname.endsWith('schedule_appointments.php')) {

    let generalizadoRadio;
    
    

    function setupDateLimits() {
        const dateFrom = document.getElementById('date-from');
        const dateTo = document.getElementById('date-to');
        const currentDate = new Date().toISOString().slice(0, 10);
        dateFrom.setAttribute('min', currentDate);
      
        if (dateFrom.value) {
          dateTo.setAttribute('min', dateFrom.value);
        } else {
          dateTo.setAttribute('disabled', true);
        }
      
        dateFrom.addEventListener('change', function () {
          dateTo.removeAttribute('disabled');
          dateTo.setAttribute('min', dateFrom.value);
        });
      }
      
      
      document.addEventListener('DOMContentLoaded', function() {
        setupDateLimits();
      });
      
      

    function toggleWeekdays() {
        const personalizado = document.querySelector('.personalizado');
        const checkboxes = personalizado.querySelectorAll('input[type="checkbox"]');
        const submitButton = document.querySelector('#date-form button[type="submit"]');
    
        checkboxes.forEach(checkbox => {
        });
        
                        attachRadioEventListeners();
                        }
                        
    
    

    function updateFlatpickr() {
        const diasPersonalizadosEliminar = document.getElementById('dias-personalizados-eliminar');
    
        const disabledDates = getDisabledDates();
        const unselectedBlockedDates = getUnselectedBlockedDates(disabledDates);

    
        flatpickr('#dias-personalizados-eliminar', {
            mode: 'multiple',
            dateFormat: 'Y-m-d',
            enable: disabledDates,
            locale: 'es',
            onReady: function() {
                this.set('locale', 'es');
            }
        });
    }
    
    function getUnselectedBlockedDates(disabledDates) {
        const dateFrom = new Date(document.getElementById('date-from').value);
        const dateTo = new Date(document.getElementById('date-to').value);
    
        let unselectedBlockedDates = [];
    
        for (let date = new Date(dateFrom); date <= dateTo; date.setDate(date.getDate() + 1)) {
            const dateString = date.toISOString().slice(0, 10);
            if (!disabledDates.includes(dateString)) {
                unselectedBlockedDates.push(dateString);
            }
        }
    
        return unselectedBlockedDates;
    }
    
    

    document.addEventListener('DOMContentLoaded', function () {
        const dateFrom = document.getElementById('date-from');
        const dateTo = document.getElementById('date-to');
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="dias[]"]');
        const submitButton = document.querySelector('button[type="submit"]');
      
        function updateSubmitButtonState() {
          let selectedDays = false;
          checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
              selectedDays = true;
            }
          });
      
          if (dateFrom.value && dateTo.value && selectedDays) {
            submitButton.disabled = false;
          } else {
            submitButton.disabled = true;
          }
        }
      
        function updateOptionSectionVisibility() {
          if (dateFrom.value && dateTo.value) {
            document.querySelector('.option').style.display = 'block';
          } else {
            document.querySelector('.option').style.display = 'none';
          }
        }
      
        dateFrom.addEventListener('input', () => {
          updateOptionSectionVisibility();
          updateSubmitButtonState();
        });
      
        dateTo.addEventListener('input', () => {
          updateOptionSectionVisibility();
          updateSubmitButtonState();
        });
      
        checkboxes.forEach((checkbox) => {
          checkbox.addEventListener('change', () => {
            updateSubmitButtonState();
          });
        });
      
        const eliminarDias = document.getElementById('eliminar-dias');
        const diasPersonalizadosEliminar = document.getElementById('dias-personalizados-eliminar');
      
        eliminarDias.addEventListener('change', () => {
          if (eliminarDias.checked) {
            diasPersonalizadosEliminar.style.display = 'block';
          } else {
            diasPersonalizadosEliminar.style.display = 'none';
          }
        });
      
        setupDateLimits();
        updateOptionSectionVisibility();
        updateSubmitButtonState();
      });
      
    
        
    
    
    function updateCustomDates() {
        const dateFrom = document.getElementById('date-from');
        const dateTo = document.getElementById('date-to');

    
        if (dateFrom.value && dateTo.value) {
            document.querySelector('.option').style.display = 'block';
            dateFrom.addEventListener('input', updateCustomDates);
         dateTo.addEventListener('input', function () {
            updateCustomDates();
            updateEndDatePlusOne();
        });
        } else {
            document.querySelector('.option').style.display = 'none';
        }

    }
    function updateEndDatePlusOne() {
        const dateToInput = document.getElementById('date-to');
        const diasPersonalizadosInput = document.getElementById('dias-personalizados-eliminar');
        
        if (dateToInput && diasPersonalizadosInput) {
            const dateToValue = new Date(dateToInput.value);
            dateToValue.setDate(dateToValue.getDate() + 1);
    
            const formattedDate = formatDate(dateToValue);
            diasPersonalizadosInput.value = formattedDate;
        }
    }
    
    function formatDate(date) {
        const day = ('0' + date.getDate()).slice(-2);
        const month = ('0' + (date.getMonth() + 1)).slice(-2);
        const year = date.getFullYear();
        
        return `${day}-${month}-${year}`;
    }
    
   
function hasSelectedOptions(option) {
    const checkboxContainer = document.getElementById(`dias-semana-${option}`);
    const checkboxes = checkboxContainer.querySelectorAll('input[type="checkbox"]');
    const hasCheckedWeekday = Array.from(checkboxes).some(checkbox => checkbox.checked);

    if (option === 'personalizado') {
        const eliminarDias = document.getElementById('eliminar-dias');
        const diasPersonalizadosEliminar = document.getElementById('dias-personalizados-eliminar');

        const hasSelectedCustomDate = (eliminarDias.checked && diasPersonalizadosEliminar.value !== '');

        return hasCheckedWeekday || hasSelectedCustomDate;
    }

    return hasCheckedWeekday;
}
    
    
    function togglePersonalizado() {
        const eliminarDias = document.getElementById('eliminar-dias');
        const diasPersonalizadosEliminar = document.getElementById('dias-personalizados-eliminar');
    
        
        if (eliminarDias.checked) {
            diasPersonalizadosEliminar.style.display = 'block';
        } else {
            diasPersonalizadosEliminar.style.display = 'none';
        }
    }
    function clearWeekdaySelection(option) {
        const checkboxContainer = document.getElementById(`dias-semana-${option}`);
        const checkboxes = checkboxContainer.querySelectorAll('input[type="checkbox"]');
    
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
    }
    
    
    function initFlatpickr() {
        const dateFrom = new Date(document.getElementById('date-from').value);
        const dateTo = new Date(document.getElementById('date-to').value);
    
        if (dateFrom && dateTo && dateFrom <= dateTo) {
           
            flatpickr('#dias-personalizados-eliminar', {
                mode: 'multiple',
                dateFormat: 'Y-m-d',
                minDate: dateFrom,
                maxDate: dateTo,
                locale: {
                    firstDayOfWeek: 1 // Lunes como primer día de la semana
                }
            });
            toggleWeekdays();
        }
    }
   
    
    
    
    function attachRadioEventListeners() {
        const radios = document.querySelectorAll('input[type="radio"][name="option"]');
    
        radios.forEach((radio) => {
        });
    }
    
    function dayNumber(day) {
        const days = {
            'domingo': 6,
            'lunes': 0,
            'martes': 1,
            'miercoles': 2,
            'jueves': 3,
            'viernes': 4,
            'sabado': 5
        };
    
        return days[day];
    }
    
    function getEnabledDays(dateFrom, dateTo, selectedDays) {
        let enabledDays = [];
    
        for (let date = new Date(dateFrom); date <= dateTo; date.setDate(date.getDate() + 1)) {
            const dayNumber = date.getDay();
            
            if (selectedDays.includes(dayNumber)) {
                enabledDays.push(date.toISOString().slice(0, 10));
            }
        }
    
        return enabledDays;
    }
    
    function updateDatePicker() {
        const dateFrom = new Date(document.getElementById('date-from').value);
        const dateTo = new Date(document.getElementById('date-to').value);
        const checkboxes = document.querySelectorAll('#dias-semana-personalizado input[type="checkbox"]');
        const diasPersonalizadosEliminar = document.getElementById('dias-personalizados-eliminar');
        const eliminarDias = document.getElementById('eliminar-dias');
    
        let selectedDays = [];
    
        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                selectedDays.push(dayNumber(checkbox.value));
            }
        });
    
        const enabledDays = getEnabledDays(dateFrom, dateTo, selectedDays);
    
        flatpickr(diasPersonalizadosEliminar, {
            mode: 'multiple',
            dateFormat: 'Y-m-d',
            minDate: dateFrom,
            maxDate: dateTo,
            enable: enabledDays,
            locale: {
                firstDayOfWeek: 1 // Lunes como primer día de la semana
            },
            onReady: function () {
                this.set('locale', 'es');
            }
        });
    
        if (eliminarDias.checked) {
            diasPersonalizadosEliminar.style.display = 'block';
        } else {
            diasPersonalizadosEliminar.style.display = 'none';
        }
    }
    
    function updateCheckboxListeners() {
    const checkboxes = document.querySelectorAll('#dias-semana-personalizado input[type="checkbox"]');

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', () => {
            updateDatePicker();
        });
    });
}





function handleCheckboxChange(checkboxes, dateFrom, dateTo) {
    let atLeastOneChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

    dateFrom.disabled = atLeastOneChecked;
    dateTo.disabled = atLeastOneChecked;
}

function handleToggleAllChange(checkboxes, toggleAllCheckbox) {
    const isChecked = toggleAllCheckbox.checked;
    checkboxes.forEach(checkbox => {
        checkbox.checked = isChecked;
        checkbox.dispatchEvent(new Event('change'));
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="dias[]"]');
    const dateFrom = document.getElementById('date-from');
    const dateTo = document.getElementById('date-to');
    const toggleAllCheckbox = document.getElementById('toggle-all');
    const eliminarDias = document.getElementById('eliminar-dias');
    const input = document.getElementById("dias-personalizados-eliminar");

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => handleCheckboxChange(checkboxes, dateFrom, dateTo));
    });

    toggleAllCheckbox.addEventListener('change', () => handleToggleAllChange(checkboxes, toggleAllCheckbox));

    if (dateFrom && dateTo) {
        dateFrom.addEventListener('input', updateCustomDates);
        dateTo.addEventListener('input', updateCustomDates);
    }

    if (eliminarDias) {
        eliminarDias.addEventListener('change', togglePersonalizado);
    }

    updateCheckboxListeners();

    eliminarDias.addEventListener("change", function () {
        if (eliminarDias.checked) {
            input.style.display = "inline";
        } else {
            input.style.display = "none";
        }
    });

    const dateForm = document.getElementById('date-form');
    enableAllFieldsBeforeSubmit(dateForm);


});

function enableAllFieldsBeforeSubmit(form) {
    form.addEventListener('submit', () => {
        const dateFrom = document.getElementById('date-from');
        const dateTo = document.getElementById('date-to');
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="dias[]"]');

        dateFrom.disabled = false;
        dateTo.disabled = false;
        checkboxes.forEach(checkbox => {
            checkbox.disabled = false;
        });
    });
}




    
}//final del if



  const toggleLink = document.getElementById("toggle-link");
  const headerRight = document.querySelector(".app-sidebar");

  toggleLink.addEventListener("click", function(e) {
    e.preventDefault();
    headerRight.classList.toggle("none");
  });
//-------------------- ventana seleccionar horas---------------------

if (window.location.pathname.endsWith('select_hours.php')) {


    

// Ocultar todos los elementos .card-body excepto el primero al cargar la página
const cardBodies = document.querySelectorAll('.card-body');
let lastOpened = [];
for (let i = 0; i < cardBodies.length; i++) {
  if (i === 0) {
    lastOpened.push(cardBodies[i]);
  } else {
    cardBodies[i].style.display = 'none';
  }
}

// Controlar el colapso y la expansión del contenido
document.querySelectorAll('.card-header').forEach(function (header) {
    header.addEventListener('click', function () {
      const day = this.getAttribute('data-day');
      const cardBody = document.getElementById('card-body-' + day);
  
      if (cardBody.style.display === 'none') {
        cardBody.style.display = 'flex';
        if (lastOpened.length === 2) {
          lastOpened[0].style.display = 'none';
          lastOpened.shift();
        }
        lastOpened.push(cardBody);
      } else {
        cardBody.style.display = 'none';
        const index = lastOpened.indexOf(cardBody);
        if (index > -1) {
          lastOpened.splice(index, 1);
        }
      }
    });
  });
  








  function getDayFromCard(cardBody) {
    const card = cardBody.closest('.card'); // Find the closest .card element
    return $(card).attr('data-day'); // Get the 'data-day' attribute from the .card element
  }
  

function validateFields(cardBody) {
  let isValid = true;
  cardBody.find('input:not([type="hidden"])').each(function() { // Add :not([type="hidden"])
    if ($(this).val() === '') {
      isValid = false;
      $(this).addClass('is-invalid');
    } else {
      $(this).removeClass('is-invalid');
    }
  });
  return isValid;
}

  



$(document).ready(function() {
  $('body').on('click', '.generate-times', function() {
    const cardBody = $(this).parent().parent();
    const day = getDayFromCard(cardBody);

    if (!validateFields(cardBody)) {
      return;
    }

    const timesContainer = cardBody.find('.times-container').last();
    const newIndex = cardBody.find('.times-container').length;

    const newTimeSlot = `
      <div class="times-container">
        <div class="form-group-left">
          <div class="form-group">
            <label>Hora de inicio:</label>
            <input type="time" class="form-control start-time" name="start_time[${day}][${newIndex}]">
          </div>
          <div class="form-group">
            <label>Hora de finalización:</label>
            <input type="time" class="form-control end-time" name="end_time[${day}][${newIndex}]">
          </div>
        </div>
        <div class="form-group">
          <label>Intervalo (minutos):</label>
          <input type="number" class="form-control interval" min="1" value="30" name="interval[${day}][${newIndex}]">
        </div>
      </div>`;

    cardBody.append(newTimeSlot);

    const newButtonContainer = `
      <div class="buttoncontainer">
        <button type="button" class="btn generate-times">+</button>
        <button type="button" class="btn delete-times">-</button>
      </div>`;

    cardBody.append(newButtonContainer);
    $(this).hide();
    cardBody.find('.delete-times').last().show();
  });
  
    $('body').on('click', '.delete-times', function() {
      const cardBody = $(this).parent().parent();
      $(this).parent().prev('.times-container').remove();
      $(this).parent().remove();
      cardBody.find('.generate-times').last().show();
    });
  });
  




  function validateInputs() {
    let allValid = true;
    document.querySelectorAll('.start-time, .end-time, .interval').forEach(function (input) {
      if (input.value === '') {
        input.classList.add('is-invalid');
        allValid = false;
      } else {
        input.classList.remove('is-invalid');
      }
    });
    return allValid;
  }
  
  document.querySelector('.btn-back').addEventListener('click', function () {
    window.location.href = 'schedule_appointments.php';
  });
  

  document.querySelector('#select-hours-form').addEventListener('submit', function (event) {
  if (!validateInputs()) {
    event.preventDefault();

    // Mostrar todos los elementos colapsados
    document.querySelectorAll('.card-body').forEach(function (cardBody) {
      cardBody.style.display = 'flex';
    });
  }
});

  
  document.addEventListener("DOMContentLoaded", function () {
    // Controlador de eventos para el botón "Atrás"
    const backButton = document.querySelector(".btn.btn-back");
    if (backButton) {
      backButton.addEventListener("click", function (event) {
        event.preventDefault();
  
        // Almacenar los datos del formulario actual en localStorage
        const form = document.getElementById("select-hours-form");
        const formData = new FormData(form);
        for (const [key, value] of formData.entries()) {
          localStorage.setItem(key, value);
        }
  
        // Volver a la página anterior
        window.history.back();
      });
    }
  });
       

}//fin if




if (window.location.pathname.endsWith('preview_appointment.php')) {
  function formatSlotsForDisplay(groupedSlots) {
    let result = '';

    for (const day in groupedSlots) {
        if (groupedSlots.hasOwnProperty(day)) {
            result += day + ': ' + groupedSlots[day].join(', ') + '\n';
        }
    }

    return result;
}


function updateSelectedSlots() {
  const selectedSlotsElement = document.getElementById('selected-slots');
  const checkboxes = document.querySelectorAll('.slot-checkbox:checked');
  const selectedSlots = Array.from(checkboxes).map(checkbox => ({
      day: checkbox.dataset.day,
      slot: checkbox.value
  }));

  const groupedSlots = selectedSlots.reduce((grouped, currentSlot) => {
      if (!grouped[currentSlot.day]) {
          grouped[currentSlot.day] = [];
      }
      grouped[currentSlot.day].push(currentSlot.slot);
      return grouped;
  }, {});

  // Utiliza la función formatSlotsForDisplay() para formatear el texto
  selectedSlotsElement.textContent = formatSlotsForDisplay(groupedSlots);
  return groupedSlots;
}



document.addEventListener('DOMContentLoaded', () => {
  const slotLabels = document.querySelectorAll('.slot-label');
  slotLabels.forEach(label => {
      label.addEventListener('click', (event) => {
          const day = event.target.dataset.day;
          const slot = event.target.textContent;
          const checkbox = document.querySelector(`.slot-checkbox[data-day="${day}"][value="${slot}"]`);

          if (!checkbox) {
              return;
          }

          if (document.getElementById('toggle-delete-mode').checked) {
              checkbox.checked = !checkbox.checked;
              event.target.classList.toggle('selected'); // Agrega o quita la clase 'selected'
              updateSelectedSlots();
          }
      });
  });

  document.getElementById('toggle-delete-mode').addEventListener('change', updateSelectedSlots);
});

document.getElementById('date-form').addEventListener('submit', (event) => {
  const createdSlots = getCreatedSlots();
  document.getElementById('created-slots-json').value = JSON.stringify(createdSlots);

  const checkboxes = document.querySelectorAll('.slot-checkbox:checked');
  const selectedSlots = Array.from(checkboxes).map(checkbox => ({
      day: checkbox.dataset.day,
      slot: checkbox.value
  }));

  document.getElementById('selected-slots-json').value = JSON.stringify(selectedSlots);
});



function getCreatedSlots() {
  const checkboxes = document.querySelectorAll('.slot-checkbox');
  const allSlots = Array.from(checkboxes).map(checkbox => ({
      day: checkbox.dataset.day,
      slot: checkbox.value
  }));

  const groupedSlots = allSlots.reduce((grouped, currentSlot) => {
      if (!grouped[currentSlot.day]) {
          grouped[currentSlot.day] = [];
      }
      grouped[currentSlot.day].push(currentSlot.slot);
      return grouped;
  }, {});

  return groupedSlots;
}



}//fin if

if (window.location.pathname.endsWith('preview_calendar.php')) {

  document.getElementById("btn-back").addEventListener("click", () => {
    window.location.href = "preview_appointment.php";
  });

  document.getElementById("btn-generar-calendario").addEventListener("click", (event) => {
    event.preventDefault();
    const form = document.getElementById("calendar-form");
    const formData = new FormData(form);

    // Muestra el overlay de carga
    document.getElementById("loading-overlay").style.display = "flex";
    formData.append('selected-slots-json', JSON.stringify(selectedSlots));
    formData.append('created-slots-json', JSON.stringify(createdSlots));
    formData.append('generate-calendar', '1');


    // Envía la solicitud AJAX
    fetch("Processes/save_calendar.php", {
      method: "POST",
      body: formData,
  })
      .then((response) => response.json())
      .then((data) => {
          if (data.status === 'success') {
              // Oculta el overlay de carga
              document.getElementById("loading-overlay").style.display = "none";
              // Muestra el ícono de éxito
              document.getElementById("success-overlay").style.display = "flex";
              setTimeout(() => {
                  document.getElementById("success-overlay").style.display = "none";
              }, 3000);
          } else {
              throw new Error(data.message);
          }
      })
      .catch((error) => {
          console.error(error);
          // Oculta el overlay de carga
          document.getElementById("loading-overlay").style.display = "none";
          // Muestra el ícono de error
          document.getElementById("error-overlay").style.display = "flex";
          setTimeout(() => {
              document.getElementById("error-overlay").style.display = "none";
          }, 3000);
      });
});

  
  
}//fin if