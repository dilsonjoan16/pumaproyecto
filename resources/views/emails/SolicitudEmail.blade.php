<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SOLICITUD PUMA</title>
</head>
<body>
    @if ($contacto[0] == "Prestamo/Credito")
    <div>
        <h1>
            SOLICITUD INTERNA PUMA
        </h1>
        <p>
            <h2>
                HEY!
            </h2>
                Estimado Usuario <strong>PUMA</strong>, se acaba de realizar una <strong>SOLICITUD</strong> dentro del sistema.
                Caracteristicas:
        </p>
        <p>
            <strong>
                CATEGORIA DE LA SOLICITUD:
            </strong>
            {{$contacto[0]}}
        </p>
        <p>
            <strong>
                CANTIDAD SOLICITADA:
            </strong>
            {{$contacto[1]}}
            <strong>COP</strong>
        </p>
        <p>
            <strong>
                CUOTAS A PAGAR:
            </strong>
            {{$contacto[2]}}
            <strong>CUOTAS</strong>
        </p>
        <p>
            <strong>
                SOLICITANTE:
            </strong>
            {{$contacto[3]}}
        </p>
        <p>
            <i>
                El solicitante <strong>{{$contacto[3]}}</strong>, espera una pronta respuesta de su parte. Hasta entonces queda atento.
            </i>
        </p>
        <p>
            <strong>
                <i>
                    Muchas Gracias por usar el sistema PUMA C.A
                </i>
            </strong>
        </p>
    </div>
    @endif
    @if ($contacto[0] == "Mobiliario")
    <div>
        <h1>
            SOLICITUD INTERNA PUMA
        </h1>
        <p>
            <h2>
                HEY!
            </h2>
                Estimado Usuario <strong>PUMA</strong>, se acaba de realizar una <strong>SOLICITUD</strong> dentro del sistema.
                Caracteristicas:
        </p>
        <p>
            <strong>
                CATEGORIA DE LA SOLICITUD:
            </strong>
            {{$contacto[0]}}
        </p>
        <p>
            <strong>
                MOBILIARIO SOLICITADO:
            </strong>
            {{$contacto[1]}}
        </p>
        <p>
            <strong>
                UBICACION:
            </strong>
            {{$contacto[2]}}
        </p>
        <p>
            <strong>
                SOLICITANTE:
            </strong>
            {{$contacto[3]}}
        </p>
        <p>
            <i>
                El solicitante <strong>{{$contacto[3]}}</strong>, espera una pronta respuesta de su parte. Hasta entonces queda atento.
            </i>
        </p>
        <p>
            <strong>
                <i>
                    Muchas Gracias por usar el sistema PUMA C.A
                </i>
            </strong>
        </p>
    </div>
    @endif
    @if ($contacto[0] == "Solicitud/Otro")
    <div>
        <h1>
            SOLICITUD INTERNA PUMA
        </h1>
        <p>
            <h2>
                HEY!
            </h2>
                Estimado Usuario <strong>PUMA</strong>, se acaba de realizar una <strong>SOLICITUD</strong> dentro del sistema.
                Caracteristicas:
        </p>
        <p>
            <strong>
                CATEGORIA DE LA SOLICITUD:
            </strong>
            {{$contacto[0]}}
        </p>
        <p>
            <strong>
                SOLICITUD:
            </strong>
            {{$contacto[1]}}
        </p>
        <p>
            <strong>
                SOLICITANTE:
            </strong>
            {{$contacto[2]}}
        </p>
        <p>
            <i>
                El solicitante <strong>{{$contacto[2]}}</strong>, espera una pronta respuesta de su parte. Hasta entonces queda atento.
            </i>
        </p>
        <p>
            <strong>
                <i>
                    Muchas Gracias por usar el sistema PUMA C.A
                </i>
            </strong>
        </p>
    </div>
    @endif

</body>
</html>
