<?php
$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$empleado = ControllerEmpleado::ctrMostrarEmpleado("idEmpleado", $_SESSION["idEmpleado"]);

?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

            </div>
        </div>
    </div>


    <!-- Main content-->
    <div class="content pb-2">
        <div class="container-fluid">
            <div class="row p-0 m-0">
                <div class="col-md-12">
                    <div class="card card-gray">
                        <div class="card-header">
                            <h3 class="card-title">Arqueo de caja</h3>
                            <input type="hidden" id="simbolom" value="S/. ">
                            <input type="hidden" id="Getruta" value="<?php echo $ruta[0] ?>" />
                            <input type="hidden" id="idUsuario" value="<?php echo $_SESSION["idUsuario"]; ?>">
                            <input type="hidden" id="idAlmacen" value="<?php echo $_SESSION["idAlmacen"]; ?>">

                            <input type="hidden" id="nombreUsuario"
                                value="<?php echo $empleado["nombres"] . ' ' . $empleado["apellidos"]; ?>">
                            <input type="hidden" id="idCaja">

                        </div>
                        <div class=" card-body">
                            <div class="row" id="cajaCerrada">
                            <?php include "cajacerrada.php" ?>
                                <!--<div class='btn-group'>
                                    <button class='btn btn-success' data-toggle='modal' data-target='#modal_Apertura'><i class="fas fa-cash-register"></i> Abrir Caja</button>
                                </div>-->
                            </div>
                            <div class="row" id="cajaAbierta">
                            <?php include "cajaabierta.php" ?>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="mdlGestionarCaja" tabindex="-1" aria-labelledby="mdlGestionarCaja" aria-hidden="true">
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
                    <input type="hidden" id="idCajaM">
                    <div class="col-12">
                        <div class="form-group mb-2">
                            <label class="" for="iptStockSumar">
                                <i class="fas fa-plus-circle fs-6"></i> <span class="small"
                                    id="titulo_modal_label">Importe:</span>
                            </label>
                            <input type="number" min="0" step="0.1" class="form-control form-control-sm" id="monto"
                                placeholder="Ingrese el importe">
                        </div>
                    </div>

                    <div class="col-12" id="col_descripcion">
                        <div class="form-group mb-2">
                            <label class="" for="iptStockSumar">
                                <i class="fas fa-plus-circle fs-6"></i> <span class="small"
                                    id="titulo_modal_label">Descripción:</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" id="descripcion"
                                placeholder="Ingrese la descripcion">
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger float-right m-1 "><i
                        class="fas fa-times ml-1 "><b>&nbsp;Cerrar</b></i></button>
                <button class="btn bg-gradient-primary float-right m-1 btnGuardar "><i
                        class="fas fa-check"><b>&nbsp;Guardar Caja</b></i></button>

            </div>

        </div>
    </div>
</div>


<script>
  
</script>

<script src="<?php echo $url ?>views/js/arqueocaja.js"></script>