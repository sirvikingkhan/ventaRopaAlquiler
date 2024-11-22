<?php
session_start();
require_once "../controllers/cotizacion.controller.php";
require_once "../models/cotizacion.model.php";

class AjaxCotizacion{

    public $datos,$cNuDoci,$cNomCli,$cTelCli,$cDirCli,$idAlmacen,$idUsuario,$cTipDoc,$cNroDoc,$cSerie,$nSubTotal,$nIgv,$nTotal;

    public function ajaxObtenerNroBoleta(){
        $nroBoleta = CotizacionController::ctrObtenerNroBoleta();
        echo json_encode($nroBoleta,JSON_UNESCAPED_UNICODE);
    }

    public function ajaxListarproductosCotizacion(){
        $listadoProducto = CotizacionController::ctrListarproductosCotizacion();
        echo json_encode($listadoProducto,JSON_UNESCAPED_UNICODE);
    }

    public function ajaxRegistrarCotizacion($datos,$cNuDoci,$cNomCli,$cTelCli,$cDirCli,$cTipDoc,$cNroDoc,$cSerie,$nSubTotal,$nIgv,$nTotal){
        $registrarCotizacion = CotizacionController::ctrRegistrarCotizacion($datos,$cNuDoci,$cNomCli,$cTelCli,$cDirCli,$cTipDoc,$cNroDoc,$cSerie,$nSubTotal,$nIgv,$nTotal,$_SESSION["idUsuario"],$_SESSION["idAlmacen"]);
        echo json_encode($registrarCotizacion,JSON_UNESCAPED_UNICODE);
    }

}

if(isset($_POST["ajaxVerNroBoleta"])){
    $nroBoleta = new AjaxCotizacion();
    $nroBoleta -> ajaxObtenerNroBoleta();
}

if(isset($_POST["ajaxListarproductosCotizacion"])){
    $listadoProducto = new AjaxCotizacion();
    $listadoProducto -> ajaxListarproductosCotizacion();
}

if(isset($_POST["arr"])){
    $registrarCotizacion = new AjaxCotizacion();
    $registrarCotizacion -> ajaxRegistrarCotizacion($_POST["arr"],$_POST['cNuDoci'],
                                                    $_POST['cNomCli'],$_POST['cTelCli'],
                                                    $_POST['cDirCli'],
                                                    $_POST['cTipDoc'],$_POST['cNroDoc'],
                                                    $_POST['cSerie'],$_POST['nSubTotal'],
                                                    $_POST['nIgv'], $_POST['nTotal']);
 }