<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recuperacion de Password</title>
</head>
<body>
    <h1>
        Recuperacion de password PUMA 
    </h1>
    <p>
    Estimado 
        <strong>
             {{$contacto[1]}}
        </strong>
        Hemos recibido desde su direccion de correo una solicitud para el restablecimiento de su password. <br>
        Tras realizar una verificacion en nuestra base de datos encontramos que su usuario si se encuentra 
        registrado, por ende, el sistema PUMA C.A le otorgara una password provicional que puede ser modificada
        posteriormente dentro del sistema. <br> Respondiendo con total responsabilidad a su solicitud PUMA C.A
    </p>
    <p>
        <strong>
            Password Provisional: 
        </strong>
        {{$contacto[0]}}
        <br>
        <i>
            Esta password debe usarla para ingresar al sistema con su correo.
        </i>
    </p>
    <p>
        <strong>
            IMPORTANTE:  
        </strong>
        Si usted no solicito ningun cambio de password, se le pide encarecidamente no hacer absolutamente nada con esta informacion
        que se le esta brindando y de manera inmediata comunicarse con el personal de la empresa
        o a traves, del apartado <strong>CONTACTANOS</strong> nos haga saber su situacion, para asi tomar cartas en el asunto. <br><br>
            <strong>
                MUCHAS GRACIAS POR CONFIAR EN NOSOTROS Y USAR EL SISTEMA DE PUMA C.A 
            </strong>
    </p>
</body>
</html>