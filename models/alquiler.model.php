<?php

require_once "conexion.php";

class AlquilerModel
{

    public $resultado;

    static public function mdlObtenerNroBoleta($Documento, $idAlmacen)
    {

        $stmt = Conexion::conectar()->prepare("SELECT idDocalmacen,Serie, IFNULL(LPAD(max(d.Cantidad)+1,8,'0'),'00000001') nro_venta from docalmacen d 
                                                WHERE d.idDocalmacen = :Documento AND d.idAlmacen = :idAlmacen");

        $stmt->bindParam(":Documento", $Documento, PDO::PARAM_STR);
        $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }


  

    static public function mdlRegistrarAlquiler($idCliente, $idAlmacen, $idDocAlm, $cSerie, $cNumCom, $cInstitucion, $cdirInstitucion, 
                                                $tFecEnt, $tFecDev, $cContac, $cObsDet, $nTotal, $idCaja, $cCodUsu)
    {
        $con = Conexion::conectar();
        $stmt =  $con->prepare("INSERT INTO alquiler(idCliente,idAlmacen,idDocAlm,cSerie,cNumCom,cInstitucion,cdirInstitucion,
                                                        tFecEnt,tFecDev,cContac, cObsDet, nTotal,cEstRep, cEstado, idCaja,
                                                        cCodUsu, tModifi) 
                                                VALUES(:idCliente,:idAlmacen,:idDocAlm,:cSerie,:cNumCom,:cInstitucion,:cdirInstitucion,:tFecEnt,
                                                        :tFecDev,:cContac, :cObsDet, :nTotal, 0, 0, :idCaja,
                                                        :cCodUsu, (DATE_SUB(now(), INTERVAL 0 HOUR)))");

        $stmt->bindParam(":idCliente", $idCliente, PDO::PARAM_STR);
        $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
        $stmt->bindParam(":idDocAlm", $idDocAlm, PDO::PARAM_STR);
        $stmt->bindParam(":cSerie", $cSerie, PDO::PARAM_STR);
        $stmt->bindParam(":cNumCom", $cNumCom, PDO::PARAM_STR);
        $stmt->bindParam(":cInstitucion", $cInstitucion, PDO::PARAM_STR);
        $stmt->bindParam(":cdirInstitucion", $cdirInstitucion, PDO::PARAM_STR);
        $stmt->bindParam(":tFecEnt", $tFecEnt, PDO::PARAM_STR);
        $stmt->bindParam(":tFecDev", $tFecDev, PDO::PARAM_STR);
        $stmt->bindParam(":cContac", $cContac, PDO::PARAM_STR);
        $stmt->bindParam(":cObsDet", $cObsDet, PDO::PARAM_STR);
        $stmt->bindParam(":nTotal", $nTotal, PDO::PARAM_STR);
        $stmt->bindParam(":idCaja", $idCaja, PDO::PARAM_STR);
        $stmt->bindParam(":cCodUsu", $cCodUsu, PDO::PARAM_STR);

        if($stmt -> execute()){
            $idd =  $con->lastInsertId();
            return intval($idd);
        }else{
            return "Error, no se registro la alquiler";
        }   
      
    }

    static public function mdlRegistrarAlquilerDetalle($codigo_producto, $cantidad, $total_pago)
    {
        $con = Conexion::conectar();
        $stmt =  $con->prepare("INSERT INTO alquiler_detalle(idAlquiler,codigo_producto, cantidad, total_pago, fecha_alquiler) 
        VALUES((select IFNULL(max(c.idAlquiler),'1') idAlquiler from alquiler c),:codigo_producto,:cantidad,:total_pago, (DATE_SUB(now(), INTERVAL 0 HOUR)))");

        $stmt->bindParam(":codigo_producto", $codigo_producto, PDO::PARAM_STR);
        $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_STR);
        $stmt->bindParam(":total_pago", $total_pago, PDO::PARAM_STR);

        if($stmt -> execute()){
            return "repuesto alquiler guardado";
        }else{
            return "Error, no se registro la alquiler";
        }   
    }

    static public function mdlRegistrarPagoAlquiler($idAlquiler, $metodo_pago, $monto_pago, $nro_opeacen, $idCaja)
    {

        $con = Conexion::conectar();
        $stmt =  $con->prepare("INSERT INTO pago_alquiler(idAlquiler,metodo_pago,monto_pago,nro_ope, idCaja,estado,fecha_pago) 
                                                VALUES(:idAlquiler, :metodo_pago, :monto_pago, :nro_ope, :idCaja, 0 , (DATE_SUB(now(), INTERVAL 0 HOUR)))");

        $stmt->bindParam(":idAlquiler", $idAlquiler, PDO::PARAM_STR);
        $stmt->bindParam(":metodo_pago", $metodo_pago, PDO::PARAM_STR);
        $stmt->bindParam(":monto_pago", $monto_pago, PDO::PARAM_STR);
        $stmt->bindParam(":nro_ope", $nro_opeacen, PDO::PARAM_STR);
        $stmt->bindParam(":idCaja", $idCaja, PDO::PARAM_STR);

   
        if($stmt -> execute()){
            return "Se registro el pago";
        }else{
            return "Error, no se registro el pago";
        }       
    }


    static public function mdlListarAlquileres($idAlmacen, $fechaDesde, $fechaHasta)
    {
        try {
            $stmt = Conexion::conectar()->prepare("SELECT A.idAlquiler, A.idCliente, B.nombres, C.descripcion, A.idDocAlm, CONCAT(A.cSerie,' - ',A.cNumCom) as comprobante, 
                                                    A.cInstitucion,A.cdirInstitucion,
                                                    CONCAT('Fecha entrega: ', A.tFecEnt) AS fechas1,
                                                    CONCAT('Fecha devolucion: ', A.tFecDev) AS fechas2,
                                                    A.cObsDet, A.nTotal, A.cEstRep, A.cEstado, A.idCaja, concat(G.apellidos,' ',G.nombres) as empleado
                                                    FROM alquiler A 
                                                    INNER JOIN clientes B ON B.idCliente = A.idCliente
                                                    INNER JOIN almacen C ON C.idAlmacen = A.idAlmacen
                                                    INNER JOIN usuario F ON F.idUsuario = A.cCodUsu
                                                    INNER JOIN empleado G ON G.idEmpleado = F.idEmpleado
                                                    where DATE(A.tFecEnt) >= date(:fechaDesde) and DATE(A.tFecEnt) <= date(:fechaHasta) 
                                                    AND A.idAlmacen= :idAlmacen
                                                    ORDER BY A.tFecEnt DESC");

            $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
            $stmt->bindParam(":fechaDesde", $fechaDesde, PDO::PARAM_STR);
            $stmt->bindParam(":fechaHasta", $fechaHasta, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return 'Excepción capturada: ' .  $e->getMessage() . "\n";
        }

        $stmt = null;
    }


    static public function mdlMostrarPagosAlquiler($idAlquiler)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM pago_alquiler where idAlquiler = :idAlquiler");
        $stmt->bindParam(":idAlquiler", $idAlquiler, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function mdlMostrarDetalleAlquiler($idAlquiler)
    {
        $stmt = Conexion::conectar()->prepare("SELECT vc.idAlquilerDetalle, vc.idAlquiler,alq.idAlmacen,p.idProducto, vc.codigo_producto, p.descProducto,vc.cantidad, inv.stock,
                                                CONCAT(emp.simbolom,' ',CONVERT(ROUND(vc.total_pago/vc.cantidad,2), CHAR)) as precio_venta,
                                                CONCAT(emp.simbolom,' ',CONVERT(ROUND(vc.total_pago,2), CHAR)) as total_venta
                                                FROM alquiler_detalle vc 
                                                INNER JOIN producto p 
                                                ON vc.codigo_producto = p.codigoBarras 
                                                INNER JOIN alquiler alq
                                                on alq.idAlquiler = vc.idAlquiler
                                                INNER JOIN empresa emp
                                                ON emp.idEmpresa = 1
                                                INNER JOIN inventario inv
                                                ON inv.idProducto = p.idProducto AND inv.idAlmacen = alq.idAlmacen
                                                WHERE vc.idAlquiler = :idAlquiler");
        $stmt->bindParam(":idAlquiler", $idAlquiler, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    
    static public function mdlMostrarAlquiler($idAlquiler)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM alquiler where idAlquiler = :idAlquiler");
        $stmt->bindParam(":idAlquiler", $idAlquiler, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    static public function mdlEditarEstadoAlquiler($idAlquiler, $cEstRep, $cCodUsu){
		$stmt = Conexion::conectar()->prepare("UPDATE alquiler 
                                                SET cEstRep = :cEstRep,
												cCodUsu = :cCodUsu,
												tModifi = (DATE_SUB(now(), INTERVAL 0 HOUR))
												WHERE idAlquiler = :idAlquiler");
		$stmt -> bindParam(":idAlquiler", $idAlquiler, PDO::PARAM_STR);
        $stmt -> bindParam(":cEstRep", $cEstRep, PDO::PARAM_STR);
        $stmt -> bindParam(":cCodUsu", $cCodUsu, PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	}

    static public function mdlMostrarNotificacionAlquiler($idAlmacen)
    {
        $stmt = Conexion::conectar()->prepare("SELECT B.nombres, A.cEstRep, A.cContac, A.tFecEnt
                                                FROM alquiler A
                                                INNER JOIN clientes B ON A.idCliente = B.idCliente
                                              
                                                WHERE A.cEstRep = 1 
                                                AND A.cEstado = 0
                                                AND A.idAlmacen = IF(:idAlmacen <> '', :idAlmacen, idAlmacen)
                                                ORDER BY A.tfecPen ASC");
        $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function mdlAnularPagosAlquiler($idAlquiler){
		$stmt = Conexion::conectar()->prepare("UPDATE pago_alquiler 
                                                SET estado = 1
												WHERE idAlquiler = :idAlquiler");
		$stmt -> bindParam(":idAlquiler", $idAlquiler, PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	}

}