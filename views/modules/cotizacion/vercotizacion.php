<?php

$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(47, $idPerfil);


date_default_timezone_set("America/Lima");
?>
<?php if ($permisos["acronimo"] == "vercompra" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Administrar Cotizaciones</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo $url; ?>inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Administrar Cotizacion</li>
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
                            <a href="cotizacion" class="btn btn-inline btn-success">
                                Nueva Cotización
                            </a>
                            <br><br>
                            <div class="row">

                                <div class="col">
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">CRITERIOS DE BÚSQUEDA</h3>

                                            <div class="card-tools">
                                                <span class="btn btn-tool text-white" id="btnLimpiarBusqueda">
                                                    <i class="far fa-times-circle fs-4"></i>
                                                </span>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                            <!-- /.card-tools -->
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Desde:</label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" id="cotizacion_desde">
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                </div>
                                               
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Hasta:</label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" id="cotizacion_hasta">
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                </div>

                                                <div class="col-md-2">

                                                </div>

                                                <div class="col-md-2">

                                                </div>

                                                <div class="col-md-2">

                                                </div>

                                                <div class="col-md-2 d-inline-flex justify-content-end align-items-center">
                                                    <div class="form-group">
                                                        <button class="btn btn-danger" style="width:120px;" id="btnQFiltro">Quitar</button>
                                                        <button class="btn btn-primary" style="width:120px;" id="btnFiltrar">Buscar</button>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card card-primary -->
                                </div>
                                <!-- /.col -->

                            </div>

                            <table class="table table-bordered table-hover nowrap dt-responsive tablaVerCotizacion" cellspacing="0" width="100%">
                                <thead class="bg-success">


                                    <tr>
                                        <!-- cambiar aqui-->
                                        <th>#</th>
                                        <th>Comprobante</th>
                                        <th>Cliente</th>
                                        <th>Contacto</th>
                                        <th>Sede</th>
                                        <th>Total Cotizacion</th>
                                        <th>Estado</th>
                                        <th>Usuario</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                        <!-- <th class="all">Acciones </th>-->
                                    </tr>
                                </thead>
                                <tbody class="text-left">


                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

<?php else : ?>
  <?php   require_once "views/modules/404.php";?>
<?php endif ?>


<script src="<?php echo $url ?>views/js/vercotizacion.js"></script>