<div class="row" style="margin-left: 0px; margin-right: 0px;">
    <!-- Column -->
    <div class="col-lg-6 b-r">
        <div class="card-body">
            <div class="row text-center display-apertura m-t-40 m-b-40" >
                <div class="col-sm-8 offset-sm-2">
                    <h4 style="color: #d3d3d3;"><span style="font-size:4.5rem;" class="fas fa-lock m-t-40 m-b-10"></span>
                    </h4>
                    <span class="label label-danger label-close m-b-20">CERRADO</span><br>
                    
                    <h6>Ingrese los datos,<br>para abrir una caja</h6>
                </div>
            </div>

        </div>
    </div>
    <!-- Column -->
    <div class="col-lg-6 p-0">
        <div class="p-0">
            <form id="form-apertura" class="needs-validation" novalidate>
                <div class="card-body bg-white" style="border-radius: .25rem;">
                    <div class="row m-t-30">
                        <div class="col-sm-12 floating-labels">
                            <div class="form-group m-b-40">
                            <label for="id_caja">Cajero</label>
                                <input type="text" class="form-control form-control-lg"  id="monto_aper" value="<?php echo $empleado["nombres"] . ' ' . $empleado["apellidos"]; ?>" autocomplete="off" required="" readonly>

                                <span class="bar"></span>
                            </div>
                        </div>
                   
                        <div class="col-lg-12">
                            <div class="form-group m-b-20 dec">
                                <label class="font-13 text-inverse">INGRESE MONTO DE APERTURA</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white text-muted" style="display: grid;">
                                            <small class="text-left">EFE</small>
                                            <div class="text-left font-medium">S/. </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" style="height: 58px;border-left: 0px; border-right: 0px;" id="monto_apertura" value="0" autocomplete="off" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-white text-muted">Soles</span>
                                    </div>
                                    <div class="invalid-feedback">Debe ingresar un monto</div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <button type="button" class="btn btn-success btn-block guardarAbrirCaja">ABRIR CAJA</button>
                </div>
            </form>

        </div>
    </div>
</div>