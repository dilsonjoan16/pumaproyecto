<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contacto PUMA</title>
</head>
<body>
    <!-- contactanosblade = testemail-->
    <h1>
        Contacto PUMA
    </h1>
    <p>
        <strong>
            Nombre: 
        </strong>
        {{$contacto['nombre_contacto']}}
    </p>
    <p>
        <strong>
            Correo: 
        </strong>
        {{$contacto['correo_contacto']}}
    </p>
    <p>
        <strong>
            Mensaje: 
        </strong>
        {{$contacto['mensaje_contacto']}}
    </p>
</body>
</html>