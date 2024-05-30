<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C R U D K O S M O S</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token()}}">
</head>

<body>
    <div class="container">
        <div class="card m-3">
            <div class="card-header">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <div class="flex-grow-1 text-center">
                        <h2 class="mb-0">Tabla Clientes KOSMOS</h2>
                        <h7 class="mt-0">(Agustín Escobedo Vargas)</h7>
                    </div>
                    <button class="btn btn-primary btn_agregar_cliente" type="button" data-bs-toggle="modal"
                        data-bs-target="#crud_modal">Agregar Cliente</button>
                </div>
            </div>
            <div class="card-body">
                <div id="contenido_tabla">
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="crud_modal" tabindex="-1" aria-labelledby="crud_modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title_modal">Registrar Clientes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formulario_clientes">
                        @csrf
                        <input type="hidden" name="tipo_formulario" id="tipo_formulario" value="">
                        <input type="hidden" name="id_cliente_editar" id="id_cliente_editar" value="">
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label for="nombre_cliente" class="form-label">Nombre </label>
                                        <input type="text" name="nombre_cliente" class="form-control"
                                            id="nombre_cliente" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellido_paterno_cliente" class="form-label">Apellido
                                            paterno</label>
                                        <input type="text" name="apellido_paterno_cliente" class="form-control"
                                            id="apellido_paterno_cliente" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellido_materno_cliente" class="form-label">Apellido
                                            materno</label>
                                        <input type="text" name="apellido_materno_cliente" class="form-control"
                                            id="apellido_materno_cliente" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edad_cliente" class="form-label">Edad</label>
                                        <input type="number" name="edad_cliente" class="form-control" id="edad_cliente"
                                            min="1" max="100" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="correo_empleado" class="form-label">Correo</label>
                                        <input type="email" name="correo_empleado" class="form-control"
                                            id="correo_empleado" aria-describedby="emailHelp" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="numero_cliente" class="form-label">Numero</label>
                                        <input type="tel" name="numero_cliente" class="form-control" id="numero_cliente"
                                            pattern="[0-9]{10}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {
            mostrar_lista_clientes();
            $(".btn_agregar_cliente").click(function () {
                //console.log("Agregandooo....");
                $("#tipo_formulario").val(1);
                $("#id_cliente_editar").val("");
            });
            //SECCION DE VALIDACION
            $("#formulario_clientes").validate({
                submitHandler: function (form) {
                    registrar_clientes();
                }
            });
        });

        function mostrar_lista_clientes() {
            // Petición AJAX
            $.ajax({
                type: 'POST',
                url: '{{ route('clientes.lista') }}',
                dataType: 'json',
                beforeSend: function () {
                    $("#contenido_tabla").html('<div class="cargando"><i class="fa-solid fa-spinner fa-5x"></i></div>');
                },
                error: function (data) {
                    let errorRespuesta = JSON.parse(data.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: errorRespuesta.message,
                        footer: '<a href="#">Vuelve a intentarlo</a>'
                    });
                },
                success: function (data) {
                    $("#title_modal").html("Agregar cliente");
                    $("#contenido_tabla").html(data.html);
                    btn_editar_cliente();
                    btn_eliminar_cliente();
                }
            });
        }
        function btn_editar_cliente(){
            $("#tabla_clientes tbody").on('click','.btn_editar_cliente',function(){
                let id_cliente = $(this).attr('data-id-cliente');
                $("#tipo_formulario").val(2);
                $("#id_cliente_editar").val(id_cliente);
                //console.log("ID CLIENTE");
                //console.log(id_cliente);
                $.ajax({
                type: 'POST',
                url: '{{ route('clientes.obtener_cliente') }}',
                data:{id_cliente:id_cliente},
                dataType: 'json',
                beforeSend: function () {
                    /*$("#contenido_tabla").html('<div class="cargando"><i class="fa-solid fa-spinner fa-5x"></i></div>');*/

                },
                error: function (data) {
                    let errorRespuesta = JSON.parse(data.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: errorRespuesta.message,
                        footer: '<a href="#">Vuelve a intentarlo</a>'
                    });
                },
                success: function (data) {
                    //console.log(data.cliente);
                    let cliente = data.cliente;
                    $("#title_modal").html("Actualizar cliente");
                    $("#nombre_cliente").val(cliente.nombre);
                    $("#apellido_paterno_cliente").val(cliente.apellido_paterno);
                    $("#apellido_materno_cliente").val(cliente.apellido_materno);
                    $("#edad_cliente").val(cliente.edad);
                    $("#correo_empleado").val(cliente.correo);
                    $("#numero_cliente").val(cliente.telefono);
                    $("#crud_modal").modal('show');
                }
            });
                
            })
        }
        function btn_eliminar_cliente(){
    $("#tabla_clientes tbody").on('click', '.btn_eliminar_cliente', function(){
        let id_cliente_eliminar = $(this).attr('data-id-cliente');
        Swal.fire({
            title: '¿Está seguro de eliminar este cliente?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('clientes.eliminar') }}',
                    data: {id_cliente: id_cliente_eliminar},
                    dataType: 'json',
                    success: function(data) {
                        if (data.code === 200) {
                            Swal.fire('Eliminado!', data.message, 'success');
                            mostrar_lista_clientes(); 
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    },
                    error: function(data) {
                        Swal.fire('Error!', 'No se pudo eliminar el cliente.', 'error');
                    }
                });
            }
        });
    });
}


        function registrar_clientes() {
            Swal.fire({
                title: "¿Está seguro?",
                icon: 'warning',
                text: "Verifique sus campos antes de enviarlos.",
                showCancelButton: true,
                confirmButtonText: "Sí, estoy seguro",
                denyButtonText: `Cancelar`,
                preConfirm: () => {
                    let token = $('meta[name="csrf-token"]').attr('content');
                    let formElements = document.getElementById("formulario_clientes");
                    let formData = new FormData(formElements);
                    return fetch('{{ route('clientes.registrar')}}',{
                        method: "POST",
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': token
                        }
                    }).then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(text)
                            })
                        } else {
                            return response.json()
                        }
                    }).catch(response => {
                        let texto = JSON.parse(response.toString().substring(7));
                        let mensaje = texto.message;
                        Swal.showValidationMessage(
                            `Error: ${mensaje}`
                        )

                    });
                }
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Inserción Correcta",
                        text: "Sus datos han sido registrados correctamente",
                        icon: "success"
                    });
                    $("#formulario_clientes")[0].reset();
                    $("#crud_modal").modal('hide');
                    mostrar_lista_clientes();
                } else if (result.isDenied) {
                    Swal.fire("Erro al registrar", "", "info");
                }
            });
        }
    </script>

</body>

</html>