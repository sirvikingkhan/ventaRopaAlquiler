<?php

class CajasController{

    public $loRespuesta = [];

    static public function ctrVerificarEstadoCaja($idUsuario, $date){
        $cajas = CajasModel::mdlVerificarEstadoCaja($idUsuario, $date);
        return $cajas;
    }

    static public function ctrVercaja($idUsuario, $date){
        $cajas = CajasModel:: mdlVercaja($idUsuario, $date);
        return $cajas;
    }
   

    static public function ctrListarCajas($idAlmacen,$fechaDesde,$fechaHasta){
        $cajas = CajasModel::mdlListarCajas($idAlmacen,$fechaDesde,$fechaHasta);
        return $cajas;
    }

    static public function ctrAperturaCaja($monto_apertura, $idUsuario, $idAlmacen){

        $fechaActual = date('d-m-y');

        $cajaVerificar = CajasController::ctrVerificarEstadoCaja($idUsuario, $fechaActual);

        if($cajaVerificar["existe"] != 0){
            $loRespuesta["codigoError"] = 1;
            $loRespuesta["mensajeError"] = "¡Ya cuenta con una caja abierta!";
            $loRespuesta["mensajeModel"] = "";
            return $respuesta = $loRespuesta;
        }

        $respuesta = CajasModel::mdlAperturaCaja($monto_apertura, $idUsuario, $idAlmacen);
        
        $loRespuesta["codigoError"] = 0;
        $loRespuesta["mensajeError"] = "";
        $loRespuesta["mensajeModel"] = $respuesta;
        return $respuesta = $loRespuesta;
    }

    static public function ctrCierreCaja($idCaja,$monto_ingreso,$monto_egreso,$monto_cierre){
        $cajas = CajasModel::mdlCierreCaja($idCaja,$monto_ingreso,$monto_egreso,$monto_cierre);
        return $cajas;
    }

    static public function ctrTotalTodo($idCaja,$idUsuario,$fecha){
        $cajas = CajasModel::mdlTotalTodo($idCaja,$idUsuario,$fecha);
        return $cajas;
    }

    static public function ctrGuardarDetalle($tipo, $descripcion,$monto,$idUsuario){

        $fechaActual = date('d-m-y');

        $cajaVerificar = CajasController::ctrVerificarEstadoCaja($idUsuario, $fechaActual);

        if($cajaVerificar["existe"] == 0){
            $loRespuesta["codigoError"] = 1;
            $loRespuesta["mensajeError"] = "Debe aperturar la Caja, ingrese al menú Caja y realize la apertura";
            $loRespuesta["mensajeModel"] = "";
            return $respuesta = $loRespuesta;
        }

        $ObtenerCaja = CajasController::ctrVercaja($idUsuario, $fechaActual);

        if($ObtenerCaja["idCaja"] == 0){
            $loRespuesta["codigoError"] = 1;
            $loRespuesta["mensajeError"] = "Cominíquese con el área de informática para verificar este error de caja";
            $loRespuesta["mensajeModel"] = "";
            return $respuesta = $loRespuesta;
        }

        $respuesta = CajasModel::mdlGuardarDetalle($ObtenerCaja["idCaja"], $tipo, $descripcion,$monto,$idUsuario);
        
        $loRespuesta["codigoError"] = 0;
        $loRespuesta["mensajeError"] = "";
        $loRespuesta["mensajeModel"] = $respuesta;
        return $respuesta = $loRespuesta;

    }

    static public function ctrMostrarDetalleC($idCaja, $tipo,$fecha){
        $cajas = CajasModel::mdlMostrarDetalleC($idCaja, $tipo,$fecha);
        return $cajas;
    }
    
    static public function ctrMovimientoCaja($idAlmacen,$fechaDesde,$fechaHasta){
        $respuesta = CajasModel:: mdlMovimientoCaja($idAlmacen,$fechaDesde,$fechaHasta);
        return $respuesta;
    }
    
    static public function ctrMovimientoCajaDetalle($idAlmacen,$fechaDesde,$fechaHasta){
        $respuesta = CajasModel:: mdlReporteMostrarDetalleCaja($idAlmacen,$fechaDesde,$fechaHasta);
        return $respuesta;
    }
}