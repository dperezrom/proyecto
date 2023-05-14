// Formulario de categoría

// Event listeners
document.querySelector('#nombre').addEventListener('keyup', validaNombre);
document.querySelector('#descripcion').addEventListener('keyup', validaDescripcion);

// Validar nombre
function validaNombre() {
    let elemento = document.categoria_form.nombre;
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

// Validar Descripción
function validaDescripcion() {
    let elemento = document.categoria_form.descripcion;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("* El campo Descripción no puede estar vacío.");

        }
        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("* Formato de Descripción incorrecto.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("* El campo Descripción es demasiado largo.");
        }

        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }
    addCheckInput(elemento);
    return true;
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
