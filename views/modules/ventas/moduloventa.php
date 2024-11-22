<?php

$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();

?>

<div class="row">
    <div class="col-md-9 mb-3">
        <div class="col-md-12 mb-3">
            <center>
                <h2><strong> Registrar Venta</strong> </h2>
            </center>
            <div class="form-group mb-2">
                <label class="col-form-label" for="iptCodigoVenta"><i class="fas fa-barcode fs-6"></i>
                    <span class="small">Productos</span></label>

                <input type="text" class="form-control form-control-sm" id="iptCodigoVenta" placeholder="Ingrese el código de barras o el nombre del producto">
            </div>

        </div>

        <div class="row">
            <div class="col-md-6 mb-3">

                <h3><strong>Total Venta: <?php echo $configuracion[0]["simbolom"]; ?> <span id="totalVenta">0.00</span></strong></h3>
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-success" id="btnEntradaDinero" data-toggle='modal' data-target='#mdlGestionarCajaV'>
                    <i class="fas fa-coins"></i> Entrada
                </button>
                <button class="btn btn-warning" id="btnSalidadaDinero" data-toggle='modal' data-target='#mdlGestionarCajaV'>
                    <i class="fas fa-door-open"></i>Salida
                </button>
                <button class="btn btn-primary" id="btnIniciarPago">
                    <i class="fas fa-hand-holding-usd"></i> Realizar Pago
                </button>
                <button class="btn btn-danger" id="btnVaciarListado">
                    <i class="far fa-trash-alt"></i> Vaciar Listado
                </button>

            </div>
        </div>

        <div class="table-responsive">

            <table id="lstProductosVenta" class="table table-bordered" cellspacing="0" width="100%">
                <thead class="bg-secondary text-left fs-6">
                    <tr>
                        <th>Item</th>
                        <th>Codigo</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th class="text-center">Opciones</th>
                        <th>idProducto</th>
                        <th>stock</th>
                        <th>precioVentaMA</th>
                        <th>oferta</th>

                    </tr>
                </thead>
                <tbody class="text-left fs-6">
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow">

            <h5 class="card-header text-start bg-secondary text-white text-center">Total Venta:
                <?php echo $configuracion[0]["simbolom"]; ?> <span id="totalVentaRegistrar">0.00</span>
            </h5>

            <?php
            $item = "idEmpleado";
            $valor = $_SESSION["idEmpleado"];
            $Empleado = ControllerEmpleado::ctrMostrarEmpleado($item, $valor);
            ?>

            <div class="card-body">
                <div class="form-group mb-2">
                    <label class="col-form-label" for="selCategoriaReg"><i class="fas fa-user-tie fs-6"></i>
                        <span class="small">Vendedor</span><span class="text-danger">*</span></label>
                    <input type="text" name="iptVendedor" id="iptVendedor" class="form-control form-control-sm" value="<?php echo ucwords($Empleado["nombres"]) . ' ' . ucwords($Empleado["apellidos"]); ?>" disabled>
                </div>

                <div class="form-group mb-2">
                    <div class="row">
                        <div class="col-md-8">
                            <label class="col-form-label" for="selCliente"><i class="fas fa-user-secret fs-6"></i>
                                <span class="small">Cliente</span><span class="text-danger">*</span></label>
                        </div>


                        <div class="col-md-4">
                            <button type="button" class="btn  btn-success btn-sm" data-toggle="modal" data-target="#modalClientes">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-control form-control-sm select2" aria-label=".form-control-sm example" style="width:100%!important;" id="selCliente">
                            </select>
                            <span id="validate_categoria" class="text-danger small fst-italic" style="display:none">Debe
                                Seleccione documento</span>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label class="col-form-label" for="selCategoriaReg"><i class="fas fa-file-alt fs-6"></i>
                        <span class="small">Documento</span><span class="text-danger">*</span></label>
                    <select class="form-control form-control-sm" aria-label=".form-control-sm example" id="selDocumentoVenta">

                    </select>
                    <span id="validate_categoria" class="text-danger small fst-italic" style="display:none">Debe
                        Seleccione documento</span>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="iptNroSerie">Serie</label>
                            <input type="text" min="0" name="iptEfectivo" id="iptNroSerie" class="form-control form-control-sm" placeholder="nro Serie" disabled>
                        </div>
                        <div class="col-md-8">
                            <label for="iptNroVenta">Nro Venta</label>
                            <input type="text" min="0" name="iptEfectivo" id="iptNroVenta" class="form-control form-control-sm" placeholder="Nro Venta" disabled>
                        </div>
                    </div>


                </div>

                <input id="iptDelivery" type="hidden" value="0">
                <input id="iptDescuento" type="hidden" value="0">

                <div class="row">
                    <div class="col-md-7">
                        <strong>SUBTOTAL</strong>
                    </div>
                    <div class="col-md-5 text-right">
                        <strong> <?php echo $configuracion[0]["simbolom"]; ?> </strong><strong class="" id="boleta_subtotal">0.00</strong>

                        <input type="hidden" id="subtotal" value="">
                    </div>

                    <div class="col-md-7">
                        <strong>IGV (<?php echo (int)$configuracion[0]["impuesto"]; ?>%)</strong>
                    </div>
                    <div class="col-md-5 text-right">
                        <strong> <?php echo $configuracion[0]["simbolom"]; ?> </strong><strong class="" id="boleta_igv">0.00</strong>
                    </div>

                    <div class="col-md-7">
                        <strong>TOTAL A PAGAR</strong>
                    </div>
                    <div class="col-md-5 text-right">
                        <strong><?php echo $configuracion[0]["simbolom"]; ?></strong> <strong class="" id="boleta_total">0.00</strong>
                    </div>
                </div>


            </div>
        </div>

    </div>
</div>