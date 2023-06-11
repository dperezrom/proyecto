// Registro de usuario

// Event listeners
document.querySelector('#name').addEventListener('keyup', validaNombre);
document.querySelector('#telefono').addEventListener('keyup', validaTelefono);
document.querySelector('#email').addEventListener('keyup', validaEmail);
document.querySelector('#password').addEventListener('keyup', validaPassword);
document.querySelector('#password_confirmation').addEventListener('keyup', comprobarPasswords);
document.querySelector('#documento').addEventListener('keyup', validaDocumento);
document.querySelector('#fecha_nac').addEventListener('change', validaFechaNacimiento);

// Validar nombre
function validaNombre() {
    let elemento = document.forms[0].name;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("El campo Nombre no puede estar vacío.");

        }
        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("Formato de nombre incorrecto.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("El Nombre es demasiado largo.");
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
    let elemento = document.forms[0].telefono;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("El campo Teléfono no puede estar vacío.");

        }
        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("Formato de Teléfono incorrecto.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("El Teléfono es demasiado largo.");
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
    let elemento = document.forms[0].email;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("El campo Email no puede estar vacío.");

        }
        if (elemento.validity.typeMismatch) {
            elemento.setCustomValidity("Formato de Email incorrecto.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("El Email es demasiado largo.");
        }

        error(elemento);
        deleteCheckInput(elemento);

        return false;
    }

    addCheckInput(elemento);
    return true;
}

// Validar Contraseña
function validaPassword() {
    let elemento = document.forms[0].password;
    comprobarPasswords();
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("El campo Contraseña no puede estar vacío.");
        }

        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("Formato de Contraseña incorrecto.");

        }

        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }

    addCheckInput(elemento);
    return true;
}

// Validar Confirmar Contraseña
function comprobarPasswords() {
    const password1 = document.forms[0].password;
    const password2 = document.forms[0].password_confirmation;

    borrarError(password2);

    if (password1.value == password2.value && password2.value != '') {
        addCheckInput(password2);
        return true;
    } else {
        password2.setCustomValidity('Las contraseñas no coinciden.');
        error(password2);
        deleteCheckInput(password2);
        return false;
    }
}

// ERROR
function error(elemento) {
    // DOM
    const divInput = document.querySelector("#" + elemento.id).parentNode;
    const div = document.createElement('div');
    div.classList.add('error', 'py-1');
    div.setAttribute('id', 'error' + elemento.id);
    div.textContent = elemento.validationMessage;
    divInput.insertAdjacentElement("afterend", div);

    // Añadir class error al input
    elemento.classList.add('error');

}

// Borrar ERROR
function borrarError(elemento) {
    // Eliminar class error del input
    elemento.classList.remove('error');
    elemento.setCustomValidity('');

    // Eliminar mensaje de error
    const mensajeError = document.getElementById("error" + elemento.id);
    if (mensajeError) {
        mensajeError.remove();
    }

}

// Añadir Icono Check
function addCheckInput(elemento) {
    // DOM
    if (!document.querySelector("#check" + elemento.id)) {
        const label = document.querySelector("#label_" + elemento.id);
        const icon = document.createElement('i');
        icon.setAttribute('id', 'check' + elemento.id);
        icon.style.color = 'lightgreen';
        icon.classList.add("fa-solid", "fa-check");
        label.insertAdjacentElement("afterend", icon);
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
    let elemento = document.forms[0].documento;
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
    let elemento = document.forms[0].fecha_nac;
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
