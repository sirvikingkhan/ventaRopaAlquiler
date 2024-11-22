<?php

class AlquilerController{
    public $loRespuesta = [];

    static public function ctrObtenerNroBoleta($Documento, $idAlmacen){
        $nroBoleta = VentasModel::mdlObtenerNroBoleta($Documento, $idAlmacen);
        return $nroBoleta;
    }


    static public function ctrRegistrarAlquiler($datos,
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
    $listaMetodoPagoVenta)
    { 
        
        try {
            $fechaActual = date('d-m-y');
        
            $cajaVerificar = CajasController::ctrVerificarEstadoCaja($cCodUsu, $fechaActual);
            if($cajaVerificar["existe"] == 0){
                $loRespuesta["codigoError"] = 1;
                $loRespuesta["mensajeError"] = "Debe aperturar la Caja, ingrese al menú Caja y realize la apertura";
                $loRespuesta["mensajeModel"] = "";
                return $respuesta = $loRespuesta;
            }

            $ObtenerCaja = CajasController::ctrVercaja($cCodUsu, $fechaActual);
            if($ObtenerCaja["idCaja"] == 0){
                $loRespuesta["codigoError"] = 1;
                $loRespuesta["mensajeError"] = "Cominíquese con el área de informática para verificar este error de caja";
                $loRespuesta["mensajeModel"] = "";
                return $respuesta = $loRespuesta;
            }

            $ObtenerComprobante = ModelComprobante::mdlObtenerNroBoletaAlquiler($idAlmacen);
            
            if ($ObtenerComprobante === false || $ObtenerComprobante["idDocalmacen"] == NULL) {
                $loRespuesta["codigoError"] = 1;
                $loRespuesta["mensajeError"] = "Cominíquese con el área de informática para verificar este error de comprobante";
                $loRespuesta["mensajeModel"] = "";
                return $respuesta = $loRespuesta;
            }

            $respuesta = AlquilerModel::mdlRegistrarAlquiler($idCliente, $idAlmacen, $ObtenerComprobante["idDocalmacen"], $ObtenerComprobante["Serie"], 
                                                                $ObtenerComprobante["nro_venta"], $cInstitucion, $cdirInstitucion, 
                                                                $tFecEnt, $tFecDev, $cContac, $cObsDet, $nTotal, $ObtenerCaja["idCaja"] , $cCodUsu);

            $listaMetodoPagoVentaArray = json_decode($listaMetodoPagoVenta, true);

            if($listaMetodoPagoVentaArray != NULL){
                foreach ($listaMetodoPagoVentaArray as $metodoPago) {
                    AlquilerModel::mdlRegistrarPagoAlquiler($respuesta, $metodoPago["metodoPago"], $metodoPago["monto"], $metodoPago["nroOperacion"],$ObtenerCaja["idCaja"]);
                }
            }

            ModelComprobante::mdlSumarComprobante($ObtenerComprobante["idDocalmacen"],$idAlmacen);

            $restanteMonto = 0;
            $restanteMonto = AlquilerController::obtenerRestanteMonto($respuesta);

            if($restanteMonto == 0){
                AlquilerModel::mdlEditarEstadoAlquiler($respuesta, "1", $cCodUsu);
            }

            if (count($datos) > 0 && $datos[0] !== "") {
                foreach ($datos as $dato) {
                    $listaProductos = explode(",", $dato);
                    AlquilerModel::mdlRegistrarAlquilerDetalle($listaProductos[0], $listaProductos[1], $listaProductos[2]);

                    ModelInventario::mdlSalidaProductoVenta($listaProductos[1], $idAlmacen, $listaProductos[0]);

                    $datoMayor = max($listaProductos[1], $listaProductos[4]);
                    $datoMenor = min($listaProductos[1], $listaProductos[4]);
                    $stockHay = abs($datoMayor - $datoMenor);

                    ControllerKardex::ctrIngresarKardex("Salida Alquiler",$listaProductos[1], $listaProductos[3], $idAlmacen, $cCodUsu, 
                                                        "Salida", "1", $listaProductos[4], $stockHay);
                }
            }

            $loRespuesta["codigoError"] = 0;
            $loRespuesta["mensajeError"] = ""; 
            $loRespuesta["mensajeModel"] = $respuesta;
            return $respuesta = $loRespuesta;
        } catch (PDOException $e) {

            $loRespuesta["codigoError"] = 1;
            $loRespuesta["mensajeError"] = "Error: Comuníquese con el área de informática.";
            $loRespuesta["mensajeModel"] = "Detalles del error: " . $e->getMessage();

            return $loRespuesta;
        }
    }

    static public function ctrListarAlquileres($idAlmacen,$fechaDesde, $fechaHasta){
        $respuesta = AlquilerModel::mdlListarAlquileres($idAlmacen,$fechaDesde,$fechaHasta);
        return $respuesta;
    }

    static public function ctrMostrarPagosAlquiler($idAlquiler){
        $respuesta = AlquilerModel::mdlMostrarPagosAlquiler($idAlquiler);
        return $respuesta;
    }

    static public function ctrMostrarDetalleAlquiler($idAlquiler){
        $respuesta = AlquilerModel::mdlMostrarDetalleAlquiler($idAlquiler);
        return $respuesta;
    }
    
