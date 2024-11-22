<?php
$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();

?>
<div class="content-wrapper">

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
                            <h3 class="card-title">Reporte de Movimientos Caja</h3>
                            <input type="hidden" id="simbolom" value="<?php echo $configuracion[0]["simbolom"]; ?> ">
                        </div>
                        <div class=" card-body">

                            <div class="row">

                                <div class="col">
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                            <h3 class="card-title">Generación de Reporte por Sede y fecha</h3>

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
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Sede:</label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-user"></i></span>
                                                            </div>
                                                            <select name="" class="form-control form-control-sm" id="idAlmacenReporte">
                                                            </select>
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Desde:</label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="date" class="form-control form-control-sm" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" id="desde_reporte">
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Hasta:</label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="date" class="form-control form-control-sm" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" id="hasta_reporte">
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                </div>


                                                <div class="col-md-3 d-inline-flex justify-content-end align-items-center">
                                                    <div class="form-group">
                                                        <button class="btn btn-danger btn-sm" style="width:120px;" id="btnQFiltro">Quitar</button>
                                                        <button class="btn btn-primary btn-sm" style="width:120px;" id="btnFiltro">Buscar</button>
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

                            <hr>
                            <h3 class="text-center">Información</h3><br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="alert" style="border:1px solid; box-shadow: 0px 0px 5px grey; border-color: rgba(60, 60, 60, 0.5); padding: 10px 20px 10px 20px;  margin:0 0 5px 0 ;">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="text-left" style="margin:0px;">Ingreso y Egreso</h5>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="text-right" style="margin:0px;" id="rptingresoEgreso"> S/. 20.00</h5>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="col-md-4">
                                    <div class="alert" style="border:1px solid; box-shadow: 0px 0px 5px grey; border-color: rgba(60, 60, 60, 0.5); padding: 10px 20px 10px 20px;  margin:0 0 5px 0 ;">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="text-left" style="margin:0px;">Total Ingreso</h5>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="text-right" style="margin:0px;" id="rptIngreso"> S/. 20.00</h5>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>

                                <div class="col-md-4">
                                    <div class="alert" style="border:1px solid; box-shadow: 0px 0px 5px grey; border-color: rgba(60, 60, 60, 0.5); padding: 10px 20px 10px 20px;  margin:0 0 5px 0 ;">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="text-left" style="margin:0px;">Total Egreso</h5>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="text-right" style="margin:0px;" id="rptEgreso"> S/. 20.00</h5>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="lstReporteMov" class="table table-bordered" cellspacing="0" width="100%">
                                            <thead class="bg-secondary text-left fs-6">
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Usuario</th>
                                                    <th>Descripción</th>
                                                    <th>Tipo</th>
                                                    <th>Monto</th>
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


<script src="<?php echo $url ?>views/js/reportemov.js"></script>