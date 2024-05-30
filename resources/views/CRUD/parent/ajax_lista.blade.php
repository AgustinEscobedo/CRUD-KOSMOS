<table class="table" id="tabla_clientes">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido Paterno</th>
            <th scope="col">Apellido Materno</th>
            <th scope="col">Edad</th>
            <th scope="col">Correo</th>
            <th scope="col">Telefono</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $row)
            <tr>
                <th scope="row">{{$row->id}}</th>
                <td>{{$row->nombre}}</td>
                <td>{{$row->apellido_paterno}}</td>
                <td>{{$row->apellido_materno}}</td>
                <td>{{$row->edad}}</td>
                <td>{{$row->correo}}</td>
                <td>{{$row->telefono}}</td>
                <td>
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-success btn_editar_cliente" data-id-cliente="{{$row->id}}" type="button">Editar</button>
                        <button class="btn btn-danger btn_eliminar_cliente" data-id-cliente="{{$row->id}}" type="button">Eliminar</button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>