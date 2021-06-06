<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>
        Formulario de contacto
    </h1>
    <form action="{{route('contactanos.store')}}" method="post">
        @csrf
        <label for="">
            Nombre
            <br>
            <input type="text" name="nombre_contacto" id="">
        </label>
        <br>
        <label for="">
            Correo
            <br>
            <input type="text" name="correo_contacto" id="">
        </label>
        <br>
        <label for="">
            Mensaje
            <br>
            <textarea name="mensaje_contacto" rows="10"></textarea>
        </label>
        <br>
        <button type="submit">Enviar mensaje</button>
    </form>
</body>
</html>