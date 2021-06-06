<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prueba de Roles</title>
</head>
<body>
    <h1>
        Vista para asignar un rol
    </h1>
    <p>
        <h3>
            Usuarios modoficables
        </h3>
        <table>
        <thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Nombre
                </th>
                <th>
                    Correo
                </th>
                <th>
                    Accion
                </th>
                <th></th>
            </tr>
        </thead>
        <br>
        <tbody>
                 <tr>
                     <td>{{$user->id}}</td>
                     <td>{{$user->name}}</td>
                     <td>{{$user->email}}</td>
                     <td>
                         <button>
                            <a href="{{route('admin.vendedores.show',$user)}}">Editar </a>
                        </button>
                     </td>
                 </tr>

            
        </tbody>
        </table>
    </p>
    <a href="">Link del administrador</a>
    <br>
    <a href="">Link del promotor</a>
    <br>
    <a href="">Link del vendedor</a>
    <br>
</body>
</html>