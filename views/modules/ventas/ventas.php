<?php

$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(49, $idPerfil);
$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();
date_default_timezone_set("America/Lima");
?>

<style>
    .transparentbar {
        background-repeat: no-repeat;
        cursor: pointer;
        outline: none;
        border: none;
        box-shadow: none;
        background-image: none;

        background-color: transparent;
        /* background: transparent;
  border-color: transparent; */

    }

    .transparentbar:focus {
        color: #fff;
        background-color: transparent !important;
        border-color: transparent !important;
        box-shadow: none !important;
    }

    .transparentbar:hover {
        color: #fff;
        background-color: transparent !important;
        border-color: transparent !important;
    }
</style>

<?php if ($permisos["acronimo"] == "nuevaventa" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Ventas</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo $url; ?>inicio">Inicio</a></li>
                            <li class="breadcrumb-item active">Ventas</li>
                            <input type="hidden" id="rutaOculta" value="<?php echo $url; ?>">
                            <input type="hidden" id="simbolom" value="<?php echo $configuracion[0]["simbolom"]; ?> ">
                            <input type="hidden" id="igvn" value="<?php echo $configuracion[0]["impuesto"]; ?> ">
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row mb-3">

                    <div class="col-md-12">
                        <?php
                        $exp = explode("/", $_GET["ruta"]);


                        ?>
                        <?php if ($_SESSION["controlt"] == 1) : ?>
                            <?php if (isset($exp[1])) : ?>

                                <?php

                                $item = "idAlmacen";
                                $valor = $exp[1];

                                $AlmacenP = ControllerAlmacen::ctrMostrarAlmacen($item, $valor);

                                ?>
                                <input type="hidden" id="idAlmacenV" value="<?php echo $exp[1]; ?>">
                                <input type="hidden" id="idUsuario" value="<?php echo $_SESSION["idUsuario"]; ?>">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title col-md-12">
                                           
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h2><i class="fas fa-store-alt"></i> Sucursal: <?php echo $AlmacenP["descripcion"]; ?></h2>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <button type="button" class="btn btn-inline btn-danger" onClick="history.back();">
                                                            REGRESAR
                                                        </button>
                                                    </div>
                                                </div>
                                           
                                        </h3>
                                    </div>

                                    <div class="card-body">
                                        <?php include("moduloventa.php") ?>

                                    </div>

                                </div>

                            <?php else : ?>

                                <?php

                                $item = null;
                                $valor = null;

                                $Almacen = ControllerAlmacen::ctrMostrarAlmacen($item, $valor);

                                ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Seleccione Sucursal</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <?php foreach ($Almacen as $key => $value) : ?>


                                                <div class="col-lg-3 col-6">
                                                    <!-- small card -->
                                                    <div class="small-box bg-success">
                                                        <div class="inner">
                                                            <h3><?php echo $value["descripcion"]; ?></h3>

                                                            <p><?php echo $value["ubicacion"]; ?></p>
                                                        </div>
                                                        <div class="icon">s
                                                            <i class="fas fa-map-marked-alt"></i>
                                                        </div>
                                                        <a href="ventas/<?php echo $value["idAlmacen"]; ?>" class="small-box-footer">
                                                            Ir a Ventas <i class="fas fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                </div>


                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                            <!-- modificar hasta aqui sobre super administrador-->
                        <?php else : ?>
                            <input type="hidden" id="idAlmacenV" value="<?php echo $_SESSION["idAlmacen"]; ?>">
                            <input type="hidden" id="idUsuario" value="<?php echo $_SESSION["idUsuario"]; ?>">

                            <div class="card card-primary card-outline">
                                <div class="card-body">
                                    <?php include("moduloventa.php") ?>
                                </div>
                            </div>

                        <?php endif ?>

                    </div>

                </div>

            </div>

        </section>

    </div>

<?php else : ?>
    <?php require_once "views/modules/404.php"; ?>
<?php endif ?>




<div class="modal fade" id="mdlGestionarCajaV" tabindex="-1" aria-labelledby="mdlGestionarCaja" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-success py-2">
                <h6 class="modal-title" id="titulo_modal_caja">Gestionar Caja</h6>
                <button data-dismiss="modal" aria-label="close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <input type="hidden" id="tipo">

                    <div class="col-12">
                        <div class="form-group mb-2">
                            <label class="" for="iptStockSumar">
                                <i class="fas fa-plus-circle fs-6"></i> <span class="small" id="titulo_modal_label">Importe:</span>
                            </label>
                            <input type="number" min="0" step="0.1" class="form-control form-control-sm" id="monto" placeholder="Ingrese el importe">
                        </div>
                    </div>

                    <div class="col-12" id="col_descripcion">
                        <div class="form-group mb-2">
                            <label class="" for="iptStockSumar">
                                <i class="fas fa-plus-circle fs-6"></i> <span class="small" id="titulo_modal_label">Descripción:</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" id="descripcion" placeholder="Ingrese la descripcion">
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger float-right m-1 "><i class="fas fa-times ml-1 "><b>&nbsp;Cerrar</b></i></button>
                <button class="btn bg-gradient-primary float-right m-1 btnGuardarCaja"><i class="fas fa-check"><b>&nbsp;Guardar Caja</b></i></button>

            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="modalClientes" tabindex="-1" role="dialog" data-keyboard="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <form id="formularioUsuarios" role="form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Clientes</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <!--=============================================
              =            CUERPO DEL MODAL        =
              =============================================-->

                    <div class="box-body">

                        <div class="form-group">

                            <div class="input-group">

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                    </div>

                                    <input type="hidden" class="idCliente" name="idCliente">

                                    <input type="number" class="form-control dni" name="dni" placeholder="DNI">

                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control nombres" name="nombres" placeholder="Nombres">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>

                                    <input type="text" class="form-control direccion" name="direccion" placeholder="Dirección">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                    </div>

                                    <input type="number" class="form-control telefono" name="telefono" placeholder="Telefono">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                    </div>

                                    <input type="number" class="form-control limite_credito" name="limite_credito" placeholder="Credito">
                                </div>


                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light guardarCli">Guardar</button>

                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal_pagar" tabindex="-1" role="dialog" data-keyboard="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <form id="formularioUsuarios" role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title"> <i class="fas fa-money-bill-wave"></i> Realizar Pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <!--=============================================
              =            CUERPO DEL MODAL        =
              =============================================-->

                    <div class="box-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" id="checkDescuento" type="checkbox">
                                        <label for="checkDescuento">Aplicar Descuento:</label>

                                    </div>
                                    <div class="input-group input-group-sm mb-3">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/. </span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm totalDescuento" value="0.00" name="totalDescuento" disabled>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="Vuelto">Descripción descuento:</label>
                                    <div class="input-group input-group-sm mb-3">

                                        <input type="text" class="form-control form-control-sm descDescuento" name="descDescuento" disabled>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="EfectivoEntregado">Total a Pagar:</label>
                                    <div class="input-group input-group-sm mb-3">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/. </span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm totalPagarModal" value="0.00" name="totalPagarModal" disabled>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="Vuelto">Vuelto:</label>
                                    <div class="input-group input-group-sm mb-3">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/. </span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm Vuelto" name="Vuelto" value="0.00" disabled>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-app bg-success agregarMetodoPago">
                                    <i class="fas fa-plus"></i> Agregar
                                </button>
                                <button type="button" class="btn btn-app bg-danger quitarMetodoPago">
                                    <i class="fa fa-times"></i> Quitar
                                </button>

                            </div>
                        </div>

                        <div class="cajaMetodoPago" style="margin-bottom: 18px;">
                            <div class="row" style="margin-bottom:-18px;">

                                <div class="col-sm-6" style="padding-right: 0px">
                                    <div class="input-group">

                                        <label class="col-form-label" for="selCategoriaReg">
                                            <span class="small">Metodo de Pago</span><span class="text-danger">*</span></label>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-money-bill"></i></span>
                                            </div>
                                            <select class="form-control  form-control-sm metodoPago" name="metodoPago" required>
                                                <option value="" selected="true">Seleccione Tipo Pago</option>
                                                <option value="Efectivo">Efectivo</option>
                                                <option value="Tarjeta">Tarjeta</option>
                                                <option value="Transferencia">Transferencia</option>
                                                <option value="Yape">Yape</option>
                                                <option value="Plin">Plin</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-3 ingresoPrecio">
                                    <label class="col-form-label" for="selCategoriaReg">
                                        <span class="small">Monto</span><span class="text-danger">*</span></label>

                                    <div class="input-group input-group-sm mb-3">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/. </span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm montoPagar" name="montoPagar" required>
                                    </div>

                                </div>

                                <div class="col-sm-3 ingresoCantidad">
                                    <label class="col-form-label" for="selCategoriaReg">
                                        <span class="small">Nro. Operación</span></label>

                                    <input type="number" class="form-control form-control-sm nroOperacion" name="nroOperacion" required>
                                </div>


                            </div>

                        </div>



                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light guardarPago">Realizar Venta</button>

                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="<?php echo $url ?>views/js/ventas.js"></script>