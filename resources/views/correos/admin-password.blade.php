<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Contraseña nueva</title>
</head>
<style>
    body {
        background-color: rgb(226 232 240);
        font-size: large;
    }

    .titulo {
        background-color: green;
        color: white;
        display: inline;
        padding: 5px 10px;
        border-radius: 0.375rem;
    }

    .div-datos {
        background-color: white;
        margin-top: 20px;
        padding: 30px;
        display: inline-block;
        border-radius: 0.375rem;
    }
</style>

<body>
    <div class="div-datos">
        <h1 class="titulo">DOÑANA SHOP</h1>
        <p>Hola <b>{{ $userName }}:</b></p>
        <p>La nueva contraseña generada es la siguiente:</p>
        <p>Contraseña: <b>{{ $userPassword }}</b></p>
    </div>
</body>

</html>
