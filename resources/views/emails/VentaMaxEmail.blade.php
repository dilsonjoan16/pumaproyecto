<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bloqueo PUMA</title>
</head>
<body>
    <div>
        <h1>
            AVISO DE BLOQUEO DE NUMERO PARCIAL
        </h1>
        <h2>
            HEY!
        </h2>
        <i>
            Estimado {{$contacto[2]}}, se le notifica del bloqueo parcial del siguiente numero
            con su respectiva loteria, de forma tal, que no se realice ninguna venta ya que el mismo alcanzo su <strong>monto maximo establecido</strong>.
        </i>
        <br>
        <p>
            <strong>
                Numero bloqueado:
            </strong>
            {{$contacto[0]}}
        </p>
        <p>
            <strong>
                Loteria respectiva:
            </strong>
            {{$contacto[1]}}
        </p>
        <p>
            Dado este aviso, se deja advertido a todo el recurso humano que forma parte del <strong>extraordinario</strong> equipo PUMA, se les solicita encarecidamente ser atentos.
        </p>
        <br>
        <i>
            RECORDAR: NUMERO BLOQUEADO <strong>{{$contacto[0]}}</strong> DE LA LOTERIA RESPECTIVA <strong>{{$contacto[1]}}</strong>
        </i>
    </div>
</body>
</html>
