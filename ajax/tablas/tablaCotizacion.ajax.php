<?php

//vamos a requerir el controlador y el modelo
session_start();
require_once "../../controllers/cotizacion.controller.php";
require_once "../../models/cotizacion.model.php";

require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";
class TablaCotizacion
{

	public function mostrarTabla()
	{
		$idPerfil = $_SESSION["idPerfil"];
		$fechaDesde = $_GET["fechaDesde"];
		$fechaHasta = $_GET["fechaHasta"];
		$compras = CotizacionController::ctrMostrarCotizacion($fechaDesde,$fechaHasta);
		

		//$idCompra = $_GET["idCompra"];, get es para llamar a la tabla..
		//$compras = ComprasController::ctrMostrarCompra($idCompra);


		//Si la tabla viene vacia entonces retornamos los datos JSON con la structura vacia
		if (count($compras) == 0) {
			$datosJson = '[]';
			echo $datosJson;
			return;
		}

		$datosJson = '[';

		foreach ($compras as $key => $value) {

			
            $imprimir=  "<button class='btn btn-primary pdf' idCotizacion='".$value["idCotizacion"]."'><i class='fa fa-print'></i></button>";
            
            $acciones = "<div class='btn-group'>{$imprimir}</div>";


			if($value["cEstado"] == 0){	

                $estado = "<span class='badge bg-danger'>Anulado</span>";

            }else{
				$estado = "<span class='badge bg-green'>Aceptado</span>";

            }

			$datosJson .= '{
						"idCotizacion": "' . ($key + 1) . '",
						"comprobante": "' . $value["comprobante"] . '",
						"cliente": "' . $value["cliente"] . '",
						"cTelCli": "'.$value["cTelCli"].'",
                        "descripcion": "'.$value["descripcion"].'",
                        "totalCotizacion": "'.$value["totalCotizacion"].'",
						"estado": "'.$estado.'",
                        "usuario": "'.$value["usuario"].'",
                        "fecha_cotizacion": "'.$value["fecha_cotizacion"].'",
                        "acciones" : "'.$acciones.'"
			},';
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson .=  ']';

		// }';

		echo $datosJson;
	}
}

/*=============================================
Tabla Almacen
=============================================*/
//con esto ejecutamos el metodo.
$tabla = new TablaCotizacion();
$tabla->mostrarTabla();