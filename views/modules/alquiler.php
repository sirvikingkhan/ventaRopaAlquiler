<?php

$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();
?>
<div class="content-wrapper">
    <input type="hidden" id="simbolom" value="<?php echo $configuracion[0]["simbolom"]; ?> ">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content pb-2">
        <div class="container-fluid">

            <div class="row p-0 m-0">
                <div class="col-md-12">
                    <div class="card card-gray">
                        <div class="card-header">
                            <h3 class="card-title">Alquiler de Ropa</h3>

                        </div>
                        <div class=" card-body">

                            <ul class="nav nav-tabs" id="tabs-asignar-reparacion" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" id="content-reparacion-tab" data-toggle="tab" data-bs-target="#content-reparacion" href="#content-reparacion" role="tab" aria-controls="content-reparacion" aria-selected="false"><i class="fas fa-dollar-sign"></i> Alquiler</button>

                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" id="content-lista-reparacion-tab" data-bs-toggle="tab" data-bs-target="#content-lista-reparacion" type="button" role="tab" aria-controls="content-lista-reparacion" aria-selected="false"><i class="fas fa-list-ol"></i> Listado Alquiler</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="tabsContent-asignar-reparacion">

                                <div class="tab-pane fade active show mt-4 px-4" id="content-reparacion" role="tabpanel" aria-labelledby="content-reparacion-tab">
                                    <div class="row">

                                        <div class="col-xl-6 col-12">
                                            <div class="card card-gray">
                                                <div class="card-header">

                                                    <h3 class="card-title"><i class="fas fa-list"></i> Información del cliente</h3>

                                                </div>
                                                <div class=" card-body">
                                                    <form id="formularioReparacion" class="needs-validation" novalidate>

                                                        <!-- PARA BUSCAR EL CLIENTE -->
                                                        <div class="row">
                                                            <?php if ($_SESSION["controlt"] == 1) : ?>
                                                                <div class="col-md-4 col-10">
                                                                    <div class="form-group mb-2">
                                                                        <select class="form-control form-control-sm" name="idAlmacenAlquiler" id="idAlmacenAlquiler" required>
                                                                        </select>
                                                                        <div class="invalid-feedback">Debe seleccionar una sede</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-10">
                                                                <?php else : ?>
                                                                    <input type="text" name="" id="idAlmacenAlquiler" value="<?php echo $_SESSION["idAlmacen"]; ?>" hidden>
                                                                    <div class="col-md-8 col-10">
                                                                    <?php endif; ?>
                                                                    <div class="form-group mb-2">

                                                                        <input type="hidden" id="idUsuario" value="<?php echo $_SESSION["idUsuario"]; ?>">
                                                                        <input type="hidden" id="rutaOculta" value="<?php echo $url; ?>">
                                                                        <input type="hidden" id="Getruta" value="<?php echo $ruta[0] ?>" />
                                                                        <input type="hidden" id="idReparacion" value="">
                                                                        <select class="form-control form-control-sm select2" name="idCliente" id="idCliente" required>
                                                                        </select>
                                                                        <div class="invalid-feedback">Debe seleccionar un Cliente</div>
                                                                    </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-2">
                                                                        <div class="form-group mb-2">
                                                                            <!-- <label for="">&nbsp;&nbsp;</label><br> -->

                                                                            <button type="button" class="btn btn-danger btn-sm " id="ClienteCancelar"><i class="fas fa-trash"></i></button>
                                                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalClientes"><i class="fas fa-plus"></i></button>
                                                                            <!-- <button class="btn btn-info btn-sm float-right" id="abrirmodal_registrar_cliente"><i class="fas fa-plus"></i></button><br> -->
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
                                                                            <span class="small"> Documento</span>
                                                                            <input type="text" class=" form-control form-control-sm" id="dni" name="dni" placeholder="DNI" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
                                                                            <span class="small"> Nombre completos</span>
                                                                            <input type="text" class=" form-control form-control-sm" id="nombres" name="nombres" placeholder="Nombre cliente" disabled>
                                                                        </div>
                                                                    </div>
                                                                    

                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
                                                                            <span class="small"> Celular</span>
                                                                            <input type="text" class=" form-control form-control-sm" id="celular" name="celular" placeholder="Celular" disabled>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
                                                                            <span class="small"> Direccion</span>
                                                                            <input type="text" class=" form-control form-control-sm" id="direccion" name="direccion" placeholder="Direcciòn" disabled>
                                                                        </div>
                                                                    </div>

                                                                    
                                                                </div>

                                                                <br>
                                                                <hr>
                                                                <h5 style="text-align:center;">Informacion del alquiler</h5>
                                                                <br>

                                                                <div class="row">


                                                                  
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
                                                                            <label for="" class="">

                                                                                <span class="small">Inst. Educativa</span>
                                                                            </label>
                                                                            <input type="text" class=" form-control form-control-sm" id="cInstitucion" placeholder="" required>
                                                                            <div class="invalid-feedback">Designe la institución</div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
                                                                            <label for="" class="">

                                                                                <span class="small">Dirección Inst. Educativa</span>
                                                                            </label>
                                                                            <input type="text" class=" form-control form-control-sm" id="cdirInstitucion" placeholder="">

                                                                        </div>
                                                                    </div>

                                                                    
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
                                                                            <label for="" class="">
                                                                                <span class="small">Fecha Entrega</span>
                                                                            </label>
                                                                            <input type="date" class=" form-control form-control-sm" id="fecha_entrega" min="yyyy-MM-dd" required>

                                                                            <div class="invalid-feedback">Designe la fecha de entrega</div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
                                                                            <label for="" class="">

                                                                                <span class="small">Fecha Devolución</span>
                                                                            </label>
                                                                            <input type="date" class=" form-control form-control-sm" id="fecha_devolucion" min="yyyy-MM-dd" required>

                                                                            <div class="invalid-feedback">Designar fecha de devolución </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6 ">
                                                                        <div class="form-group mb-2">
                                                                            <label for="" class="">

                                                                                <span class="small">Costo Adicional</span>
                                                                            </label>
                                                                            <input type="number" class=" form-control form-control-sm" id="costoAdicional" placeholder="0">

                                                                            <div class="invalid-feedback">Designe un costo de reparación</div>
                                                                        </div>
                                                                    </div>



                                                                    <div class="col-md-6 ">
                                                                        <div class="form-group mb-2">
                                                                            <label for="" class="">

                                                                                <span class="small">Contacto Secundario</span>
                                                                            </label>
                                                                            <input type="number" class=" form-control form-control-sm" id="contactoSecundario" placeholder="Contacto">

                                                                        </div>
                                                                    </div>

                                                                   

                                                                    <div class="col-md-12">
                                                                        <div class="form-group mb-2">
                                                                            <label for="" class="">

                                                                                <span class="small">Detalle / Observaciones</span>
                                                                            </label>
                                                                            <textarea id="observaciones" class="form-control observaciones" name="observaciones" placeholder="Observaciones" rows="3" style="height: 70px;"></textarea>

                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">

                                                                    </div>


                                                                    <div class="col-md-12">
                                                                        <div class="form-group mb-2">
                                                                            <label for="">&nbsp;</label><br>
                                                                            <button type="button" class="btn btn-success btn-sm mt-3 mx-2 float-right" id="btnRegistrarAlquiler">Registrar</button>

                                                                            <button type="button" style="display:none;" class="btn btn-success btn-sm mt-3 mx-2 float-right" id="btnEditar">Editar</button>
                                                                            <button type="button" style="display:none;" class="btn btn-danger btn-sm mt-3 mx-2 float-left" id="btnCancelar">Cancelar</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-12">
                                                <div class="card">
                                                    <div class="content">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="card card-gray">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title"><i class="fas fa-list"></i> Listado de Ropa</h3>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="form-group mb-2">
                                                                                <div class="col-md-12 mb-3">
                                                                                    <h3><strong>Total a Pagar: <?php echo $configuracion[0]["simbolom"]; ?> <span id="totalVenta">0.00</span></strong></h3>
                                                                                    <div class="form-group mb-2">
                                                                                        <label class="col-form-label" for="iptCodigoRopaAlq"><i class="fas fa-barcode fs-6"></i>
                                                                                            <span class="small">Repuesto</span></label>
                                                                                        <input type="text" class="form-control form-control-sm" id="iptCodigoRopaAlq" placeholder="Ingrese el código de barras o descripción">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="table-responsive">
                                                                                    <table id="lstAlquiler" class="table table-bordered" cellspacing="0" width="100%">
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
                                                                                                <th>oferta</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody class="text-left fs-6">
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade  mt-4 px-4" id="content-lista-reparacion" role="tabpanel" aria-labelledby="content-lista-reparacion-tab">
                                        <div class="content">
                                            <div class="container-fluid">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card card-gray">
                                                            <div class="card-header">
                                                                <h3 class="card-title"><i class="fas fa-list"></i> Listado de alquiler</h3>
                                                            </div>
                                                            <div class="card-body">

                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="card card-secondary collapsed-card">
                                                                            <div class="card-header">
                                                                                <h3 class="card-title">CRITERIOS DE BÚSQUEDA</h3>
                                                                                <div class="card-tools">
                                                                                   
                                                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                                                        <i class="fas fa-plus"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-body" style="display: none;">
                                                                                <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label>Desde:</label>
                                                                                            <div class="input-group"> 
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                                                </div>
                                                                                                <input type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" id="filtro_desde">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label>Hasta:</label>
                                                                                            <div class="input-group">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                                                </div>
                                                                                                <input type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" id="filtro_hasta">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                    </div>
                                                                                    <div class="col-md-4 d-inline-flex justify-content-end align-items-center">
                                                                                        <div class="form-group">
                                                                                            <button class="btn btn-danger" style="width:120px;" id="btnQFiltroRep">Quitar</button>
                                                                                            <button class="btn btn-primary" style="width:120px;" id="btnFiltrarRep">Buscar</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group mb-2">
                                                                    <div class="table-responsive">
                                                                        <table class="table display nowrap table-striped shadow rounded tablaAlquilerDet" style="width:100%">
                                                                            <thead class="bg-gray text-left">
                                                                                <th></th>
                                                                                <th>Estado</th>
                                                                                <th>Cliente</th>
                                                                                <th>Información</th>
                                                                                <th>Prendas</th>
                                                                                <th>Montos</th>
                                                                                <th>Fechas</th>
                                                                            </thead>
                                                                            <tbody class="small text left">
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

                                <input type="hidden" class="form-control limite_credito" name="limite_credito" placeholder="Credito">



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
                    <button type="button" class="close btnCerrarModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <input type="hidden" id = "idAlquilerPagar" >


                    <!--=============================================
              =            CUERPO DEL MODAL        =
              =============================================-->

                    <div class="box-body">
                         <!--<div class="row">
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
                        </div>-->


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

                          <!--  <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="Vuelto">Vuelto:</label>
                                    <div class="input-group input-group-sm mb-3">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/. </span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm Vuelto" name="Vuelto" value="0.00" disabled>
                                    </div>

                                </div>
                            </div>-->
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
                    <button type="button" class="btn btn-outline-light btnCerrarModal" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light guardarPago">Realizar Alquiler</button>
                    <button type="button" class="btn btn-outline-light guardarPagoCre" >Realizar Pago</button>

                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalComprobante" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Utiliza la clase modal-lg-a4 para un modal más ancho -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">Comprobante</h5>
                <button type="button" class="close btnCerrarComprobante" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info text-center" role="alert">
                    Datos Alquiler
                </div>
                <iframe src="" style="width: 100%; height: 500px;"></iframe>
            </div>
            <div class="modal-footer justify-content-center"> <!-- Utiliza la clase justify-content-center para centrar los botones -->
                <button type="button" class="btn btn-info btncdr"><i class="fas fa-file-contract"></i> Descargar CDR</button>
                <button type="button" class="btn btn-primary btnxml"><i class="fas fa-file-code"></i> Descargar XML</button>
                <button type="button" class="btn btn-success btna4"><i class="fas fa-file-pdf"></i> Descargar PDF A4</button>
                <button type="button" class="btn btn-danger btnCerrarComprobante" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo $url ?>views/js/alquiler.js"></script>