<?php

require_once "../../controllers/ventas.controller.php";
require_once "../../models/ventas.model.php";


$reporte = new VentasController();
$reporte -> ctrDescargarReporte();