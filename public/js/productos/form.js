// Formulario de producto

// // Event listeners
document.querySelector('#denominacion').addEventListener('keyup', validaDenominacion);
document.querySelector('#descripcion').addEventListener('keyup', validaDescripcion);
document.querySelector('#precio').addEventListener('keyup', validaPrecio);
document.querySelector('#stock').addEventListener('keyup', validaStock);
document.querySelector('#descuento').addEventListener('keyup', validaDescuento);
document.querySelector('#categoria_id').addEventListener('keyup', validaCategoria);
document.producto_form.addEventListener('submit', validaSubmit);

// Validar Denominación
function validaDenominacion() {
    let elemento = document.producto_form.denominacion;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("* El campo Denominación no puede estar vacío.");
        }

        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("* Formato de Denominación incorrecto.");
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
    let elemento = document.producto_form.descripcion;
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

// Validar Precio
function validaPrecio() {
    let elemento = document.producto_form.precio;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("* El campo Precio no puede estar vacío.");
        }

        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("* Formato de Precio incorrecto.");
        }

        if (elemento.validity.rangeUnderflow) {
            elemento.setCustomValidity("* El campo Precio no puede ser negativo.");
        }

        if (elemento.validity.rangeOverflow) {
            elemento.setCustomValidity("* Cantidad permitida excedida (9999).");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("* El campo Precio solo admite 4 números enteros y 2 decimales.");
        }


        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }
    addCheckInput(elemento);
    return true;
}

// Validar Stock
function validaStock() {
    let elemento = document.producto_form.stock;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("* El campo Stock no puede estar vacío.");
        }

        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("* Formato de Stock incorrecto.");
        }

        if (elemento.validity.rangeUnderflow) {
            elemento.setCustomValidity("* El campo Stock no puede ser negativo.");
        }

        if (elemento.validity.rangeOverflow) {
            elemento.setCustomValidity("* Cantidad permitida excedida (999999).");
        }

        if (elemento.validity.stepMismatch) {
            elemento.setCustomValidity("* El campo Stock no puede tener decimales.");
        }

        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }
    addCheckInput(elemento);
    return true;
}

// Validar Descuento
function validaDescuento() {
    let elemento = document.producto_form.descuento;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("* El campo Descuento no puede estar vacío.");
        }

        if (elemento.validity.patternMismatch) {
            elemento.setCustomValidity("* Formato de Descuento incorrecto.");
        }

        if (elemento.validity.rangeUnderflow) {
            elemento.setCustomValidity("* El campo Descuento no puede ser negativo.");
        }

        if (elemento.validity.rangeOverflow) {
            elemento.setCustomValidity("* Cantidad permitida excedida (100).");
        }

        if (elemento.validity.stepMismatch) {
            elemento.setCustomValidity("* El campo Descuento no puede tener decimales.");
        }

        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }
    addCheckInput(elemento);
    return true;
}

// Validar Categoría
function validaCategoria() {
    let elemento = document.producto_form.categoria_id;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("* El campo Categoría no puede estar vacío.");
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
    if(validaDenominacion() && validaDescripcion() && validaPrecio() && validaStock() && validaDescuento() && validaCategoria()){
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

