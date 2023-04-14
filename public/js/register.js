// Registro de usuario

// Event listeners
document.querySelector('#name').addEventListener('keyup', validaNombre);
document.querySelector('#telefono').addEventListener('keyup', validaTelefono);
document.querySelector('#email').addEventListener('keyup', validaEmail);
document.querySelector('#password').addEventListener('keyup', validaPassword);
document.querySelector('#password_confirmation').addEventListener('keyup', comprobarPasswords);

// Validar nombre
function validaNombre() {
    let elemento = document.forms[0].name;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("* El campo Nombre no puede estar vacío.");

        }
        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("* Formato de nombre incorrecto.");
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
    let elemento = document.forms[0].telefono;
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
    let elemento = document.forms[0].email;
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

// Validar Contraseña
function validaPassword() {
    let elemento = document.forms[0].password;
    comprobarPasswords();
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("* El campo Contraseña no puede estar vacío.");
        }

        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("* Formato de Contraseña incorrecto.");

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
    }
    else {
        password2.setCustomValidity('* Las contraseñas no coinciden.');
        error(password2);
        deleteCheckInput(password2);
        return false;
    }
}

// ERROR
function error(elemento) {
    // DOM
    const input = document.querySelector("#" + elemento.id);
    const span = document.createElement('span');
    span.classList.add("error");
    span.setAttribute('id', 'error' + elemento.id);
    span.textContent = elemento.validationMessage;
    input.insertAdjacentElement("afterend", span);

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
        const input = document.querySelector("#" + elemento.id);
        const icon = document.createElement('i');
        icon.setAttribute('id', 'check' + elemento.id);
        icon.style.color = 'lightgreen';
        icon.classList.add("fa-solid", "fa-check");
        input.insertAdjacentElement("beforebegin", icon);
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
