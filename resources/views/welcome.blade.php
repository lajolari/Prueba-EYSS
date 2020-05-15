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
            <table id="categorias" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Categorias</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categorias as $categoria)
                    <tr id="row_{{$categoria->id}}">
                        <td>{{ $categoria->id  }}</td>
                        <td class="row">
                            <div class="col-md-3"> {{ $categoria->categoria }} </div>
                            <div class="col-md-3"> <a href="javascript:void(0)" data-id="{{ $categoria->id }}" onclick="editPost(event.target)" class="btn btn-info">Ver Productos</a> </div>
                            <div class="col-md-3"> <a href="javascript:void(0)" data-id="{{ $categoria->id }}" onclick="editPost(event.target)" class="btn btn-info">Editar</a> </div>
                            <div class="col-md-3"> <a href="javascript:void(0)" data-id="{{ $categoria->id }}" class="btn btn-danger" onclick="deletePost(event.target)">Eliminar</a> </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="categorias-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form name="userForm" class="form-horizontal">
                    <input type="hidden" name="catgoria_id" id="catgoria_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2">Producto</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Ingresar Nombre del Producto">
                            <span id="productoError" class="alert-message"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">Categoria</label>
                        <div class="col-sm-12">
                            <select name="categoria" id="categoria">
                                @foreach($categorias as $categoria)
                                    <option value=" {{ $categoria->id }} "> {{ $categoria->categoria }} </option>
                                @endforeach
                            </select>
                        </textarea>
                            <span id="categoriaError" class="alert-message"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="createProduct()">Guardar</button>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    $('#categorias').DataTable();

    function addProducto() {
        $('#categorias-modal').modal('show');
    }

    function editPost(event) {
        var id  = $(event).data("id");
        let _url = `/editar_producto/${id}`;
        $('#titleError').text('');
        $('#descriptionError').text('');

        $.ajax({
            url: _url,
            type: "GET",
            success: function(response) {
                if(response) {
                    $("#catgoria_id").val(response.id);
                    $("#title").val(response.title);
                    $("#producto").val(response.description);
                    $('#categorias-modal').modal('show');
                }
            }
        });
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
                    if(id != ""){
                        $("#row_"+id+" td:nth-child(2)").html(response.data.title);
                        $("#row_"+id+" td:nth-child(3)").html(response.data.description);
                    } else {
                        $('table tbody').prepend('<tr id="row_'+response.data.id+'"><td>'+response.data.id+'</td><td>'+response.data.title+'</td><td>'+response.data.description+'</td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editPost(event.target)" class="btn btn-info">Edit</a></td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" class="btn btn-danger" onclick="deletePost(event.target)">Delete</a></td></tr>');
                    }
                    $('#title').val('');

                    $('#categorias-modal').modal('hide');
                }
            },
            error: function(response) {
                $('#productoError').text(response.responseJSON.errors.title);
                $('#categoriaError').text(response.responseJSON.errors.description);
            }
        });
    }

    function deletePost(event) {
        var id  = $(event).data("id");
        let _url = `/posts/${id}`;
        let _token   = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: 'DELETE',
            data: {
                _token: _token
            },
            success: function(response) {
                $("#row_"+id).remove();
            }
        });
    }

</script>
</html>