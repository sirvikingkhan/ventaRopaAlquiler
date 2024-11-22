<?php
$url = Ruta::ctrRuta();
$idMenu = 1;
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(1, $idPerfil);


?>
<?php if ($permisos["acronimo"] == "veralmacen" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Almacen</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>

                        <li class="breadcrumb-item active">Almacen</li>
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
                        <div class="card-header">

                            <?php $permisosagr = ControllerPerfil::ctrMostrarMenuPermisos(2, $idPerfil); ?>

                            <?php if ($permisosagr["acronimo"] == "agralmacen" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>
                            <button type="button" class="btn btn-inline btn-primary" data-toggle="modal"
                                data-target="#modalAlmacen">
                                AGREGAR
                            </button>
                            <?php else : ?>

                            <?php endif ?>


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover tablaAlmacen">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Descripcion</th>
                                        <th>Ubicacion</th>
                                        <th>Ciudad</th>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                        <th>Estado</th>
                                        <th>Editar</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>


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
<?php   require_once "views/modules/404.php";?>
<?php endif ?>


<div class="modal fade" id="modalAlmacen" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- contenido del modal -->
        <div class="modal-content">
            <!-- cabecera del modal -->
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn btn-outline-primary text-white border-0 fs-5" data-dismiss="modal" id="btnCerrarModal">
                    <i class="far fa-times-circle"></i>
                </button>
            </div>
            <!-- cuerpo del modal -->
            <div class="modal-body">
                <form id="formularioAlmacen" class="needs-validation" novalidate>
                    <!-- Abrimos una fila -->
                    <div class="row">
                        <!-- Columna para registro del codigo de barras -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Descripción</span><span class="text-danger">*</span>
                                </label>
                                <input type="hidden" id="idAlmacen" name="idAlmacen">
                                <input type="text" class="form-control form-control-sm" id="descripcion" name="descripcion" placeholder="Descripción" required>
                                <div class="invalid-feedback">Ingresa descripción</div>
                            </div>
                        </div>

                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Ubicación</span><span class="text-danger">*</span>
                                </label>
                                <input type="hidden" class="idEmpleado">

                                <input type="text" class="form-control form-control-sm" id="ubicacion" name="ubicacion" placeholder="Ubicacion" required>
                                <div class="invalid-feedback">Ingresa ubicación</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Ciudad</span><span class="text-danger">*</span>
                                </label>
                                <input type="hidden" class="idEmpleado">

                                <input type="text" class="form-control form-control-sm" id="ciudad" name="ciudad" placeholder="Ubicacion" required>
                                <div class="invalid-feedback">Ingresa ciudad</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="codigoAlm"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Codigo de tienda</span><span class="text-danger">*</span>
                                </label>

                                <input type="text" class="form-control form-control-sm" id="codigoAlm" name="codigoAlm" placeholder="Codigo de tienda" required>
                                <div class="invalid-feedback">Ingresa codigo de tienda</div>
                            </div>
                        </div>

                        <!-- Columna para registro del codigo de barras -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Hora de entrada</span><span class="text-danger">*</span>
                                </label>

                                <input type="time" class="form-control form-control-sm" id="hora_entrada" name="hora_entrada" placeholder="Ingrese correo" required>

                                <div class="invalid-feedback">Ingresa entrada</div>
                            </div>
                        </div>

                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Hora de salida</span><span class="text-danger">*</span>
                                </label>

                                <input type="time" class="form-control form-control-sm" id="hora_salida" name="hora_salida" placeholder="Hora de salida" required>
                                <div class="invalid-feedback">Ingresa salida</div>
                            </div>
                        </div>

                        <!-- creacion de botones para cancelar y guardar el producto -->
                        <button type="button" class="btn btn-danger mt-3 mx-2 btnCancelarRegistro" style="width:170px;" data-dismiss="modal">Cancelar</button>
                        <button type="button" style="width:170px;" class="btn btn-primary mt-3 mx-2 guardarAlmacen">Guardar Sede</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $url ?>views/js/almacen.js"></script>