<?php
$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(29, $idPerfil);

?>
<?php if ($permisos["acronimo"] == "verproduc" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Producto</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>
                            <li class="breadcrumb-item active">Producto</li>
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
                                <?php $permisosagr = ControllerPerfil::ctrMostrarMenuPermisos(30, $idPerfil); ?>

                                <?php if ($permisosagr["acronimo"] == "agrproduc" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>
                                    <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#modalProducto">
                                        AGREGAR
                                    </button>
                                <?php else : ?>

                                <?php endif ?>

                                <a href="<?php echo $url ?>views/modules/descargar-reporte.php?reporte=reporte">
                                    <button class="btn btn-success" style="margin-top:0px">Descargar reporte en Excel</button>
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-hover dt-responsive tablaProducto">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descripcion</th>
                                            <th>Ubicacion</th>
                                            <th>Codigo Barras</th>
                                            <th>Categoria</th>
                                            <th>Precio compra</th>
                                            <th>Precio venta</th>
                                            <th>Mayoreo</th>
                                            <th>Oferta</th>
                                            <th>Tipo Producto</th>
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

<div class="modal fade" id="modalProducto" role="dialog">
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
                <form id="formularioProducto" class="needs-validation" novalidate>
                    <!-- Abrimos una fila -->
                    <div class="row">
                        <!-- Columna para registro del codigo de barras -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Código de Barras</span><span class="text-danger">*</span>
                                </label>
                                <input type="hidden" id="idProducto" name="idProducto">
                                <input type="number" class="form-control form-control-sm" id="codigoBarras" name="codigoBarras" placeholder="Código de Barras" required>
                                <div class="invalid-feedback">Ingresa su Código de barras</div>
                            </div>
                        </div>

                        <!-- Columna para registro de la categoría del producto -->
                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Descripción</span><span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-sm" id="descProducto" name="descProducto" placeholder="Descripción Producto" required>
                                <div class="invalid-feedback">Ingrese Descripción</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Categoria</span><span class="text-danger">*</span>
                                </label>
                                <select class="form-control form-control-sm" id="idCategoria" name="idCategoria" required>
                                    <!-- <select class="form-control select2" > -->
                                    <option value="">Seleccionar Categoria</option>
                                    <?php

                                    $item = null;
                                    $valor = null;

                                    $categoria = ControllerCategorias::ctrMostrarCategorias($item, $valor);

                                    foreach ($categoria as $key => $value) {

                                        if ($value["estadoCat"] == 1) {

                                            echo '<option value="' . $value["idCategoria"] . '">' . $value["desCat"] . '</option>';
                                        } else {
                                        }
                                    }

                                    ?>

                                </select>
                                <div class="invalid-feedback">Seleccione una Categoria</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Ubicación</span><span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-sm" id="ubicacion" name="ubicacion" placeholder="Ubicación Producto" required>
                                <div class="invalid-feedback">Ingrese una ubicación</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Precio de Compra</span><span class="text-danger">*</span>
                                </label>

                                <input type="number" min="0" step="any"  class="form-control form-control-sm" id="precioCompra" name="precioCompra" placeholder="Precio Compra" required>
                                <div class="invalid-feedback">Ingrese Precio de compra</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Precio de Venta</span><span class="text-danger">*</span>
                                </label>

                                <input type="number" min="0" step="any"  class="form-control form-control-sm" id="precioVenta" name="precioVenta" placeholder="Precio Venta" required>
                                <div class="invalid-feedback">Ingrese Precio de Venta</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Precio de Venta Mayoreo</span><span class="text-danger">*</span>
                                </label>

                                <input type="number" min="0" step="any"  class="form-control form-control-sm" id="precioVentaMA" name="precioVentaMA" placeholder="Precio Venta Mayoreo" required>
                                <div class="invalid-feedback">Ingrese Precio de Venta</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Precio de Venta Oferta</span><span class="text-danger">*</span>
                                </label>

                                <input type="number" min="0" step="any"  class="form-control form-control-sm" id="oferta" name="oferta" placeholder="Precio Venta Oferta" required>
                                <div class="invalid-feedback">Ingrese Precio de Venta</div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                           
                        </div>

                        <!-- creacion de botones para cancelar y guardar el producto -->
                        <button type="button" class="btn btn-danger mt-3 mx-2 btnCancelarRegistro" style="width:170px;" data-dismiss="modal">Cancelar</button>
                        <button type="button" style="width:170px;" class="btn btn-primary mt-3 mx-2 guardarProducto">Guardar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $url ?>views/js/producto.js"></script>