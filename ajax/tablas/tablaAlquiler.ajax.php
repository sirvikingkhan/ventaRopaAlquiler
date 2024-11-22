<?php

//vamos a requerir el controlador y el modelo
session_start();
require_once "../../controllers/alquiler.controller.php";
require_once "../../models/alquiler.model.php";
require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";
require_once "../../controllers/configuracion.controller.php";
require_once "../../models/configuracion.model.php";

class tablaAlquiler
{

	public function mostrarTabla()
	{
		$idPerfil = $_SESSION["idPerfil"];
        $idAlmacen = $_GET["idAlmacen"];
		$fechaDesde = $_GET["fechaDesde"];
		$fechaHasta = $_GET["fechaHasta"];
		$reparacion = AlquilerController::ctrListarAlquileres($idAlmacen,$fechaDesde, $fechaHasta);
		//$ventaPermisoPermisos = ControllerPerfil::validarAccesoPagina($idPerfil, "ventas");

		if (count($reparacion) == 0) {
			$datosJson = '[]';
			echo $datosJson;
			return;
		}

		$datosJson = '[';

		foreach ($reparacion as $key => $value) {
			$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();

			$pagos_reparacion = AlquilerController::ctrMostrarPagosAlquiler($value["idAlquiler"]);
			
			$pagos = "";
			$pagadoMonto = 0;
			$restanteMonto = 0;
			foreach ($pagos_reparacion as $key2 => $value2) {
				$pagos .= "<li>" . $value2["metodo_pago"] . " " . $value2["monto_pago"]. "</li>";

				$pagadoMonto += $value2["monto_pago"];
				//sumar aqui todo lo que pago para tener el numero y podamos sacar el pagado y restante
			}
			if(count($pagos_reparacion) != 0){
				$pagos.= "=================";
			}

			$restanteMonto = $value["nTotal"] - $pagadoMonto;
			
			$pagos.= "<li>Pagado: ". number_format($pagadoMonto, 2, '.', ',') . "</li>";
			$pagos.= "<li>Restante: ". number_format($restanteMonto, 2, '.', ',') . "</li>";
			$pagos.= "<li>Total: ". $value["nTotal"] . "</li>";

			//FECHAS DE RECEPCEPCION Y ENTREGA
			$fechas = "";
			$fechas .= "<li>" . $value["fechas1"] . "</li>";
			$fechas .= "<li>" . $value["fechas2"] . "</li>";
			//FIN
			
			//INFORMACION DE CLLIENTE
			$cliente = "";
			$cliente .= "<li> " . $value["comprobante"] . "</li>";
			$cliente .= "<li> " . $value["nombres"] . "</li>";
			//FIN

			//INFORMACION DE RECEPCION
			$informacion = "";
			$informacion .= "<li> Institución: " . $value["cInstitucion"] . "</li>";
			$informacion .= "<li> Dirección: " . $value["cdirInstitucion"] . "</li>";
			//FIN


			//REPUESTO DETALLE
			$alquiler_detalle = AlquilerController::ctrMostrarDetalleAlquiler($value["idAlquiler"]);
			$detAlquiler = "";

			foreach ($alquiler_detalle as $key2 => $value_respuesto) {
				$detAlquiler .= "<li> Descripción: " . $value_respuesto["descProducto"] . "</li>";
				$detAlquiler .= "<li> Cantidad: " . $value_respuesto["cantidad"] . "</li>";

                if ($value_respuesto !== end($alquiler_detalle)) {
                    $detAlquiler .= "=================";
                }	
			}

			// " | " . $value_respuesto[""].

			if(count($alquiler_detalle) == 0){
				$detAlquiler .= "Sin repuestos";
			}

			//FIN
			if($value["cEstRep"] == 0){
				$estado = "<span class='badge bg-primary'>Entregado</span>";
			}else if($value["cEstRep"] == 1){
				$estado = "<span class='badge bg-success'>Pagado</span>";
			}else if($value["cEstRep"] == 2){
				$estado = "<span class='badge bg-success'>Devuelto</span>";
			}else if($value["cEstRep"] == 3){
				$estado = "<span class='badge bg-danger'>Anulado</span>";
			}else{
				$estado = "<span class='badge bg-secondary'>Sin estado</span>";
			}

			$verAlquiler = "<button class='dropdown-item pdfAlquiler' idAlquiler='".$value["idAlquiler"]."'>".
								"<i class='fas fa-file-pdf'></i>&nbsp;Ver Alquiler".
							"</button>";
			$pagar = "";

			if($restanteMonto > 0 ){
				$pagar = "<button class='dropdown-item pagarAlquiler' idAlquiler='".$value["idAlquiler"]."' nTotal= '".number_format($restanteMonto, 2, '.', ',')."' >".
							"<i class='fas fa-money-bill-wave'></i>&nbsp;Pagar".
						"</button>";
			}
			
			$entregarAlquiler = "";

			if($restanteMonto == 0){
				if($value["cEstRep"] != 2){
					$entregarAlquiler =  "<button class='dropdown-item entregarAlquiler' idAlquiler='".$value["idAlquiler"]."' cEstRep= '".$value["cEstRep"]."'>".
												"<i class='fa fa-check'></i>&nbsp;Devolucion".
											"</button>";
				}
				
			}

			$anularAlquiler = "";
			
			if($value["cEstRep"] != 2){
				$anularAlquiler =  "<button class='dropdown-item anularAlquiler'  idAlquiler='".$value["idAlquiler"]."' >".
										"<i class='fas fa-ban'></i>&nbsp;Anular".
									"</button>";
			}

			$AnuladoVista = "";
			if($value["cEstRep"] == 3){
				$AnuladoVista = "<div class='dropdown-menu'>{$verAlquiler}";

			}else{
				$AnuladoVista = "<div class='dropdown-menu'>{$pagar}{$verAlquiler}{$entregarAlquiler}{$anularAlquiler}";

			}

			$acciones = "<div class='btn-group' style='text-align: center;'>".
						"<button style='font-size:13px;' type='button' class='btn btn-success btn-sm dropdown-toggle dropdown-icon' data-toggle='dropdown'>".
							"<i class='fas fa-cog'></i>".
						"</button>{$AnuladoVista}".
						"</div>".
						"</div>";

			$datosJson .= '{
						"acciones" : "'.$acciones.'",
						"estado": "'.$estado.'",
						"nombres": "' . $cliente . '",
						"cNomMot": "' . $informacion . '",
						"detAlquiler": "'.$detAlquiler.'",
						"pagos": "'.$pagos.'",
                        "fechas": "'.$fechas.'"
			},';
		}

		$datosJson = substr($datosJson, 0, -1);
		$datosJson .=  ']';
		echo $datosJson;
		//"empleado": "'.ucwords($value["empleado"]).'",

	}
}

$tabla = new tablaAlquiler();
$tabla->mostrarTabla();