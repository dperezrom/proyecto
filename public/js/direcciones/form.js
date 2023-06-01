// Formulario de direcciones del usuario

// Event listeners
window.addEventListener('load', function() {
    contarCaracteres();
});

document.querySelector('#nombre').addEventListener('keyup', validaNombre);
document.querySelector('#telefono').addEventListener('keyup', validaTelefono);
document.querySelector('#calle').addEventListener('keyup', validaCalle);
document.querySelector('#ciudad').addEventListener('keyup', validaCiudad);
document.querySelector('#provincia').addEventListener('keyup', validaProvincia);
document.querySelector('#cp').addEventListener('keyup', validaCodigoPostal);
document.querySelector('#instruccion').addEventListener('keyup', validaInstruccion);
document.querySelector('#instruccion').addEventListener('keyup', contarCaracteres);
document.direccion_form.addEventListener('submit', validaSubmit);

// Validar nombre
function validaNombre() {
    let elemento = document.direccion_form.nombre;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("El campo Nombre no puede estar vacío.");
        }

        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("Formato de Nombre incorrecto.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("El campo Nombre es demasiado largo.");
        }

        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }
    addCheckInput(elemento);
    return true;
}

// Validar teléfono
function validaTelefono() {
    let elemento = document.direccion_form.telefono;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("El campo Teléfono no puede estar vacío.");
        }

        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("Formato de Teléfono incorrecto.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("El campo Teléfono es demasiado largo.");
        }

        error(elemento);
        deleteCheckInput(elemento);

        return false;
    }

    addCheckInput(elemento);
    return true;
}

// Validar calle
function validaCalle() {
    let elemento = document.direccion_form.calle;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("El campo Calle no puede estar vacío.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("El campo Calle es demasiado largo.");
        }

        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }
    addCheckInput(elemento);
    return true;
}

// Validar ciudad
function validaCiudad() {
    let elemento = document.direccion_form.ciudad;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("El campo Ciudad no puede estar vacío.");
        }

        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("Formato de Ciudad incorrecto.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("El campo Ciudad es demasiado largo.");
        }

        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }
    addCheckInput(elemento);
    return true;
}

// Validar provincia
function validaProvincia() {
    let elemento = document.direccion_form.provincia;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("El campo Provincia no puede estar vacío.");
        }

        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("Formato de Provincia incorrecto.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("El campo Provincia es demasiado largo.");
        }

        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }
    addCheckInput(elemento);
    return true;
}

// Validar código postal
function validaCodigoPostal() {
    let elemento = document.direccion_form.cp;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("El campo Código Postal no puede estar vacío.");
        }

        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("Formato de Código Postal incorrecto.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("El campo Código Postal es demasiado largo.");
        }

        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }
    addCheckInput(elemento);
    return true;
}

// Validar instrucción
function validaInstruccion() {
    let elemento = document.direccion_form.instruccion;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("El campo Instrucción es demasiado largo.");
        }

        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }
    addCheckInput(elemento);
    return true;
}

// Caracteres de la instrucción
function contarCaracteres() {
    let textarea = document.querySelector('#instruccion');
    document.querySelector('#caracteres_instruccion').textContent = textarea.value.length + " de 250 caracteres";
}

// Validar Submit
function validaSubmit(e) {
    if (validaNombre() && validaTelefono() && validaCalle() && validaCiudad() && validaProvincia()
        && validaCodigoPostal() && validaInstruccion()) {
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
    error.classList.add('error', 'mi-opacidad', 'mt-5', 'text-center');
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
