<?php
session_start();
require_once "../controllers/alquiler.controller.php";
require_once "../models/alquiler.model.php";
require_once "../controllers/caja.controller.php";
require_once "../models/caja.model.php";
require_once "../controllers/comprobante.controller.php";
require_once "../models/comprobante.model.php";
require_once "../models/inventario.model.php";
require_once "../controllers/kardex.controller.php";
require_once "../models/kardex.model.php";
class AjaxAlquiler
{

    public $idAlquiler;
    public $idAlmacen;
    public $idUsuario;
    public $idDocalmacen;
    public $serie;
    public $nro_comprobante;
    public $descripcion;
    public $subtotal;
    public $igv;
    public $total_venta;
    public $tipo_pago;
    public $codigo_transa;
    public $contacto, $Documento, $idVenta;
    public $fechaDesde, $fechaHasta;
    public $listaMetodoPagoVenta;
    public $idCaja;


    public function ajaxObtenerNroBoleta()
    {
        $nroBoleta = AlquilerController::ctrObtenerNroBoleta($this->Documento, $this->idAlmacen);
        echo json_encode($nroBoleta, JSON_UNESCAPED_UNICODE);
    }

    public function ajaxRegistroAlquiler(
        $datos,
        $idCliente,
        $idAlmacen,
        $cInstitucion,
        $cdirInstitucion,
        $tFecEnt,
        $tFecDev,
        $cContac,
        $cObsDet,
        $nTotal,
        $cCodUsu,
        $listaMetodoPagoVenta
    ) {

        $registroVenta = AlquilerController::ctrRegistrarAlquiler(
            $datos,
            $idCliente,
            $idAlmacen,
            $cInstitucion,
            $cdirInstitucion,
            $tFecEnt,
            $tFecDev,
            $cContac,
            $cObsDet,
            $nTotal,
            $cCodUsu,
            $listaMetodoPagoVenta
        );
        echo json_encode($registroVenta, JSON_UNESCAPED_UNICODE);
    }

    public function ajaxPagarAlquiler()
    {
        $registroVenta = AlquilerController::ctrPagarAlquiler($this->idAlquiler, $this->listaMetodoPagoVenta, $_SESSION["idUsuario"]);
        echo json_encode($registroVenta, JSON_UNESCAPED_UNICODE);
    }

    public function ajaxMostrarNotificacionAlquiler()
    {
        $respuesta = AlquilerController::ctrMostrarNotificacionAlquiler($this->idAlmacen);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    public function ajaxEditarEstadoAlquiler()
    {
        $respuesta = AlquilerController::ctrEditarEstadoAlquiler($this->idAlquiler, $_SESSION["idUsuario"]);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    public function ajaxAnularAlquiler()
    {
        $respuesta = AlquilerController::ctrAnularAlquiler($this->idAlquiler, $_SESSION["idUsuario"]);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }
    
}
if (isset($_POST["ajaxVerNroBoleta"])) {
    $nroBoleta = new AjaxAlquiler();
    $nroBoleta->Documento = $_POST["Documento"];
    $nroBoleta->idAlmacen = $_POST["idAlmacen"];
    $nroBoleta->ajaxObtenerNroBoleta();
}


if (isset($_POST["arr"])) {

    $registrar = new AjaxAlquiler();
    $registrar->ajaxRegistroAlquiler(
        $_POST["arr"],
        $_POST['idCliente'],
        $_POST['idAlmacen'],
        $_POST['cInstitucion'],
        $_POST['cdirInstitucion'],
        $_POST['tFecEnt'],
        $_POST['tFecDev'],
        $_POST['cContac'],
        $_POST['cObsDet'],
        $_POST['nTotal'],
        $_SESSION["idUsuario"],
        $_POST['listaMetodoPagoVenta']
    );
}

if (isset($_POST["ajaxPagarAlquiler"])) {
    $pagar = new AjaxAlquiler();
    $pagar->idAlquiler = $_POST["idAlquiler"];
    $pagar->listaMetodoPagoVenta = $_POST["listaMetodoPagoVenta"];
    $pagar->ajaxPagarAlquiler();
}

if (isset($_POST["ajaxMostrarNotificacionAlquiler"])) {
    $notificacion = new AjaxAlquiler();

    if ($_SESSION["controlt"] == 1) {
        $idAlmacenNotificacion = "";
    } else {
        $idAlmacenNotificacion = $_SESSION["idAlmacen"];
    }

    $notificacion->idAlmacen = $idAlmacenNotificacion;
    $notificacion->ajaxMostrarNotificacionAlquiler();
}
if (isset($_POST["ajaxEditarEstadoAlquiler"])) {
    $editarEstado = new AjaxAlquiler();
    $editarEstado->idAlquiler = $_POST["idAlquiler"];
    $editarEstado->ajaxEditarEstadoAlquiler();
}

if (isset($_POST["ajaxAnularAlquiler"])) {
    $editarEstado = new AjaxAlquiler();
    $editarEstado->idAlquiler = $_POST["idAlquiler"];
    $editarEstado->ajaxAnularAlquiler();
}

