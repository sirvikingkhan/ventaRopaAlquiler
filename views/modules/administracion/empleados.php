<?php
$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(5, $idPerfil);

?>
<?php if ($permisos["acronimo"] == "verempleado" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Empleados</h1>
                </div>


                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Empleados</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-header">

                <?php $permisosagr = ControllerPerfil::ctrMostrarMenuPermisos(6, $idPerfil); ?>

                <?php if ($permisosagr["acronimo"] == "agrempleado" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>
                <button type="button" class="btn btn-inline btn-primary" data-toggle="modal"
                    data-target="#modalEmpleado">
                    AGREGAR
                </button>
                <?php else : ?>

                <?php endif ?>


                <input type="hidden" id="rutaOculta" value="<?php echo $url; ?>">
            </div>
            <div class="card-body pb-0">
                <div id="prueba" class="row">
                    <?php

            /*=============================================
			LLAMADO DE PAGINACIÓN
			=============================================*/

            if (isset($ruta[1]) && preg_match('/^[0-9]+$/', $ruta[1])) {

              $item = null;
              $valor = null;
              $ordenar = "idEmpleado";
              $base = ($ruta[1] - 1) * 6;
              $tope = 6;
            } else {
              $item = null;
              $valor = null;
              $ordenar = "idEmpleado";
              $ruta[1] = 1;
              $base = 0;
              $tope = 6;
            }

            $empleado = ControllerEmpleado::ctrMostrarEmpleados($ordenar, $item, $valor, $base, $tope);
            $listaEmpleado = ControllerEmpleado::ctrListarEmpleado($ordenar, $item, $valor);



            ?>

                    <?php foreach ($empleado as $key => $value) : ?>

                    <?php
              $itemusuario = "idEmpleado";
              $valorusuario = $value["idEmpleado"];

              $usuarios = ControllerUsuarios::ctrMostrarUsuario($itemusuario, $valorusuario);

              ?>
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header text-muted border-bottom-0">
                                Empleado
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="lead"><b> Nombres: <?php echo $value["nombres"]; ?></b></h2>
                                        <h2 class="lead"><b> Apellidos:<?php echo $value["apellidos"]; ?></b></h2>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-phone"></i></span> Celular:
                                                <?php echo $value["telefono"]; ?> </li>
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-building"></i></span> Direccion:
                                                <?php echo $value["direccion"]; ?></li>
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-phone"></i></span> DNI:
                                                <?php echo $value["dni"]; ?></li>
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-phone"></i></span>
                                                Email:<?php echo $value["correo"]; ?> </li>
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-phone"></i></span> Fecha Nacimiento:
                                                <?php echo $value["fecNacimiento"]; ?></li>


                                        </ul>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img src="<?php echo $url; ?><?php echo $value["foto"]; ?>" alt="user-avatar"
                                            class="img-circle img-fluid" width="150px">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <?php $permisosed = ControllerPerfil::ctrMostrarMenuPermisos(7, $idPerfil); ?>

                                    <?php if ($permisosed["acronimo"] == "editempleado" && $permisosed["estado"] == "on" && $permisosed["existe"] == 1) : ?>
                                    <button data-toggle="modal" data-target="#modalEditarEmpleado"
                                        class="btn btn-warning btn-sm editarEmpleado"
                                        id="<?php echo $value["idEmpleado"]; ?>">
                                        <i class="fas fa-edit"></i>&nbsp; Editar
                                    </button>
                                    <?php else : ?>

                                    <?php endif ?>

                                    <?php $permisoseli = ControllerPerfil::ctrMostrarMenuPermisos(8, $idPerfil); ?>
                                    <?php if ($permisoseli["acronimo"] == "elimempleado" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1) : ?>
                                    <?php if ($value["foto"] !=  "views/img/empleado/default/avatar4.png") : ?>

                                    <button class="btn btn-sm btn-danger eliminarEmpleado"
                                        idEliminar="<?php echo $value["idEmpleado"]; ?>"
                                        fotoEliminar="<?php echo $value["foto"]; ?>"
                                        idUsuarioEliminar="<?php echo $usuarios["idUsuario"]; ?>">
                                        <i class="fa fa-times"></i>&nbsp; Eliminar
                                    </button>

                                    <?php else : ?>

                                    <button class="btn btn-sm btn-danger eliminarEmpleado"
                                        idEliminar="<?php echo $value["idEmpleado"]; ?>" fotoEliminar=""
                                        idUsuarioEliminar="<?php echo $usuarios["idUsuario"]; ?>">
                                        <i class="fa fa-times"></i>&nbsp; Eliminar
                                    </button>

                                    <?php endif ?>
                                    <?php else : ?>

                                    <?php endif ?>



                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>




            <?php

        /*=============================================
			LLAMADO DE PAGINACIÓN
			=============================================*/
        if (count($listaEmpleado) != 0) {

          $pagEmpleado = ceil(count($listaEmpleado) / 6);

          if ($pagEmpleado > 4) {
          } else {

            echo '<div class="card-footer">
                <nav aria-label="Contacts Page Navigation">
                <ul class="pagination justify-content-center m-0">';

            for ($i = 1; $i <= $pagEmpleado; $i++) {

              echo '<li class="page-item' . $i . '"><a class="page-link" href="' . $url . $ruta[0] . '/' . $i . '">' . $i . '</a></li>';
            }

            echo '</ul>
              </nav>
              </div>';
          }
          //var_dump( $pagEmpleado );
        }

        ?>

            <!-- /.card-body -->
            <!--<div class="card-footer">
        <nav aria-label="Contacts Page Navigation">
          <ul class="pagination justify-content-center m-0">
            <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>-->
            <!--<li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
            <li class="page-item"><a class="page-link" href="#">20</a></li>
            <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>
          </ul>
        </nav>
      </div>
      /.card-footer -->
        </div>
        <!-- /.card -->

    </section>
</div>
<!-- Default box -->

<!-- ./w

rapper -->
<?php else : ?>
<?php   require_once "views/modules/404.php";?>
<?php endif ?>
<!-- Content Wrapper. Contains page content -->

<div class="modal fade" id="modalEmpleado" role="dialog">
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
                <form id="formularioEmpleado" class="needs-validation" novalidate>
                    <!-- Abrimos una fila -->
                    <div class="row">
                        <!-- Columna para registro del codigo de barras -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">DNI: </span><span class="text-danger">*</span>
                                </label>
                                <input type="number" name="dni" class="form-control form-control-sm dni" placeholder="DNI" required>
                                <div class="invalid-feedback">Ingresa tu dni</div>
                            </div>
                        </div>

                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Nombres: </span><span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-sm nombres" name="nombres" placeholder="Nombres" required>
                                <div class="invalid-feedback">Ingresa nombre</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Apellidos: </span><span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-sm apellidos" name="apellidos" placeholder="Apellidos" required>
                                <div class="invalid-feedback">Ingresa apellidos</div>
                            </div>
                        </div>

                        <!-- Columna para registro del codigo de barras telefono direccion correo-->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Telefono: </span><span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-sm telefono" name="telefono" placeholder="Telefono" required>
                                <div class="invalid-feedback">Ingresa telefono</div>
                            </div>
                        </div>

                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Dirección: </span><span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-sm direccion" name="direccion" placeholder="Dirección" required>
                                <div class="invalid-feedback">Ingresa dirección</div>
                            </div>
                        </div>

                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Email: </span><span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control form-control-sm correo" name="correo" placeholder="Email" required>
                                <div class="invalid-feedback">Ingrese el formato correcto</div>
                            </div>
                        </div>

                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Fecha de nacimiento: </span><span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control form-control-sm fecNacimiento" name="fecNacimiento" placeholder="Fecha Nacimiento" required>
                                <div class="invalid-feedback">Ingresa fecha nacimiento</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group md-2">
                                <h6 class="with-border"><small>SUBIR FOTO</small></h6>
                                <input type="file" class="foto">
                                <p class="help-block"><small>Peso máximo de la foto 200 MB</small></p>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group md-2">
                            <img src="<?php echo $url; ?>views/img/empleado/default/avatar4.png" class="img-thumbnail previsualizarFoto" width="100px">
                            </div>
                        </div>
                        <!-- creacion de botones para cancelar y guardar el producto -->
                        <button type="button" class="btn btn-danger mt-3 mx-2 btnCancelarRegistro" style="width:170px;" data-dismiss="modal">Cancelar</button>
                        <button type="button" style="width:170px;" class="btn btn-primary mt-3 mx-2 guardarEmpleado">Guardar Empleado</button>
                        <!-- <button class="btn btn-default btn-success" type="submit" name="submit" value="Submit">Save</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarEmpleado" role="dialog">
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
                <form id="formularioEEmpleado" class="needs-validation" novalidate>
                    <!-- Abrimos una fila -->
                    <div class="row">
                        <!-- Columna para registro del codigo de barras -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">DNI: </span><span class="text-danger">*</span>
                                </label>
                                <input type="number" name="dni" class="form-control form-control-sm dni" placeholder="DNI" required>
                                <div class="invalid-feedback">Ingresa tu dni</div>
                            </div>
                        </div>

                        <input type="hidden" class="idEmpleado">
                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Nombres: </span><span class="text-danger">*</span>
                                </label>

                                <input type="text" class="form-control form-control-sm nombres" name="nombres" placeholder="Nombres" required>
                                <div class="invalid-feedback">Ingresa nombre</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Apellidos: </span><span class="text-danger">*</span>
                                </label>

                                <input type="text" class="form-control form-control-sm apellidos" name="apellidos" placeholder="Apellidos" required>
                                <div class="invalid-feedback">Ingresa apellidos</div>
                            </div>
                        </div>

                        <!-- Columna para registro del codigo de barras telefono direccion correo-->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Telefono: </span><span class="text-danger">*</span>
                                </label>

                                <input type="text" class="form-control form-control-sm telefono" name="telefono" placeholder="Telefono" required>

                                <div class="invalid-feedback">Ingresa telefono</div>
                            </div>
                        </div>

                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Dirección: </span><span class="text-danger">*</span>
                                </label>

                                <input type="text" class="form-control form-control-sm direccion" name="direccion" placeholder="Dirección" required>
                                <div class="invalid-feedback">Ingresa dirección</div>
                            </div>
                        </div>

                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Email: </span><span class="text-danger">*</span>
                                </label>

                                <input type="email" class="form-control form-control-sm correo" name="correo" placeholder="Email" required>
                                <div class="invalid-feedback">Ingresel formato correcto</div>
                            </div>
                        </div>

                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Fecha de nacimiento: </span><span class="text-danger">*</span>
                                </label>

                                <input type="date" class="form-control form-control-sm fecNacimiento" name="fecNacimiento" placeholder="Fecha Nacimiento" required>
                                <div class="invalid-feedback">Ingresa fecha nacimiento</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group md-2">
                                <h6 class="with-border"><small>SUBIR FOTO</small></h6>
                                <input type="file" class="foto">
                                <input type="hidden" class="antiguaFoto">
                                <p class="help-block"><small>Peso máximo de la foto 200 MB</small></p>
                                
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group md-2">
                            <img src="<?php echo $url; ?>views/img/empleado/default/avatar4.png" class="img-thumbnail previsualizarFoto" width="100px">
                            </div>
                        </div>
                        <!-- creacion de botones para cancelar y guardar el producto -->
                        <button type="button" class="btn btn-danger mt-3 mx-2 btnCancelarRegistro" style="width:170px;" data-dismiss="modal">Cancelar</button>
                        <button type="button" style="width:170px;" class="btn btn-primary mt-3 mx-2 guardarEditEmpleado">Guardar Empleado</button>
                        <!-- <button class="btn btn-default btn-success" type="submit" name="submit" value="Submit">Save</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $url ?>views/js/empleado.js"></script>