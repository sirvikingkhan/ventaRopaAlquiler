<?php

require_once "../controllers/almacen.controller.php";
require_once "../models/almacen.model.php";

class AjaxAlmacen
{

    // /*=============================================
	// Editar almacen traer datos al modal
	// =============================================*/	

	public function ajaxMostrarAlmacen(){

		$respuesta = ControllerAlmacen::ctrMostrarAlmacen("idAlmacen", $_POST["idAlmacen"]);
		echo json_encode($respuesta);

	}

	public function ajaxMostrarAlmacenS(){

		$respuesta = ControllerAlmacen::ctrMostrarAlmacen(null,null);
		echo json_encode($respuesta);

	}
    

    public $idAlmacen;
	public $codigoAlm;
	public $ciudad;
    public $descripcion;
    public $ubicacion;
	public $entrada;
	public $salida;
	public $estado;
    
  /*=============================================
	Nuevo Almacen
	=============================================*/
    public function ajaxNuevoAlmacen()
    {
        $datos = array(
			"codigoAlm" => $this->codigoAlm,
            "descripcion" => $this->descripcion,
			"ubicacion" => $this->ubicacion,
			"ciudad" => $this->ciudad,
			"entrada" => $this->entrada,
			"salida" => $this->salida
        );
        $respuesta = ControllerAlmacen::ctrCrearAlmacen($datos);
        echo $respuesta;
    }


    /*=============================================
	Editar Almacen
	=============================================*/

    public function ajaxEditarAlmacen()
    {
        $datos = array(
            "idAlmacen" => $this->idAlmacen,
			"codigoAlm" => $this->codigoAlm,
            "descripcion" => $this->descripcion,
			"ubicacion" => $this->ubicacion,
			"ciudad" => $this->ciudad,
			"entrada" => $this->entrada,
			"salida" => $this->salida
        );

        $respuesta = ControllerAlmacen::ctrEditarAlmacen($datos);
        echo $respuesta;
    }
    /*=============================================
	Activar o desactivar Almacen
	=============================================*/
    


	public function ajaxActivarAlmacen(){

		$tabla = "almacen";

		$item2 = "estado";
		$valor2 = $this->estado;

		$item1 = "idAlmacen";
		$valor1 = $this->idAlmacen;

		$respuesta = ModelAlmacen::mdlActualizarAlmacen($tabla, $item1, $valor1, $item2, $valor2);

		echo $respuesta;

	}	

     /*=============================================
	Eliminar Almacen
	=============================================*/
	public $idEliminar;

	public function ajaxEliminarAlmacen(){
		$respuesta = ControllerAlmacen::ctrBorrarAlmacen($this->idEliminar);
		echo $respuesta;
	}



}

/*=============================================
Guardar y Editar Almacen
=============================================*/

if (isset($_POST["descripcion"])) {

    $tipoalmacen = new AjaxAlmacen();
	$tipoalmacen->codigoAlm = $_POST["codigoAlm"];
    $tipoalmacen->descripcion = $_POST["descripcion"];
	$tipoalmacen->ubicacion = $_POST["ubicacion"];
	$tipoalmacen->ciudad = $_POST["ciudad"];
	$tipoalmacen->entrada = $_POST["hora_entrada"];
	$tipoalmacen->salida = $_POST["hora_salida"];
   
    if($_POST["idAlmacen"] != ""){

    	$tipoalmacen -> idAlmacen = $_POST["idAlmacen"];
    	$tipoalmacen -> ajaxEditarAlmacen();
        
    }else{
    	$tipoalmacen -> ajaxNuevoAlmacen();
    }

}

/*=============================================
Ver Almacen
=============================================*/	

if(isset($_POST["ajaxAlmacen"])){
	$leerAlmacen = new AjaxAlmacen();
	$leerAlmacen -> ajaxMostrarAlmacen();
}

if(isset($_POST["ajaxAlmacenS"])){
	$leerAlmacen = new AjaxAlmacen();
	$leerAlmacen -> ajaxMostrarAlmacenS();
}


/*=============================================
Activar o desactivar Almacen
=============================================*/

if(isset($_POST["ajaxEstado"])){
	$activarAlmacen = new AjaxAlmacen();
	$activarAlmacen -> idAlmacen = $_POST["idAlmacen"];
	$activarAlmacen -> estado = $_POST["estado"];
	$activarAlmacen -> ajaxActivarAlmacen();
}

/*=============================================
Eliminar Almacen
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxAlmacen();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarAlmacen();

}