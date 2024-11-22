<?php

require_once "conexion.php";


class CotizacionModel{

      static public function mdlObtenerNroBoleta(){

        $stmt = Conexion::conectar()->prepare("SELECT idDocalmacen,Serie, IFNULL(LPAD(max(d.Cantidad)+1,8,'0'),'00000001') nro_venta from docalmacen d 
                                                WHERE d.idDocalmacen = 2");
        $stmt -> execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }


    /*=============================================
	MOSTRAR VENTAS PRODUCTOS
	=============================================*/
	static public function mdlListarproductosCotizacion(){

        $stmt = Conexion::conectar()->prepare("SELECT DISTINCT
                                                CONCAT(p.codigoBarras, ' - ', p.descProducto, ' - S./ ', p.precioVenta) AS descripcion_producto
                                                FROM
                                                    producto p
                                                INNER JOIN
                                                    inventario i ON p.idProducto = i.idProducto");
												
        $stmt -> execute();
        return $stmt->fetchAll();
    }
    
    static public function mdlRegistrarCotizacionCabecera($cNuDoci,$cNomCli,$cTelCli,$cDirCli,$cTipDoc,$cNroDoc,$cSerie,$nSubTotal,$nIgv,$nTotal,$idUsuario, $idAlmacen){

        $con = Conexion::conectar();
        $stmt =  $con ->prepare("INSERT INTO cotizacion(cNuDoci,cNomCli,cTelCli,cDirCli,idAlmacen,idUsuario,cTipDoc,cNroDoc,cSerie,nSubTotal,nIgv,nTotal,
                                                        cEstado,fecha_cotizacion) 
                                                VALUES(:cNuDoci,:cNomCli,:cTelCli,:cDirCli,:idAlmacen,:idUsuario,:cTipDoc,:cNroDoc,:cSerie,:nSubTotal,:nIgv,:nTotal,'1',
                                                (SELECT DATE_SUB(NOW(), INTERVAL 5 HOUR)))");

        $stmt -> bindParam(":cNuDoci", $cNuDoci , PDO::PARAM_STR);
        $stmt -> bindParam(":cNomCli", $cNomCli, PDO::PARAM_STR);
        $stmt -> bindParam(":cTelCli", $cTelCli, PDO::PARAM_STR);
        $stmt -> bindParam(":cDirCli", $cDirCli, PDO::PARAM_STR);
        $stmt -> bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
        $stmt -> bindParam(":idUsuario", $idUsuario, PDO::PARAM_STR);
        $stmt -> bindParam(":cTipDoc", $cTipDoc , PDO::PARAM_STR);
        $stmt -> bindParam(":cNroDoc", $cNroDoc, PDO::PARAM_STR);
        $stmt -> bindParam(":cSerie", $cSerie, PDO::PARAM_STR);
        $stmt -> bindParam(":nSubTotal", $nSubTotal, PDO::PARAM_STR);
        $stmt -> bindParam(":nIgv", $nIgv, PDO::PARAM_STR);
        $stmt -> bindParam(":nTotal", $nTotal , PDO::PARAM_STR);
       
        if($stmt -> execute()){
            $resultado = "Se registró la cotizacion correctamente.";
        }else{
            $resultado = "Error al registrar cotización";
        }

        $idd =  $con ->lastInsertId();
        return intval($idd);
    }

    static public function mdlRegistrarDetalleCotizacion($idProducto,$cantidad,$totalcoti){

        $con = Conexion::conectar();
        $stmt =  $con ->prepare("INSERT INTO detalle_cotizacion(idCotizacion,idProducto,cantidad,totalcoti,fecha_creacion) 
                                                VALUES((select IFNULL(max(c.idCotizacion),'1') idCotizacion from cotizacion c),:idProducto,:cantidad,:totalcoti,
                                                (SELECT DATE_SUB(NOW(), INTERVAL 5 HOUR)))");

        $stmt -> bindParam(":idProducto", $idProducto, PDO::PARAM_STR);
        $stmt -> bindParam(":cantidad", $cantidad, PDO::PARAM_STR);
        $stmt -> bindParam(":totalcoti", $totalcoti, PDO::PARAM_STR);
       
        if($stmt -> execute()){
            return "Se registró el detalle cotizacion correctamente.";
        }else{
            return "Error al registrar detalle cotización";
        }

    }

    static public function mdlActualizarDocumento($cTipDoc){

        $stmt = Conexion::conectar()->prepare("UPDATE docalmacen SET Cantidad = LPAD(Cantidad + 1,8,'0') WHERE idDocalmacen = :cTipDoc");

        $stmt -> bindParam(":cTipDoc", $cTipDoc , PDO::PARAM_STR);
       
        if($stmt -> execute()){
            return "Se actualizo el documento correctamente.";
        }else{
            return "Error al actualizar documento";
        }

    }

    static public function mdlMostrarCotizacion($fechaDesde,$fechaHasta){
        
		$stmt = null;
        $stmt = Conexion::conectar()->prepare("SELECT c.idCotizacion, CONCAT(c.cSerie, ' - ', LPAD(c.cNroDoc, 8, '0')) as comprobante, 
                                                CONCAT(c.cNuDoci, ' - ' , c.cNomCli) as cliente, c.cTelCli, a.descripcion, 
                                                CONCAT('S/. ', C.nTotal) as totalCotizacion, c.cEstado, 
                                                CONCAT(em.nombres , ' ' , em.apellidos) as usuario ,c.fecha_cotizacion
                                                FROM cotizacion c
                                                INNER JOIN almacen a ON a.idAlmacen = c.idAlmacen
                                                INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                                                INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado
                                                WHERE DATE(c.fecha_cotizacion) >= date(:fechaDesde) and DATE(c.fecha_cotizacion) <= date(:fechaHasta)");

        $stmt -> bindParam(":fechaDesde",$fechaDesde,PDO::PARAM_STR);
        $stmt -> bindParam(":fechaHasta",$fechaHasta,PDO::PARAM_STR);

        $stmt -> execute();
        return $stmt->fetchAll();
    }
  

}