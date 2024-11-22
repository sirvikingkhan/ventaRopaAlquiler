<?php

$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(46, $idPerfil);

?>
<?php if ($permisos["acronimo"] == "nuevacompra" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cotización</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $url; ?>inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Cotización</li>
              <input type="hidden" id="rutaOculta" value="<?php echo $url; ?>">
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
              <div class="card-body">

                <div class="content">
                  <div class="container-fluid">

                    <div class="row mb-3">

                      <div class="col-md-9">
                        <center>
                          <h2><strong> Registrar Cotización</strong> </h2>
                        </center>
                        <div class="row">

                          <div class="col-md-12 mb-3">

                            <div class="form-group mb-2">
                              <label class="col-form-label" for="iptCodigoCotizacion"><i class="fas fa-barcode fs-6"></i> <span class="small">Productos</span></label>

                              <input type="text" class="form-control form-control-sm" id="iptCodigoCotizacion" placeholder="Ingrese el código de barras o el nombre del producto">
                            </div>
                            <input type="hidden" id="idUsuario" value="<?php echo $_SESSION["idUsuario"]; ?>">
                            <input type="hidden" id="idAlmacenCotizacion" value="<?php echo $_SESSION["idAlmacen"]; ?>">

                          </div>

                          <div class="col-md-6 mb-3">
                            <h3><strong>Total Cotización: S./ <span id="totalCotizacion">0.00</span></strong></h3>
                          </div>
                          <div class="col-md-6 text-right">

                            <button class="btn btn-primary" id="btnIniciarCotizacion">
                              <i class="fas fa-shopping-cart"></i> Realizar Cotizacion
                            </button>
                            <button class="btn btn-danger" id="btnVaciarListado">
                              <i class="far fa-trash-alt"></i> Vaciar Listado
                            </button>
                          </div>
                          <hr>

                          <div class="col-md-12">

                            <div class="table-responsive">
                              <table id="lstProductosCotizacion" class="table table-bordered" cellspacing="0" width="100%">

                                <thead class="bg-info text-left fs-6">
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
                                <tbody>
                                </tbody>
                              </table>

                            </div>
                            <!-- / table -->
                          </div>
                          <!-- /.col -->


                        </div>


                      </div>

                      <div class="col-md-3 px-2">
                        <div class="card shadow">

                          <h5 class="card-header text-start bg-primary text-white text-center">Total Cotización: S./ <span id="totalCotizacionRegistrar">0.00</span>
                          </h5>

                          <div class="card-body">
                            <div class="form-group mb-2">
                              <label class="col-form-label" for="selCategoriaReg"><i class="fas fa-file-alt fs-6"></i>
                                <span class="small">Nro.</span><span class="text-danger">*</span></label>
                              <input type="text" name="nro_cotizacion" id="nro_cotizacion" class="form-control form-control-sm" placeholder="Numero Cotización" readonly>

                            </div>
                            <div class="form-group mb-2">
                              <div class="row">
                                <div class="col-md-8">
                                  <label class="col-form-label" for="selCategoriaReg"><i class="fas fa-id-card fs-6"></i>
                                    <span class="small">DNI/RUC</span><span class="text-danger">*</span></label>
                                </div>



                              </div>
                              <input type="number" name="iptEfectivo" id="cNuDoci" class="form-control form-control-sm" placeholder="DNI/RUC">

                            </div>
                            <div class="form-group mb-2">
                              <label class="col-form-label" for="selCategoriaReg"><i class="fas fa-signature fs-6"></i>
                                <span class="small">Nombres</span><span class="text-danger">*</span></label>
                              <input type="text" name="iptEfectivo" id="cNomCli" class="form-control form-control-sm" placeholder="Nombres">

                            </div>



                            <div class="form-group mb-2">
                              <label class="col-form-label" for="selCategoriaReg"><i class="fas fa-mobile-alt fs-6"></i>
                                <span class="small">Celular</span><span class="text-danger">*</span></label>
                              <input type="number" name="iptEfectivo" id="cTelCli" class="form-control form-control-sm" placeholder="Celular">

                            </div>
                            
                            <div class="form-group mb-2">
                              <label class="col-form-label" for="selCategoriaReg"><i class="fas fa-map-marker-alt fs-6"></i>
                                <span class="small">Dirección</span><span class="text-danger">*</span></label>
                              <input type="text" name="iptEfectivo" id="cDirCli" class="form-control form-control-sm" placeholder="Dirección">

                            </div>

                            <div class="cajasMetodoPago">

                            </div>



                            <div class="row">
                              <div class="col-md-7">
                                <span>SUBTOTAL</span>
                              </div>
                              <div class="col-md-5 text-right">
                                S./ <span class="" id="boleta_subtotal">0.00</span>
                              </div>

                              <div class="col-md-7">
                                <span>IGV (18%)</span>
                              </div>
                              <div class="col-md-5 text-right">
                                S./ <span class="" id="boleta_igv">0.00</span>
                              </div>

                              <div class="col-md-7">
                                <span>TOTAL</span>
                              </div>
                              <div class="col-md-5 text-right">
                                S./ <span class="" id="boleta_total">0.00</span>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                      <!-- /.col -->



                    </div>
                  </div>


                </div>





    </section>

  </div>

<?php else : ?>
  <?php require_once "views/modules/404.php"; ?>
<?php endif ?>



<div class="modal fade" id="modalCantidadCompra" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content bg-success">


      <div class="modal-header">
        <h4 class="modal-title">Cantidad Compra</h4>
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
              <dt class="col-sm-12">Codigo de Barras</dt>
              <div class="input-group mb-3">

                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                </div>
                <input type="hidden" id="idProductoc" name="idProductoc">

                <input type="text" id="codigoBarrasc" name="codigoBarras" class="form-control" placeholder="Codigo barras" readonly>

              </div>
              <dt class="col-sm-12">Descripción producto</dt>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fab fa-product-hunt"></i></span>
                </div>
                <input type="text" id="descProductoc" name="descProducto" class="form-control" placeholder="Descripcion" readonly>
              </div>
              <dt class="col-sm-12">Cantidad Compra</dt>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-copyright"></i></span>
                </div>

                <input type="number" id="cantidaCompra" name="cantidaCompra" class="form-control" min="0" step="any" placeholder="cantidad de compra">
              </div>




            </div>

          </div>



        </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-light btnEditCantidad2">Guardar</button>
      </div>


    </div>

    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



<script src="<?php echo $url ?>views/js/cotizacion.js"></script>