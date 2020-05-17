<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Prueba EYSS Leonardo Lama</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>

</head>
<style>
    .alert-message {
        color: red;
    }
</style>
<body>

<div class="container">
    <h2 style="margin-top: 12px;" class="alert alert-success">API de Categorias y Productos</h2><br>
    <div class="row">
        <div class="col-12 text-right">
            <a href="javascript:void(0)" class="btn btn-success mb-3" id="crear-producto" onclick="addProducto()">Agregar Producto</a>
        </div>
    </div>
    <div class="row" style="clear: both;margin-top: 18px;">
        <div class="col-12">
            <table id="categorias" class="table table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Categorias</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($categorias as $categoria)
                    <tr id="row_{{$categoria->id}}">
                        <td>{{ $categoria->id  }}</td>
                        <td>
                            <div class="col-md-12" id="categoria_{{$categoria->id}}"> {{ $categoria->categoria }} </div>
                        </td>
                        <td class="row">
                            <div class="col-md-4"> <a href="javascript:void(0)" data-id="{{ $categoria->id }}" onclick="verProductos({{  $categoria }})" class="btn btn-info">Ver Productos</a> </div>
                            <div class="col-md-4"> <a href="javascript:void(0)" data-id="{{ $categoria->id }}" class="btn btn-danger" onclick="eliminarCategoria({{ $categoria }})">Eliminar</a> </div>
                            <div class="col-md-4"> <a href="javascript:void(0)" data-id="{{ $categoria->id }}" onclick="editCategoria({{ $categoria }})" class="btn btn-info">Editar</a> </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="main-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="modal-header" class="modal-header">

            </div>
            <div id="modal-body" class="modal-body">

            </div>
            <div id="modal-footer" class="modal-footer">

            </div>
        </div>
    </div>
