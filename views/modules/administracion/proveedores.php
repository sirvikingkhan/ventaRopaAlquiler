<?php
$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(13, $idPerfil);

?>
<?php if ($permisos["acronimo"] == "verprov" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Proveedores</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>
                        <li class="breadcrumb-item active">Proveedores</li>
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
                            <?php $permisosagr = ControllerPerfil::ctrMostrarMenuPermisos(14, $idPerfil); ?>

                            <?php if ($permisosagr["acronimo"] == "agrprov" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>
                            <button type="button" class="btn btn-inline btn-primary" data-toggle="modal"
                                data-target="#modalProveedores">
                                AGREGAR
                            </button>
                            <?php else : ?>

                            <?php endif ?>


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover dt-responsive tablaProveedores">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>RUC</th>
                                        <th>Nombre</th>
                                        <th>Direccion</th>
                                        <th>Celular</th>
                                        <th>Telefono</th>
                                        <th>Email</th>
                                        <th>Acciones</th>
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
<?php require_once "views/modules/404.php"; ?>
<?php endif ?>

<div class="modal fade" id="modalProveedores" role="dialog">
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
                <form id="formularioProveedores" class="needs-validation" novalidate>
                    <!-- Abrimos una fila -->
                    <div class="row">
                        <!-- Columna para registro del codigo de barras -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">RUC</span><span class="text-danger">*</span>
                                </label>
                                <input type="hidden" id="idProveedor" name="idProveedor">
 
                                <input type="number" class="form-control form-control-sm" id="RUC" name="RUC" placeholder="RUC" required>
                                <div class="invalid-feedback">Ingresa su RUC</div>
                            </div>
                        </div>

                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Razon Social</span><span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" placeholder="Razon Social" required>
                                <div class="invalid-feedback">Ingresa Razón social</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Dirección</span><span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-sm" id="direccion" name="direccion" placeholder="Dirección" required>
                                <div class="invalid-feedback">Ingresa Dirección</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="codigoAlm"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Celular</span><span class="text-danger">*</span>
                                </label>

                                <input type="number" class="form-control form-control-sm" id="celular" name="celular" placeholder="Celular" required>
                                <div class="invalid-feedback">Ingresa Celular</div>
                            </div>
                        </div>

                        <!-- Columna para registro del codigo de barras -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Telefono</span><span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control form-control-sm" id="telefono" name="telefono" placeholder="Telefono" required>
                                <div class="invalid-feedback">Ingresa Telefono</div>
                            </div>
                        </div>

                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Email</span><span class="text-danger">*</span>
                                </label>
         
                                <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email" required>
                                <div class="invalid-feedback">Ingresa el correo o un formato correcto</div>
                            </div>
                        </div>

                        <!-- creacion de botones para cancelar y guardar el producto -->
                        <button type="button" class="btn btn-danger mt-3 mx-2 btnCancelarRegistro" style="width:170px;" data-dismiss="modal">Cancelar</button>
                        <button type="button" style="width:170px;" class="btn btn-primary mt-3 mx-2 guardarProveedores">Guardar Proveedor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $url ?>views/js/proveedores.js"></script>