<?php
session_start();
//vamos a requerir el controlador y el modelo

require_once "../../controllers/producto.controller.php";
require_once "../../models/producto.model.php";

require_once "../../controllers/categoria.controller.php";
require_once "../../models/categoria.model.php";

require_once "../../controllers/inventario.controller.php";
require_once "../../models/inventario.model.php";

require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";


require_once "../../controllers/configuracion.controller.php";
require_once "../../models/configuracion.model.php";

class TablaProducto
{

	/*=============================================
	Tabla Producto
	=============================================*/

	public function mostrarTabla()
	{
		$idPerfil = $_SESSION["idPerfil"];

		$orden = "idProducto";

        $request= $_REQUEST;

		$totalRenglones= ModelProducto::mdlMostrarNumRegistros($request); 
		//creamos el objeto personas que solicitara al controlador la información de la tabla personas
		//$Producto = ControllerProducto::ctrMostrarProducto(null, null,null);
		$permisosedit = ControllerPerfil::ctrMostrarMenuPermisos(31, $idPerfil); 
		$permisoseli = ControllerPerfil::ctrMostrarMenuPermisos(32, $idPerfil); 

		//Si la tabla viene vacia entonces retornamos los datos JSON con la structura vacia
		/*if (count($Producto) == 0) {

			$datosJson = '[]';

			// $datosJson = '{"data": []}';
			echo $datosJson;

			return;
		}*/

		if ($totalRenglones["totalRenglones"] == 0) {

            echo '{"data": []}';

            return;
        }

		$Producto = ModelProducto::mdlMostrarProductosServerSide("producto",null, $request, $orden);


		
		 $datosJson = '{
            "draw": '.intval($request["draw"]).',
				"recordsTotal":'.intval($totalRenglones["totalRenglones"]).',
				"recordsFiltered": '.intval($totalRenglones["totalRenglones"]).',
		  			"data": [';

		//$datosJson = '[';
		 
		
		for($i = 0; $i < count($Producto); $i++){
		//foreach ($Producto as $key => $value) {

			$categorias = ControllerCategorias::ctrMostrarCategorias("idCategoria", $Producto[$i]["idCategoria"]);
			$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();

			$itemInventario= "idProducto" ;
			
            $valorInventario = $Producto[$i]["idProducto"];
    
            $inventario = ControllerInventario::ctrMostrarInventario($itemInventario,$valorInventario);	
			

			if ($permisosedit["acronimo"] == "editproduc" && $permisosedit["estado"] == "on" && $permisosedit["existe"] == 1 && $permisoseli["acronimo"] == "elimproduc" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1){
				
				$acciones = "<div class='btn-group'><button class='btn btn-warning editarProducto' data-toggle='modal' data-target='#modalProducto' idProducto='".$Producto[$i]["idProducto"]."'><i class='fa fa-edit'></i></button><button class='btn btn-danger eliminarProducto'idProducto='".$Producto[$i]["idProducto"]."' idInventarioExis='".$inventario["idProducto"]."'><i class='fa fa-times'></i></button></div>";
			
			}else if ($permisosedit["acronimo"] == "editproduc" && $permisosedit["estado"] == "on" && $permisosedit["existe"] == 1){
				
				$acciones = "<div class='btn-group'><button class='btn btn-warning editarProducto' data-toggle='modal' data-target='#modalProducto' idProducto='".$Producto[$i]["idProducto"]."'><i class='fa fa-edit'></i></button><button class='btn btn-secondary'><i class='fas fa-ban'></i></button></div>";
			
			}else if ($permisoseli["acronimo"] == "elimproduc" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1){
			
				$acciones = "<div class='btn-group'><button class='btn btn-secondary'><i class='fas fa-ban'></i></button><button class='btn btn-danger eliminarProducto'idProducto='".$Producto[$i]["idProducto"]."' idInventarioExis='".$inventario["idProducto"]."'><i class='fa fa-times'></i></button></div>";
			
			}else{
			
				$acciones = "<div class='btn-group'><button class='btn btn-secondary'><i class='fas fa-ban'></i></button><button class='btn btn-secondary'><i class='fas fa-ban'></i></button></div>";
			
			}

			if($Producto[$i]["tipoProducto"]==0)
				$tipoProducto = "Consumo";
			else
				$tipoProducto = "Servicio";
			

			//$acciones = "<div class='btn-group'><button class='btn btn-warning editarProducto' data-toggle='modal' data-target='#modalProducto' idProducto='".$value["idProducto"]."'><i class='fa fa-edit'></i></button><button class='btn btn-danger eliminarProducto'idProducto='".$value["idProducto"]."' idInventarioExis='".$inventario["idProducto"]."'><i class='fa fa-times'></i></button>";

			$datosJson .= '[
						"' . ($i + 1) . '",
						 "' . $Producto[$i]["descProducto"] . '",
						 "' . $Producto[$i]["ubicacion"] . '",
						 "' . $Producto[$i]["codigoBarras"] . '",
						 "' . $categorias["desCat"] . '",
                         " '.$configuracion[0]["simbolom"].' ' . number_format($Producto[$i]["precioCompra"], 2, ',', '.'). '",
						 " '.$configuracion[0]["simbolom"].' ' . number_format($Producto[$i]["precioVenta"], 2, ',', '.') . '",
                         " '.$configuracion[0]["simbolom"].' ' . number_format($Producto[$i]["precioVentaMA"], 2, ',', '.') . '",
                        " '.$configuracion[0]["simbolom"].' ' . number_format($Producto[$i]["oferta"], 2, ',', '.') . '",
						"' . $tipoProducto . '",
						"' . $acciones . '"			
			],';
		}

		$datosJson = substr($datosJson, 0, -1);

        $datosJson .= ']
		 }';

        echo $datosJson;
	}
}

/*=============================================
Tabla Producto
=============================================*/
//con esto ejecutamos el metodo.
$tabla = new TablaProducto();
$tabla->mostrarTabla();