    static public function ctrPagarAlquiler($idAlquiler, $listaMetodoPagoVenta, $cCodUsu){
        
        $fechaActual = date('d-m-y');
        
        $cajaVerificar = CajasController::ctrVerificarEstadoCaja($cCodUsu, $fechaActual);
        if($cajaVerificar["existe"] == 0){
            $loRespuesta["codigoError"] = 1;
            $loRespuesta["mensajeError"] = "Debe aperturar la Caja, ingrese al menú Caja y realize la apertura";
            $loRespuesta["mensajeModel"] = "";
            return $respuesta = $loRespuesta;
        }

        $ObtenerCaja = CajasController::ctrVercaja($cCodUsu, $fechaActual);
        if($ObtenerCaja["idCaja"] == 0){
            $loRespuesta["codigoError"] = 1;
            $loRespuesta["mensajeError"] = "Cominíquese con el área de informática para verificar este error de caja";
            $loRespuesta["mensajeModel"] = "";
            return $respuesta = $loRespuesta;
        }

        $restanteMonto = 0;
        $restanteMonto = AlquilerController::obtenerRestanteMonto($idAlquiler);

        if($restanteMonto <= 0){
            $loRespuesta["codigoError"] = 1;
            $loRespuesta["mensajeError"] = "El monto Restante es menor o igual a 0";
            $loRespuesta["mensajeModel"] = "";
            return $respuesta = $loRespuesta;
        }

        $listaMetodoPagoVentaArray = json_decode($listaMetodoPagoVenta, true);

        foreach ($listaMetodoPagoVentaArray as $metodoPago) {
            AlquilerModel::mdlRegistrarPagoAlquiler($idAlquiler, $metodoPago["metodoPago"], $metodoPago["monto"], $metodoPago["nroOperacion"], $ObtenerCaja["idCaja"]);
        }

        $restanteMontoD = 0;
        $restanteMontoD = AlquilerController::obtenerRestanteMonto($idAlquiler);

        if($restanteMontoD == 0){
            AlquilerModel::mdlEditarEstadoAlquiler($idAlquiler, "1", $cCodUsu);
        }

        $loRespuesta["codigoError"] = 0;
        $loRespuesta["mensajeError"] = ""; 
        $loRespuesta["mensajeModel"] = $idAlquiler;
        return $respuesta = $loRespuesta;
    
    }
 
    static public function obtenerRestanteMonto($idAlquiler) {

        $reparacionDatos = AlquilerModel::mdlMostrarAlquiler($idAlquiler);
        $pagos_reparacion = AlquilerController::ctrMostrarPagosAlquiler($idAlquiler);

        $pagadoMonto = 0;

        foreach ($pagos_reparacion as $key2 => $value2) {
            $pagadoMonto += $value2["monto_pago"];
        }

        $restanteMonto = $reparacionDatos["nTotal"] - $pagadoMonto;

        return $restanteMonto;
    }

    static public function ctrMostrarNotificacionAlquiler($idAlmacen){
        try {

			$respuesta = AlquilerModel::mdlMostrarNotificacionAlquiler($idAlmacen);
			$loRespuesta["pcCodError"] = "0";
            $loRespuesta["pcMsjError"] = "";
			$loRespuesta["pcRspModel"] = $respuesta;
            return $loRespuesta;

		} catch (Exception $e) {

			$loRespuesta["pcCodError"] = "1";
            $loRespuesta["pcMsjError"] = "Error: Comuníquese con el área de informática.";
			$loRespuesta["pcRspModel"] = "Detalles del error: " . $e->getMessage();
			return $loRespuesta;
		}	
    }

    static public function ctrEditarEstadoAlquiler($idAlquiler, $cCodUsu){
        
        $restanteMontoD = 0;
        $restanteMontoD = AlquilerController::obtenerRestanteMonto($idAlquiler);

        if($restanteMontoD == 0){
            $respuesta = AlquilerModel::mdlEditarEstadoAlquiler($idAlquiler, "2", $cCodUsu);

            AlquilerController::ctrRegresarStockAlquiler($idAlquiler, $cCodUsu);
        }else{
            $loRespuesta["codigoError"] = 1;
            $loRespuesta["mensajeError"] = "Tiene una deuda por pagar!";
            $loRespuesta["mensajeModel"] = "";
            return $respuesta = $loRespuesta;
        }

        $loRespuesta["codigoError"] = 0;
        $loRespuesta["mensajeError"] = ""; 
        $loRespuesta["mensajeModel"] = $respuesta;
        return $respuesta = $loRespuesta;
    
    }

    static public function ctrAnularAlquiler($idAlquiler, $cCodUsu){
        
        $respuesta = AlquilerModel::mdlEditarEstadoAlquiler($idAlquiler, "3", $cCodUsu);

        AlquilerModel::mdlAnularPagosAlquiler($idAlquiler);
        AlquilerController::ctrRegresarStockAlquiler($idAlquiler, $cCodUsu);

        $loRespuesta["codigoError"] = 0;
        $loRespuesta["mensajeError"] = ""; 
        $loRespuesta["mensajeModel"] = $respuesta;
        return $respuesta = $loRespuesta;
    }

    static public function ctrRegresarStockAlquiler($idAlquiler, $cCodUsu){

        $respuestaDetalleAlquiler = AlquilerModel::mdlMostrarDetalleAlquiler($idAlquiler);
        foreach ($respuestaDetalleAlquiler as $dato) {
            
            ModelInventario::mdlEntradaProductoVenta($dato["cantidad"], $dato["idAlmacen"], $dato["codigo_producto"]);

            $datoMayor = max($dato["cantidad"], $dato["stock"]);
            $datoMenor = min($dato["cantidad"], $dato["stock"]);
            $stockHay = abs($datoMayor + $datoMenor);

            ControllerKardex::ctrIngresarKardex("Devolucion Alquiler",$dato["cantidad"], $dato["idProducto"], $dato["idAlmacen"], $cCodUsu, 
                                                "Entrada", "1", $dato["stock"], $stockHay);
        }

    }
}