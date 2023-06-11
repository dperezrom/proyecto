// Formulario de producto

// // Event listeners
document.querySelector('#name').addEventListener('keyup', validaNombre);
document.querySelector('#telefono').addEventListener('keyup', validaTelefono);
document.querySelector('#email').addEventListener('keyup', validaEmail);
document.querySelector('#documento').addEventListener('keyup', validaDocumento);
document.querySelector('#fecha_nac').addEventListener('change', validaFechaNacimiento);
document.querySelector('#rol').addEventListener('change', validaRol);
document.user_form.addEventListener('submit', validaSubmit);

// Validar Nombre
function validaNombre() {
    let elemento = document.user_form.name;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("* El campo Nombre no puede estar vacío.");

        }
        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("* Formato de Nombre incorrecto.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("* El Nombre es demasiado largo.");
        }

        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }
    addCheckInput(elemento);
    return true;
}

// Validar Teléfono
function validaTelefono() {
    let elemento = document.user_form.telefono;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("* El campo Teléfono no puede estar vacío.");

        }
        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("* Formato de Teléfono incorrecto.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("* El Teléfono es demasiado largo.");
        }

        error(elemento);
        deleteCheckInput(elemento);

        return false;
    }

    addCheckInput(elemento);
    return true;
}

// Validar Email
function validaEmail() {
    let elemento = document.user_form.email;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("* El campo Email no puede estar vacío.");

        }
        if (elemento.validity.typeMismatch) {
            elemento.setCustomValidity("* Formato de Email incorrecto.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("* El Email es demasiado largo.");
        }

        error(elemento);
        deleteCheckInput(elemento);

        return false;
    }

    addCheckInput(elemento);
    return true;
}

// Validar Rol
function validaRol() {
    let elemento = document.user_form.rol;
    const options = ['usuario', 'admin'];
    borrarError(elemento);

    if (!options.includes(elemento.value)){
        elemento.setCustomValidity("* El campo Rol contiene un valor incorrecto.");
        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("* El campo Rol no puede estar vacío.");
        }

        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }
    addCheckInput(elemento);
    return true;
}

// Validar Submit
function validaSubmit(e) {
    if(validaNombre() && validaEmail() && validaTelefono() && validaDocumento() && validaFechaNacimiento() && validaRol()){
        return true;
    }
    e.preventDefault();
    return false;
}

// ERROR
function error(elemento) {
    // DOM
    const input = document.querySelector("#" + elemento.id);
    const error = document.createElement('p');
    error.classList.add('error', 'mi-opacidad', 'mt-5');
    error.setAttribute('id', 'error' + elemento.id);
    error.textContent = elemento.validationMessage;
    input.insertAdjacentElement("afterend", error);

    // Añadir class error al input
    elemento.classList.add('error');


}

// Borrar ERROR
function borrarError(elemento) {
    // Eliminar class error del input
    elemento.classList.remove('error');
    elemento.setCustomValidity('');

    // Eliminar mensaje de error
    mensajeError = document.getElementById("error" + elemento.id);
    if (mensajeError) {
        mensajeError.remove();
    }

}

// Añadir Icono Check
function addCheckInput(elemento) {
    // DOM
    if (!document.querySelector("#check" + elemento.id)) {
        const input = document.querySelector("#label_" + elemento.id);
        const icon = document.createElement('i');
        icon.setAttribute('id', 'check' + elemento.id);
        icon.style.color = 'lightgreen';
        icon.classList.add("fa-solid", "fa-check");
        // Efecto
        icon.classList.add("mi-opacidad");
        input.insertAdjacentElement("beforeend", icon);
    }

}

// Borrar Icono Check
function deleteCheckInput(elemento) {
    // DOM
    const check = document.querySelector("#check" + elemento.id);
    if (check) {
        check.remove();
    }

}

// Validar Documento DNI/NIE
function validaDocumento() {
    let elemento = document.user_form.documento;
    borrarError(elemento);

    if (!validaDNINIE(elemento.value)) {
        elemento.setCustomValidity("El DNI/NIE introducido no es valido.");
    }

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("El campo DNI/NIE no puede estar vacío.");

        }
        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("Formato de DNI/NIE incorrecto.");
        }

        error(elemento);
        deleteCheckInput(elemento);

        return false;
    }

    addCheckInput(elemento);
    return true;
}

// Validar DNI
function validaDNINIE(dni) {
    let numero, letra;
    let expresion_regular_dni = /^[XYZ]?\d{5,8}[A-Z]$/;

    dni = dni.toUpperCase();

    if (expresion_regular_dni.test(dni) === true) {
        numero = dni.substring(0, dni.length - 1);
        numero = numero.replace('X', 0);
        numero = numero.replace('Y', 1);
        numero = numero.replace('Z', 2);
        letra = dni.substring(dni.length - 1);
        numero = numero % 23;

        return 'TRWAGMYFPDXBNJZSQVHLCKET'.substring(numero, numero + 1) === letra;
    }
    return false;
}

// Validar Fecha de Nacimiento
function validaFechaNacimiento() {
    let elemento = document.user_form.fecha_nac;
    borrarError(elemento);

    if (!validarEdadLegal(elemento.value)) {
        elemento.setCustomValidity("No eres mayor de edad.");
    }

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("El campo Fecha de Nacimiento no puede estar vacío.");
        }

        error(elemento);
        deleteCheckInput(elemento);

        return false;
    }

    addCheckInput(elemento);
    return true;
}

function validarEdadLegal(fecha) {
    let hoy = new Date();
    let nacimiento = new Date(fecha);
    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    let m = hoy.getMonth() - nacimiento.getMonth();
    if (m < 0 || (m === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }
    return (edad >=18);
}

