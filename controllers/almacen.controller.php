<?php

class ControllerAlmacen{

	/*=============================================
	CREAR ALMACEN
	=============================================*/
	static public function ctrCrearAlmacen($datos){

		if (
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["descripcion"])
		) {
			$datos = array(
				"codigoAlm" => $datos["codigoAlm"],
				"descripcion" => $datos["descripcion"],
				"ubicacion" => $datos["ubicacion"],
				"ciudad" => $datos["ciudad"],
				"entrada" =>$datos["entrada"],
				"salida" =>$datos["salida"],
				"estado" => 1
			);
			$respuesta = ModelAlmacen::mdlRegistrarAlmacen($datos);
			return $respuesta;
		} else {
			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	/*=============================================
	MOSTRAR ALMACEN
	=============================================*/

	static public function ctrMostrarAlmacen($item, $valor){
		$respuesta = ModelAlmacen::mdlMostrarAlmacen($item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR ALMACEN
	=============================================*/

	static public function ctrEditarAlmacen($datos){

		if(
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["descripcion"])
		){
			$datos = array(
				"idAlmacen" => $datos["idAlmacen"],
				"codigoAlm" => $datos["codigoAlm"],
				"descripcion" => $datos["descripcion"],
				"ubicacion" => $datos["ubicacion"],
				"ciudad" => $datos["ciudad"],
				"entrada" =>$datos["entrada"],
				"salida" =>$datos["salida"]
			);

			$respuesta = ModelAlmacen::mdlEditarAlmacen($datos);
			return $respuesta;
		} else {
			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	/*=============================================
	BORRAR ALMACEN
	=============================================*/

	static public function ctrBorrarAlmacen($idAlmacen){
		$respuesta = ModelAlmacen::mdlBorrarAlmacen($idAlmacen);
		return $respuesta;
	}

}