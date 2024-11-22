<?php

require_once "../controllers/inventario.controller.php";
require_once "../models/inventario.model.php";

require_once "../controllers/kardex.controller.php";
require_once "../models/kardex.model.php";

class AjaxInventario
{

    // /*=============================================
	// Editar Inventario traer datos al modal
	// =============================================*/	

	public function ajaxMostrarInventario(){

		$respuesta = ControllerInventario::ctrMostrarInventario("idInventario", $_POST["idInventario"]);
		echo json_encode($respuesta);

	}


    public function ajaxVerTraslado(){

		$respuesta = ControllerInventario::ctrTraslado("idAlmacen", $_POST["PRidAlmacen"], "idProducto" ,$_POST["PRidProducto"]);
		echo json_encode($respuesta);

	}
    
    public function ajaxTotalInventario(){
		$respuesta = ControllerInventario::ctrTotalInventario($this->idAlmacen);
		echo json_encode($respuesta);
	}
    

    public $idInventario;
	public $idProducto;
	public $idAlmacen;
    public $stock;
    public $stock_minimo;
    public $fecha_verificar;

	public $idUsuario;




    
  /*=============================================
	Nuevo Inventario
	=============================================*/
    public function ajaxNuevoInventario()
    {
        $datos = array(

			"idAlmacen" => $this->idAlmacen,
			"idProducto" => $this->idProducto,
            "stock" => $this->stock,
			"stock_minimo" => $this->stock_minimo,
            "fecha_verificar" => $this->fecha_verificar,
			"idUsuario" => $this->idUsuario,
          
        );
        $respuesta = ControllerInventario::ctrCrearInventario($datos);
        echo $respuesta;


	
    }


    /*=============================================
	Editar Inventario
	=============================================*/

    public function ajaxEditarInventario()
    {
        $datos = array(
            "idInventario" => $this->idInventario,
            "stock" => $this->stock,	
        );

        $respuesta = ControllerInventario::ctrEditarInventario($datos);
        echo $respuesta;
    }

    public function ajaxEditarFechaVerificar(){
        $respuesta = ControllerInventario::ctrEditarFechaVerificar($this->idInventario);
        echo $respuesta;
    }
    

	 /*=============================================
	Traslado Inventario
	=============================================*/

    public function ajaxTrasladoInventario()
    {
        $datos = array(
            "idAlmacen" => $this->idAlmacen,
			"idProducto" => $this->idProducto,
            "stock" => $this->stock,	
        );

        $respuesta = ControllerInventario::ctrTrasladoInventario($datos);
        echo $respuesta;
    }
	public function ajaxTrasladoRecibe()
    {
        $datos = array(
            "idAlmacen" => $this->idAlmacen,
			"idProducto" => $this->idProducto,
            "stock" => $this->stock,	
        );

        $respuesta = ControllerInventario::ctrTrasladoInventario($datos);
        echo $respuesta;
    }
   
   
     /*=============================================
	Eliminar Inventario
	=============================================*/
	public $idEliminar;

	public function ajaxEliminarInventario(){
		$respuesta = ControllerInventario::ctrBorrarInventario($this->idEliminar);
		echo $respuesta;
	}



}

/*=============================================
Guardar y Editar Producto
=============================================*/

if (isset($_POST["stock_minimo"])) {

    $tipoInventario = new AjaxInventario();
	$tipoInventario->idAlmacen = $_POST["idAlmacen"];
	$tipoInventario->idProducto = $_POST["idProducto"];
    $tipoInventario->stock = $_POST["stock"];
	$tipoInventario->stock_minimo = $_POST["stock_minimo"];
    $tipoInventario->fecha_verificar = $_POST["fecha_verificar"];
	$tipoInventario->idUsuario = $_POST["idUsuario"];
   
    $tipoInventario -> ajaxNuevoInventario();
  
}

/*=============================================
Guardar y Editar Producto
=============================================*/

if (isset($_POST["editarstock"])) {

    $tipoInventario = new AjaxInventario();
	$tipoInventario->idInventario = $_POST["idInventario"];
    $tipoInventario->stock = $_POST["editarstock"];

   
    $tipoInventario -> ajaxEditarInventario();
  
}

/*=============================================
Traslado de Inventario
=============================================*/

if (isset($_POST["Tstocck"])) {

    $tipoInventario = new AjaxInventario();
	$tipoInventario->idAlmacen = $_POST["TidAlmacen"];
	$tipoInventario->idProducto = $_POST["TidProducto"];
    $tipoInventario->stock = $_POST["Tstocck"];

   
    $tipoInventario -> ajaxTrasladoInventario();
  
}

if (isset($_POST["Rstocck"])) {

    $tipoInventario = new AjaxInventario();
	$tipoInventario->idAlmacen = $_POST["RidAlmacen"];
	$tipoInventario->idProducto = $_POST["RidProducto"];
    $tipoInventario->stock = $_POST["Rstocck"];

   
    $tipoInventario -> ajaxTrasladoRecibe();
  
}



/*=============================================
Ver Producto
=============================================*/	

if(isset($_POST["ajaxInventario"])){
	$leerInventario = new AjaxInventario();
	$leerInventario -> ajaxMostrarInventario();
}


/*=============================================
Prueba
=============================================*/	

if(isset($_POST["ajaxTraslado"])){
	$leerInventario = new AjaxInventario();
	$leerInventario -> ajaxVerTraslado();
}

/*=============================================
Eliminar Producto
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxInventario();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarInventario();

}

if(isset($_POST["ajaxTotalInventario"])){

	$totali = new AjaxInventario();
	$totali -> idAlmacen = $_POST["idAlmacen"];
	$totali -> ajaxTotalInventario();

}

if(isset($_POST["ajaxEditarFechaVerificar"])){

	$editFechaVerificar = new AjaxInventario();
	$editFechaVerificar -> idInventario = $_POST["idInventario"];
	$editFechaVerificar -> ajaxEditarFechaVerificar();

}