</div>
</body>
<script>
    function cerrarModal(){
        $('#main-modal').modal('hide');
    }

    $("#main-modal").on("hidden.bs.modal", function(){
        $("#modal-header").empty();
        $("#modal-body").empty();
        $("#modal-footer").empty();
    });

    function addProducto() {
        $('#main-modal').modal('show');
        document.getElementById("modal-header").innerHTML += '<h4 class="modal-title">Agregar Producto</h4>';
        document.getElementById("modal-body").innerHTML += '<form name="userForm" class="form-horizontal"> \
                        <input type="hidden" name="catgoria_id" id="catgoria_id"> \
                        <div class="form-group"> \
                            <label for="name" class="col-sm-2">Producto</label> \
                            <div class="col-sm-12"> \
                                <input type="text" class="form-control" id="title" name="title" placeholder="Ingresar Nombre del Producto"> \
                                <span id="productoError" class="alert-message"></span> \
                            </div> \
                        </div> \
                        <div class="form-group"> \
                            <label class="col-sm-2">Categoria</label> \
                            <div class="col-sm-12"> \
                                <select name="categoria" id="categoria"> \
                                @foreach($categorias as $categoria) \
                                    <option value=" {{ $categoria->id }} "> {{ $categoria->categoria }} </option> \
                                @endforeach \
                                </select> \
                                <span id="categoriaError" class="alert-message"></span> \
                            </div> \
                        </div> \
                      </form>';
        document.getElementById("modal-footer").innerHTML += "<button type='button' class='btn btn-primary' onclick='createProduct()'>Guardar</button>";
        document.getElementById("modal-footer").innerHTML += "<button type='button' class='btn btn-danger' onclick='cerrarModal()'>Cerrar</button>";
    }

    function createProduct() {
        var producto = $('#title').val();
        var e = document.getElementById("categoria");
        var categoria = e.options[e.selectedIndex].value;
        let _url     = `/producto_nuevo`;
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: _url,
            type: "POST",
            data: {
                producto: producto,
                categoria: categoria,
                _token: _token
            },
            success: function(response) {
                if(response.code == 200) {
                    $("#modal-body").empty();
                    $("#modal-footer").empty();
                    document.getElementById("modal-body").innerHTML += "<h1 style='color:green;'>"+ response.message +"</h1>";
                    document.getElementById("modal-footer").innerHTML += "<button type='button' class='btn btn-danger' onclick='cerrarModal()'>Cerrar</button>";
                }
            },
            error: function(response) {
                $('#productoError').text(response.responseJSON.errors.title);
                $('#categoriaError').text(response.responseJSON.errors.producto);
            }
        });
    }

    function editCategoria(data){
        $('#main-modal').modal('show');
        document.getElementById("modal-header").innerHTML += '<h4 class="modal-title">Editar '+ data.categoria +'</h4>';
        document.getElementById("modal-body").innerHTML += '<form name="userForm" class="form-horizontal"> \
                        <input type="hidden" name="catgoria_id" id="catgoria_id"> \
                        <div class="form-group"> \
                            <label for="name" class="col-sm-2">Categoria</label> \
                            <div class="col-sm-12"> \
                                <input type="text" class="form-control" id="categoria" name="title" placeholder="Ingresar Nombre de la Categoria"> \
                                <span id="productoError" class="alert-message"></span> \
                            </div> \
                        </div> \
                      </form>';
        document.getElementById("modal-footer").innerHTML += "<button type='button' class='btn btn-primary' onclick='editarCategoria("+data.id+")'>Guardar</button>";
        document.getElementById("modal-footer").innerHTML += "<button type='button' class='btn btn-danger' onclick='cerrarModal()'>Cerrar</button>";
    }

    function editarCategoria(data) {
        let _url = `/editar_categoria/${data}`;
        var editado = $('#categoria').val();
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: _url,
            type: "POST",
            data: {
                id: data,
                edited: editado,
                _token: _token
            },
            success: function(response) {
                if(response.code == 200) {
                    $("#modal-body").empty();
                    $("#modal-footer").empty();
                    document.getElementById("modal-body").innerHTML += "<h1 style='color:green;'>"+ response.message +"</h1>";
                    document.getElementById("categoria_"+response.data.id).innerHTML = response.data.categoria;
                    document.getElementById("modal-footer").innerHTML += "<button type='button' class='btn btn-danger' onclick='cerrarModal()'>Cerrar</button>";
                }
            },
            error: function(response) {
                $('#productoError').text(response.responseJSON.errors.title);
                $('#categoriaError').text(response.responseJSON.errors.producto);
            }
        });
    }

    function verProductos(data) {
        document.getElementById("modal-header").innerHTML += '<h4 class="modal-title">Productos de '+ data.categoria +'</h4>';
        document.getElementById("modal-body").innerHTML += '<table id="productos_table" class="table table-sm table-bordered"> \
                                                                <thead> \
                                                                    <tr> \
                                                                        <th>ID</th> \
                                                                        <th>Nombre del Producto</th> \
                                                                    </tr> \
                                                                </thead> \
                                                                <tbody id="productos_body"> \
                                                                </tbody>\
                                                            </table>';
        let _url = `/productos/${data.id}`;

        $('#titleError').text('');
        $('#descriptionError').text('');
        $.ajax({
            url: _url,
            type: "GET",
            success: function(response) {
                if(response) {
                    const div = document.createElement('div');
                    div.id = 'lista_productos';
                    document.getElementById('modal-body').appendChild(div);
                    response.forEach(function (item, index) {
                        document.getElementById("productos_body").innerHTML += '<tr> \
                                                                    <th>'+item.id+'</th> \
                                                                    <td>'+item.producto+'</td> \
                                                                </tr>';
                    })
                    document.getElementById("modal-footer").innerHTML += "<button type='button' class='btn btn-danger' onclick='cerrarModal()'>Cerrar</button>";
                    $('#main-modal').modal('show');
                }
            }
        });
    }

    function eliminarCategoria(data){
        $('#main-modal').modal('show');
        document.getElementById("modal-header").innerHTML += '<h4 class="modal-title">Eliminacion decategoria '+ data.categoria +'</h4>';
        document.getElementById("modal-body").innerHTML += '<h1 class="modal-title">Esta seguro de que desea eliminar la categoria <b>'+ data.categoria +'</b> ??</h1>';
        document.getElementById("modal-footer").innerHTML += "<button type='button' class='btn btn-primary' onclick='deleteCategoria("+data.id+")'>Confirmar</button>";
        document.getElementById("modal-footer").innerHTML += "<button type='button' class='btn btn-danger' onclick='cerrarModal()'>Cerrar</button>";
    }

    function deleteCategoria(data) {
        let _url = `/eliminar_categoria/${data}`;
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: _url,
            type: 'DELETE',
            data: {
                _token: _token
            },
            success: function(response) {
                document.getElementById("modal-header").empty();
                document.getElementById("modal-body").innerHTML += "<h1 style='color:green;'>"+ response.message +"</h1>";
                document.getElementById("modal-footer").innerHTML += "<button type='button' class='btn btn-danger' onclick='cerrarModal()'>Cerrar</button>";
                window.location.reload();
            }
        });
    }

</script>
</html>