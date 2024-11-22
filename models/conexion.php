<?php
  

class Conexion
{

	static public function conectar()
	{

		/* $link = new PDO(
			"mysql:host=localhost;dbname=zanahori_pos",
			"zanahori_administrador",
			"Leylamy07"
        );  */

		 $link = new PDO(
			"mysql:host=localhost;dbname=newventa",
			"root",
			""
        );  
		
        
		$link->exec("set names utf8"); 

		return $link;

	}


}