<?php

class VentasController{
    public $loRespuesta = [];

    static public function ctrObtenerNroBoleta($Documento, $idAlmacen){
        
        $nroBoleta = VentasModel::mdlObtenerNroBoleta($Documento, $idAlmacen);

        return $nroBoleta;

    }

    static public function ctrMostrarDocumento($idAlmacen){
        
        $mostrarDocumento = VentasModel::mdlMostrarDocumento($idAlmacen);
        return $mostrarDocumento;

    }

    static public function ctrRegistrarVenta($datos,$idCliente,$idAlmacen,$idUsuario,$idDocalmacen,
                                            $serie,$nro_comprobante,$descripcion,$subtotal,
                                            $igv,$delivery,$descuento,$total_venta,$listaMetodoPagoVenta){

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

        $respuesta = VentasModel::mdlRegistrarVenta($datos,$idCliente,$idAlmacen,$idUsuario,$idDocalmacen,
                                                   $serie,$nro_comprobante,$descripcion,$subtotal,
                                                   $igv,$delivery,$descuento,$total_venta,$ObtenerCaja["idCaja"]);

        $listaMetodoPagoVentaArray = json_decode($listaMetodoPagoVenta, true);

        foreach ($listaMetodoPagoVentaArray as $metodoPago) {
   
            VentasModel::mdlRegistrarPagoVenta($respuesta, $metodoPago["metodoPago"], $metodoPago["monto"], $metodoPago["nroOperacion"]);

        }

        $loRespuesta["codigoError"] = 0;
        $loRespuesta["mensajeError"] = "";
        $loRespuesta["mensajeModel"] = $respuesta;
        return $respuesta = $loRespuesta;

    }

    static public function ctrListarVenta($idVenta){
        $mostrarVenta = VentasModel::mdlListarVenta($idVenta);
        return $mostrarVenta;
    }

    static public function ctrListarVentas($idAlmacen,$fechaDesde, $fechaHasta){

        $ventas = VentasModel::mdlListarVentas($idAlmacen,$fechaDesde,$fechaHasta);
        return $ventas;
    }

    static public function ctrMostrarDetalleVenta($idVenta){
        $mostrarDetalleVentas = VentasModel::mdlMostrarDetalleVenta($idVenta);
        return $mostrarDetalleVentas;
    }
    static public function ctrAnularVenta($idVenta){
        $respuesta = VentasModel:: mdlAnularVenta($idVenta);
        return $respuesta;
    }

   

    static public function ctrTotalVenta($idAlmacen,$fechaDesde,$fechaHasta){
        $respuesta = VentasModel:: mdlTotalVenta($idAlmacen,$fechaDesde,$fechaHasta);
        return $respuesta;
    }

     static public function ctrGraficoVenta($idAlmacen){
        $respuesta = VentasModel:: mdlGraficoVenta($idAlmacen);
        return $respuesta;
    }


	public function ctrDescargarReporte(){

		if(isset($_GET["reporte"])){

			$ventas = VentasModel::mdlExportExcel();

			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/
			$Name = 'reporteProducto.xls';
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");
		
			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>#</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>Descripción</td>
					<td style='font-weight:bold; border:1px solid #eee;'>Ubiación</td>
					<td style='font-weight:bold; border:1px solid #eee;'>Codigo Barras</td>
                    <td style='font-weight:bold; border:1px solid #eee;'>Categoria</td>
					<td style='font-weight:bold; border:1px solid #eee;'>Precio Compra</td>
					<td style='font-weight:bold; border:1px solid #eee;'>Precio Venta</td>
					<td style='font-weight:bold; border:1px solid #eee;'>Precio Mayoreo</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>Precio Oferta</td>		
					</tr>");

			foreach ($ventas as $row => $item){

			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["idProducto"]."</td> 
			 			<td style='border:1px solid #eee;'>".$item["descProducto"]."</td>
			 			<td style='border:1px solid #eee;'>".$item["ubicacion"]."</td>
                         <td style='border:1px solid #eee;'>".$item["codigoBarras"]."</td>
                         <td style='border:1px solid #eee;'>".$item["desCat"]."</td>
                         <td style='border:1px solid #eee;'>".$item["precioCompra"]."</td>
                         <td style='border:1px solid #eee;'>".$item["precioVenta"]."</td>
                         <td style='border:1px solid #eee;'>".$item["precioVentaMA"]."</td>
                         <td style='border:1px solid #eee;'>".$item["oferta"]."</td>");
			 	
		 	}
			echo "</table>";
        }
	
	}

    static public function ctrMostrarPagosVenta($idVenta){
        $respuesta = VentasModel::mdlMostrarPagosVenta($idVenta);
        return $respuesta;
    }

   

    

}