<?php
session_start();
//vamos a requerir el controlador y el modelo


require_once "../../controllers/producto.controller.php";
require_once "../../models/producto.model.php";

class TablaProductoVerificar
{

    /*=============================================
	Tabla Personas
	=============================================*/

    public function mostrarTabla()
    {
        
        $idAlmacen = $_GET["idAlmacen"];
        $productoVerificar = ControllerProducto::ctrMostrarVerificarProdD($idAlmacen);
        if (count($productoVerificar) == 0) {
            $datosJson = '[]';
            echo $datosJson;  
            return;
        }

        
       $datosJson = '[';
      

        foreach ($productoVerificar as $key => $value) {


                $acciones = "<button type='button' idInventario  = '".$value["idInventario"]."' idUsuario = '".$_SESSION["idUsuario"]."' class='btn btn-success' id= 'editFechaVerificar'><i class='fa fa-check'></i></button>";
                

                $datosJson .= '{
                            "descProducto": "' . $value["descProducto"] . '",
                            "codigoBarras": "' . $value["codigoBarras"] . '",
                            "fecha_verificar": "'. $value["fecha_verificar"] .'",
                            "descAlmacen": "'. $value["descripcion"] .'",
                            "acciones" : "' . $acciones . '"
                        },';

            
        }

        $datosJson = substr($datosJson, 0, -1);
        $datosJson .=  ']';

        
        echo $datosJson;
        
    }
}

$tabla = new TablaProductoVerificar();
$tabla->mostrarTabla();