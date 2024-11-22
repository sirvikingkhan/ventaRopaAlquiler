
<div class="col-xl-6 col-12">
    <h3 class="card-title" style="font-weight: 700;">Fecha de Apertura : <span id="fechaCaja">02/02/2023</span> - <span class="badge bg-green" style="font-size:15px;">ABIERTA</span> - <span  id="nombreCajero">Juan Pedro Quispe Tunque</span>
    </h3><br><br>

    <div class="alert alert-secondary" style="padding: 10px 20px 10px 20px; margin:0 0 5px 0 ;">
        <div class="row">
            <div class="col-6">
                <h5 class="text-left" style="margin:0px;"> Monto Inicial</h5>
            </div>
            <div class="col-6">
                <h5 class="text-right" style="margin:0px;" id="montoInicial"> S/. 20.00</h5>
            </div>
        </div>
    </div>

    <div class="alert alert-primary" style="padding: 10px 20px 10px 20px; margin:0 0 5px 0 ;">
        <div class="row">
            <div class="col-6">
                <h5 class="text-left" style="margin:0px;"> Ingresos</h5>
            </div>
            <div class="col-6">
                <h5 class="text-right" style="margin:0px;" id="ingresoCaja"> S/. 20.00</h5>
            </div>
        </div>
    </div>

    <div class="alert alert-danger" style="padding: 10px 20px 10px 20px;  margin:0 0 5px 0 ;">
        <div class="row">
            <div class="col-6">
                <h5 class="text-left" style="margin:0px;"> Egresos</h5>
            </div>
            <div class="col-6">
                <h5 class="text-right" style="margin:0px;" id="egresoCaja"> S/. 20.00</h5>
            </div>
        </div>
    </div>

    <div class="alert alert-success" style="padding: 10px 20px 10px 20px;  margin:0 0 20px 0 ;">
        <div class="row">
            <div class="col-6">
                <h5 class="text-left" style="margin:0px;">Total Efectivo</h5>
            </div>
            <div class="col-6">
                <h5 class="text-right" style="margin:0px;" id="totalEfectivo"> S/. 20.00</h5>
            </div>
        </div>
    </div>

    <div class="alert" style="border:1px solid; box-shadow: 0px 0px 5px grey; border-color: rgba(60, 60, 60, 0.5); padding: 10px 20px 10px 20px;  margin:0 0 5px 0 ;">
        <div class="row">
            <div class="col-6">
                <h5 class="text-left" style="margin:0px;">Ingreso Tarjeta</h5>
            </div>
            <div class="col-6">
                <h5 class="text-right" style="margin:0px;" id="totalTarjeta"> S/. 20.00</h5>
            </div>
        </div>
    </div>

    <div class="alert" style="border:1px solid; box-shadow: 0px 0px 5px grey; border-color: rgba(60, 60, 60, 0.5); padding: 10px 20px 10px 20px;  margin:0 0 5px 0 ;">
        <div class="row">
            <div class="col-6">
                <h5 class="text-left" style="margin:0px;">Ingreso Transferencias</h5>
            </div>
            <div class="col-6">
                <h5 class="text-right" style="margin:0px;" id="totalTransferencias"> S/. 20.00</h5>
            </div>
        </div>
    </div>

    <div class="alert" style="border:1px solid; box-shadow: 0px 0px 5px grey; border-color: rgba(60, 60, 60, 0.5); padding: 10px 20px 10px 20px;  margin:0 0 5px 0 ;">
        <div class="row">
            <div class="col-6">
                <h5 class="text-left" style="margin:0px;">Ingreso Yape</h5>
            </div>
            <div class="col-6">
                <h5 class="text-right" style="margin:0px;" id="totalYape"> S/. 20.00</h5>
            </div>
        </div>
    </div>

    <div class="alert" style="border:1px solid; box-shadow: 0px 0px 5px grey; border-color: rgba(60, 60, 60, 0.5); padding: 10px 20px 10px 20px;  margin:0 0 5px 0 ;">
        <div class="row">
            <div class="col-6">
                <h5 class="text-left" style="margin:0px;">Ingreso Plin</h5>
            </div>
            <div class="col-6">
                <h5 class="text-right" style="margin:0px;" id="totalPlin"> S/. 20.00</h5>
            </div>
        </div>
    </div>

    <div class="alert" style="border:1px solid; box-shadow: 0px 0px 5px grey; border-color: rgba(60, 60, 60, 0.5); padding: 10px 20px 10px 20px;  margin:0 0 25px 0 ;">
        <div class="row">
            <div class="col-6">
                <h5 class="text-left" style="margin:0px;">Total No Efectivo</h5>
            </div>
            <div class="col-6">
                <h5 class="text-right" style="margin:0px;" id="totalNoEfectivoo"> S/. 20.00</h5>
            </div>
        </div>
    </div>

    <div class="alert" style="border:1px solid; box-shadow: 0px 0px 5px grey; border-color: rgba(60, 60, 60, 0.5); padding: 10px 20px 10px 20px;  margin:0 0 10px 0 ;">
        <div class="row">
            <div class="col-6">
                <h5 class="text-left" style="margin:0px;">Total Todo</h5>
            </div>
            <div class="col-6">
                <h5 class="text-right" style="margin:0px;" id="totalTodo"> S/. 20.00</h5>
            </div>
        </div>
    </div>


</div>

<div class="col-xl-6 col-12">
    <div class='btn-group'>
        <button class='btn btn-danger btnEgreso' data-toggle='modal' data-target='#mdlGestionarCaja' ><i class='fas fa-arrow-left'></i> Registrar Egreso</button>
    </div>
    <div class='btn-group'>
        <button class='btn btn-success btnIngreso' data-toggle='modal' data-target='#mdlGestionarCaja' ><i class='fas fa-arrow-right'></i> Registrar Ingreso</button>
    </div>
    <div class='btn-group'>
        <button class='btn btn-secondary btnCerrarCajaAr' ><i class='fas fa-door-closed'></i> Cerrar Caja</button>
    </div>
    <div class='btn-group'>
        <button class='btn btn-primary btnImprimirCaja' ><i class='fas fa-print'></i> Imprimir Caja</button>
    </div>


    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"></h3><br>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="chart-responsive">

                        <canvas id="pieChart" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>