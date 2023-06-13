// Formulario editar comentario modo admin

// Event listeners
window.addEventListener('load', function() {
    validaPuntuacion();
    validaTitulo();
    validaComentario();
    contarCaracteres();
});

document.querySelector('#puntuacion').addEventListener('change', validaPuntuacion);
document.querySelector('#titulo').addEventListener('keyup', validaTitulo);
document.querySelector('#comentario').addEventListener('keyup', validaComentario);
document.querySelector('#comentario').addEventListener('keyup', contarCaracteres);
document.valoracion_form.addEventListener('submit', validaSubmit);



// Validar puntuación
function validaPuntuacion() {
    let elemento = document.valoracion_form.puntuacion;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("*");
        }

        error(elemento);
        return false;
    }
    return true;
}

// Validar nombre
function validaTitulo() {
    let elemento = document.valoracion_form.titulo;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("El campo Título no puede estar vacío.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("El Título es demasiado largo.");
        }

        error(elemento);
        deleteCheckInput(elemento);
        return false;
    }
    addCheckInput(elemento);
    return true;
}

// Validar nombre
function validaComentario() {
    let elemento = document.valoracion_form.comentario;
    borrarError(elemento);

    if (!elemento.checkValidity()) {
        if (elemento.validity.valueMissing) {
            elemento.setCustomValidity("El comentario no puede estar vacío.");
        }

        if (elemento.validity.tooLong) {
            elemento.setCustomValidity("El comentario supera el límite de caracteres.");
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
    if(validaTitulo() && validaComentario()){
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
    error.classList.add('error', 'mi-opacidad', 'mt-3');
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
        icon.classList.add("fa-solid", "fa-check", 'pl-2');
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

// Caracteres del comentario
function contarCaracteres() {
    let comentario = document.querySelector('#comentario');
    document.querySelector('#caracteres_comentario').textContent = comentario.value.length + " de 250 caracteres";
}
