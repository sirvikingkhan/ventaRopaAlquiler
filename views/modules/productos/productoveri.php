<?php
$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(73, $idPerfil);

?>
<?php if ($permisos["acronimo"] == "veriprod" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Productos Verificar Fecha Vencimiento</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>
                        <li class="breadcrumb-item active">Productos Verificar Fecha Vencimiento</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body">

                            <table id="tablaProductoVerificar" class="table table-bordered table-hover">
                                <thead>
                                    <tr>

                                        <th>Codigo Barras</th>
                                        <th>Descripcion</th>
                                        <th>Fecha Verificar</th>
                                        <th>Almacen</th>
                                        <th>Cambio Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php else : ?>
<?php require_once "views/modules/404.php"; ?>
<?php endif ?>

<!--<script src="<?php echo $url ?>views/js/dashboard.js"></script>-->
<script>
$("#tablaProductoVerificar tbody").on("click", "#editFechaVerificar", function() {
    var idInventario = $(this).attr("idInventario");
    var datos = new FormData();

    datos.append("ajaxEditarFechaVerificar", "ajaxEditarFechaVerificar");
    datos.append("idInventario", idInventario);

    $.ajax({
        url: rutaOculta + "ajax/inventario.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {

            if (respuesta == "ok") {

                Swal.fire({
                    title: "¡CORRECTO!",
                    html: "¡Fecha Modificada exitosamente!",
                    icon: "success",
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const b = Swal.getHtmlContainer().querySelector("b");
                        timerInterval = setInterval(() => {}, 75);
                        traerTablaProductoVerificar();
                        traerNotificacionfechaVerificar();
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    },
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log("se ha cerrado por el tiempo!");
                    }
                });

            } else {
                Swal.fire(
                    "ERROR!",
                    "¡No se pudo modificar la fecha, comuniquese con el area de informatica!",
                    "error"
                ).then(function(result) {
                    if (result.value) {}
                });
            }

        }

    })

})
</script>