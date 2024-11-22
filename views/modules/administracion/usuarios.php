<?php
$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(9, $idPerfil);

?>

<?php if ($permisos["acronimo"] == "verusuarios" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión de usuarios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>
                        <li class="breadcrumb-item active">Usuarios</li>
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
                            <?php $permisosagr = ControllerPerfil::ctrMostrarMenuPermisos(10, $idPerfil); ?>

                            <?php if ($permisosagr["acronimo"] == "agrusuarios" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>
                            <button type="button" class="btn btn-inline btn-primary" data-toggle="modal"
                                data-target="#modalUsuarios">
                                AGREGAR
                            </button>
                            <?php else : ?>

                            <?php endif ?>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table class="table table-bordered table-hover dt-responsive tablaUsuario" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Trabajador</th>
                                        <th>Sucursal</th>
                                        <th>Usuario</th>
                                        <th>Tipo de Usuario</th>
                                        <th>Ultimo Ingreso</th>
                                        <th>Acciones</th>
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

<div class="modal fade" id="modalUsuarios" role="dialog">
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
                <form id="formularioUsuarios" role="form" method="post" class="needs-validation" novalidate>
                    <!-- Abrimos una fila -->
                    <div class="row">
                        <!-- Columna para registro del codigo de barras -->
                        <div class="col-12 col-lg-6">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Empleado: </span><span class="text-danger">*</span>
                                </label>
                                <input type="hidden" id="idUsuario" name="idUsuario">
                                    <select class="form-control form-control-sm" id="idEmpleado" name="idEmpleado" required>
                                        <!-- <select class="form-control select2" > -->
                                        <option value="">Seleccionar Empleado</option>
                                        <?php

                                        $item = null;
                                        $valor = null;

                                        $empleado = ControllerEmpleado::ctrMostrarEmpleado($item, $valor);

                                        foreach ($empleado as $key => $value) {
                                            echo '<option value="' . $value["idEmpleado"] . '">' . $value["nombres"] . ' ' . $value["apellidos"] . '</option>';
                                        }

                                        ?>

                                    </select>
                                <div class="invalid-feedback">Seleccione un empleado para el usuario</div>
                            </div>
                        </div>

                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-6">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Sede: </span><span class="text-danger">*</span>
                                </label>
                                <select class="form-control form-control-sm" id="idAlmacen" name="idAlmacen" required>
                                        <!-- <select class="form-control select2" > -->
                                        <option value="">Seleccionar Sede</option>
                                        <?php

                                        $item = null;
                                        $valor = null;

                                        $almacen = ControllerAlmacen::ctrMostrarAlmacen($item, $valor);

                                        foreach ($almacen as $key => $value) {
                                            echo '<option value="' . $value["idAlmacen"] . '">' . $value["descripcion"] . '</option>';
                                        }

                                        ?>

                                    </select>
                                <div class="invalid-feedback">Seleccione una sede</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Usuario: </span><span class="text-danger">*</span>
                                </label>

                                <input type="text" class="form-control form-control-sm" id="login" name="login"
                                        placeholder="Usuario" required>
                                <div class="invalid-feedback">Ingresa usuario</div>
                            </div>
                        </div>


                        <!-- Columna para registro del codigo de barras -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Contraseña: </span><span class="text-danger">*</span>
                                </label>

                                <input type="hidden" id="passActual" name="passActual">
                                    <input type="password" class="form-control form-control-sm" id="passlogin" name="passlogin"
                                        placeholder="Contraseña">

                                <div class="invalid-feedback">Ingresa contraseña</div>
                            </div>
                        </div>

                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Cargo: </span><span class="text-danger">*</span>
                                </label>

                                <select class="form-control form-control-sm input-lg" id="idPerfil" name="idPerfil" required>

                                        <option value="">Selecionar cargo</option>
                                  
                                        <?php
                                        $item = null;
                                        $valor = null;
                                        $almacen = ControllerPerfil::ctrMostrarPerfil($item, $valor);

                                        foreach ($almacen as $key => $value) {
                                            if($value["estado"]==0){
                                                echo '<option value="' . $value["idPerfiles"] . '">' . $value["descripcion"] . '</option>';
                                            }else{
                                            }
                                        }
                                        ?>
                                    </select>
                                <div class="invalid-feedback">Seleccione su cargo</div>
                            </div>
                        </div>
                        <!-- creacion de botones para cancelar y guardar el producto -->
                        <button type="button" class="btn btn-danger mt-3 mx-2 btnCancelarRegistro" style="width:170px;" data-dismiss="modal">Cancelar</button>
                        <button type="button" style="width:170px;" class="btn btn-primary mt-3 mx-2 guardarUsuario">Guardar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $url ?>views/js/usuarios.js"></script>