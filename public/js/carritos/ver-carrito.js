function enforce_maxlength(event) {
    let t = event.target;
    if (t.hasAttribute('maxlength')) {
        t.value = t.value.slice(0, t.getAttribute('maxlength'));
    }
}
function enforce_minlength(event) {
    let t = event.target;
    if (t.hasAttribute('minlength') && t.value === '') {

        t.value = t.getAttribute('minlength');
    }
}
document.body.addEventListener('input', enforce_maxlength);
document.body.addEventListener('input', enforce_minlength);
