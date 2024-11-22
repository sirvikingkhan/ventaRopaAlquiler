<?php

require_once "conexion.php";

class VentasModel
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


    static public function mdlMostrarDocumento($idAlmacen)
    {

        $stmt = Conexion::conectar()->prepare("SELECT idDocalmacen,Documento from docalmacen WHERE idAlmacen = :idAlmacen");

        $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    static public function mdlRegistrarVenta($datos, $idCliente, $idAlmacen, $idUsuario, $idDocalmacen, $serie, $nro_comprobante, $descripcion, $subtotal, $igv, $delivery,$descuento, $total_venta, $idCaja)
    {

        $con = Conexion::conectar();
        $stmt =  $con->prepare("INSERT INTO venta_cabecera(idCliente,idAlmacen,idUsuario,idDocalmacen,serie,nro_comprobante,descripcion,subtotal,
                                                        igv,delivery,descuento,total_venta,idCaja, fecha_venta) 
                                                VALUES(:idCliente,:idAlmacen,:idUsuario,:idDocalmacen,:serie,:nro_comprobante,:descripcion,:subtotal,:igv,
                                                        :delivery,:descuento,:total_venta,:idCaja, (DATE_SUB(now(), INTERVAL 0 HOUR)))");

        $stmt->bindParam(":idCliente", $idCliente, PDO::PARAM_STR);
        $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
        $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_STR);
        $stmt->bindParam(":idDocalmacen", $idDocalmacen, PDO::PARAM_STR);
        $stmt->bindParam(":serie", $serie, PDO::PARAM_STR);
        $stmt->bindParam(":nro_comprobante", $nro_comprobante, PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(":subtotal", $subtotal, PDO::PARAM_STR);
        $stmt->bindParam(":igv", $igv, PDO::PARAM_STR);
        $stmt->bindParam(":delivery", $delivery, PDO::PARAM_STR);
        $stmt->bindParam(":descuento", $descuento, PDO::PARAM_STR);
        $stmt->bindParam(":total_venta", $total_venta, PDO::PARAM_STR);
        $stmt->bindParam(":idCaja", $idCaja, PDO::PARAM_STR);

        if ($stmt->execute()) {

            $stmt = null;
            $stmt = Conexion::conectar()->prepare("UPDATE docalmacen SET Cantidad = LPAD(Cantidad + 1,8,'0') WHERE idDocalmacen = :idDocalmacen AND idAlmacen = :idAlmacen");

            $stmt->bindParam(":idDocalmacen", $idDocalmacen, PDO::PARAM_STR);
            $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);

            if ($stmt->execute()) {

                $stmt = null;
                $stmt = Conexion::conectar()->prepare("UPDATE clientes SET credito_usado = credito_usado - 0 WHERE idCliente = $idCliente");

                /*if ($stmt->execute()) {
                    if ($tipo_pago == "Credito") {
                        $stmt = null;
                        $stmt = Conexion::conectar()->prepare("INSERT bitacora_credito (idCliente,descripcion,montod)
														VALUES ($idCliente,'COMPRA DE PRODUCTO + ',CONCAT(' ', CAST($total_venta AS DECIMAL(7, 2))))");
                    }
                } else {
                }*/

                if ($stmt->execute()) {

                    $listaProductos = [];

                    for ($i = 0; $i < count($datos); ++$i) {

                        $listaProductos = explode(",", $datos[$i]);

                        //var_dump($listaProductos);

                        $stmt = Conexion::conectar()->prepare("INSERT INTO venta_detalle(idVenta,codigo_producto, cantidad, total_venta) 
                                                            VALUES((select IFNULL(max(c.idVenta),'1') idVenta from venta_cabecera c),:codigo_producto,:cantidad,:total_venta)");

                        $stmt->bindParam(":codigo_producto", $listaProductos[0], PDO::PARAM_STR);
                        $stmt->bindParam(":cantidad", $listaProductos[1], PDO::PARAM_STR);
                        $stmt->bindParam(":total_venta", $listaProductos[2], PDO::PARAM_STR);



                        if ($stmt->execute()) {
                            $stmt = null;

                            $stmt = Conexion::conectar()->prepare("UPDATE inventario as i INNER JOIN producto as p ON i.idProducto = p.idProducto SET i.stock = i.stock - :cantidad 
                                                                    WHERE i.idAlmacen = :idAlmacen AND p.codigoBarras = :codigo_producto");

                            $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
                            $stmt->bindParam(":codigo_producto", $listaProductos[0], PDO::PARAM_STR);
                            $stmt->bindParam(":cantidad", $listaProductos[1], PDO::PARAM_STR);

                            if ($stmt->execute()) {
                                $stmt = null;

                                $stmt = Conexion::conectar()->prepare("INSERT INTO kardex(motivo,stock, idProducto, idAlmacen, idUsuario, tipo, estado,habia, hay) 
                                                                    VALUES ('Salida por Venta',:stock, :idProducto, $idAlmacen,$idUsuario, 'Salida', 1, :habia, :habia - :hay)");


                                $stmt->bindParam(":idProducto", $listaProductos[3], PDO::PARAM_STR);
                                $stmt->bindParam(":stock", $listaProductos[1], PDO::PARAM_STR);
                                $stmt->bindParam(":habia", $listaProductos[4], PDO::PARAM_STR);
                                $stmt->bindParam(":hay", $listaProductos[1], PDO::PARAM_STR);

                                if ($stmt->execute()) {
                                    $resultado = "Se registró la venta correctamente.";
                                } else {
                                    $resultado = "Error al actualizar el stock";
                                }
                            }
                        } else {
                            $resultado = "Error al registrar la venta";
                        }
                    }

                    $stmt = null;
                }
            }
            $idd =  $con->lastInsertId();
            return intval($idd);
        }
    }

    static public function mdlRegistrarPagoVenta($idVenta, $metodo_pago, $monto_pago, $nro_opeacen)
    {

        $con = Conexion::conectar();
        $stmt =  $con->prepare("INSERT INTO pago_venta(idVenta,metodo_pago,monto_pago,nro_ope,estado,fecha_pago) 
                                                VALUES(:idVenta, :metodo_pago, :monto_pago, :nro_ope, 0 , (DATE_SUB(now(), INTERVAL 0 HOUR)))");

        $stmt->bindParam(":idVenta", $idVenta, PDO::PARAM_STR);
        $stmt->bindParam(":metodo_pago", $metodo_pago, PDO::PARAM_STR);
        $stmt->bindParam(":monto_pago", $monto_pago, PDO::PARAM_STR);
        $stmt->bindParam(":nro_ope", $nro_opeacen, PDO::PARAM_STR);
   
        if($stmt -> execute()){
            return "Se registro el pago";
        }else{
            return "Error, no se registro el pago";
        }       
    }

    static public function mdlListarVenta($idVenta)
    {
        $stmt = Conexion::conectar()->prepare("SELECT vc.idVenta,da.Documento, vc.serie, vc.nro_comprobante,  concat(em.nombres,' ',em.apellidos) as empleado, vc.total_venta,vc.subtotal,vc.igv,
                                                vc.estado, vc.fecha_venta
                                                FROM venta_cabecera vc
                                                INNER JOIN usuario u ON vc.idUsuario = u.idUsuario
                                                INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado
                                                INNER JOIN docalmacen da ON vc.idDocalmacen = da.idDocalmacen
                                                WHERE  vc.idVenta= :idVenta");
        $stmt->bindParam(":idVenta", $idVenta, PDO::PARAM_INT);
        $stmt->execute();
        //return $stmt->fetchAll(); para que aparescan muchos
        return $stmt->fetch(); //para que aparesca uno
    }

    static public function mdlListarVentas($idAlmacen, $fechaDesde, $fechaHasta)
    {

        try {
            // SELECT v.id,v.codigo_producto,c.nombre_categoria,p.descripcion_producto,v.cantidad, concat('S./ ',round(v.total_venta,2)) as total_venta,v.fecha_venta
            $stmt = Conexion::conectar()->prepare("SELECT vc.idVenta,da.Documento, vc.serie, vc.nro_comprobante,  concat(em.nombres,' ',em.apellidos) as empleado, vc.total_venta,vc.subtotal,vc.igv,
                                                    vc.estado, vc.fecha_venta
                                                    FROM venta_cabecera vc
                                                    INNER JOIN usuario u ON vc.idUsuario = u.idUsuario
                                                    INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado
                                                    INNER JOIN docalmacen da ON vc.idDocalmacen = da.idDocalmacen
                                                    where DATE(vc.fecha_venta) >= date(:fechaDesde) and DATE(vc.fecha_venta) <= date(:fechaHasta) 
                                                    AND vc.idAlmacen= :idAlmacen");

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

    static public function mdlMostrarDetalleVenta($idVenta)
    {

        $stmt = Conexion::conectar()->prepare("SELECT vc.idDetalle, vc.idVenta, vc.codigo_producto, p.descProducto,vc.cantidad,
                                                CONCAT(emp.simbolom,' ',CONVERT(ROUND(vc.total_venta/vc.cantidad,2), CHAR)) as precio_venta,
                                                CONCAT(emp.simbolom,' ',CONVERT(ROUND(vc.total_venta,2), CHAR)) as total_venta
                                                FROM venta_detalle vc 
                                                INNER JOIN producto p 
                                                ON vc.codigo_producto = p.codigoBarras 
                                                INNER JOIN empresa emp
                                                ON emp.idEmpresa = 1
                                                WHERE vc.idVenta = :idVenta");
        $stmt->bindParam(":idVenta", $idVenta, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }


    static public function mdlAnularVenta($idVenta)
    {

        $stmt = Conexion::conectar()->prepare("call prc_anular_venta(:idVenta)");

        $stmt->bindParam(":idVenta", $idVenta, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch();
    }
    static public function mdlTotalVenta($idAlmacen, $fechaDesde, $fechaHasta)
    {

        $stmt = Conexion::conectar()->prepare("SELECT 
                                                    IFNULL(ROUND(SUM(CASE 
                                                                    WHEN pv.metodo_pago = 'Efectivo' AND pv.estado = 0
                                                                    THEN pv.monto_pago 
                                                                    ELSE 0 END), 2), 0.00) as Total_Efectivo,
                                                    IFNULL(ROUND(SUM(CASE 
                                                                    WHEN pv.estado = 0 
                                                                    THEN pv.monto_pago 
                                                                    ELSE 0 END), 2), 0.00) as Total_Aceptados,
                                                    IFNULL(ROUND(SUM(pv.monto_pago), 2), 0.00) as Total_Todo
                                                FROM pago_venta pv 
                                                INNER JOIN venta_cabecera vc ON pv.idVenta = vc.idVenta
                                                WHERE vc.idAlmacen = :idAlmacen
                                                AND DATE(pv.fecha_pago) >= DATE(:fechaDesde) 
                                                AND DATE(pv.fecha_pago) <= DATE(:fechaHasta)");

        $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
        $stmt->bindParam(":fechaDesde", $fechaDesde, PDO::PARAM_STR);
        $stmt->bindParam(":fechaHasta", $fechaHasta, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
        $stmt = null;
    }

    static public function mdlGraficoVenta($idAlmacen)
	{
		if ($idAlmacen != null) {
			$stmt = Conexion::conectar()->prepare("SELECT SUBSTR(fecha_venta, 1, 7) AS fecha_venta,
                                                    ROUND(SUM(total_venta),2) AS total_venta
                                                    FROM venta_cabecera
                                                    where idAlmacen = :idAlmacen
                                                    and estado = 0
                                                    GROUP by MONTH(fecha_venta)");
            $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT SUBSTR(fecha_venta, 1, 7) AS fecha_venta,
                                                    ROUND(SUM(total_venta),2) AS total_venta
                                                    FROM venta_cabecera
                                                    where estado = 0
                                                    GROUP by MONTH(fecha_venta)");
			$stmt->execute();
			return $stmt->fetchAll();
		}
		$stmt = null;
	}

    static public function mdlExportExcel()
	{
		
			$stmt = Conexion::conectar()->prepare("SELECT A.idProducto, A.descProducto, A.ubicacion, A.codigoBarras, B.desCat,
                                                    CONCAT(C.simbolom,' ',CONVERT(ROUND(A.precioCompra,2), CHAR)) as precioCompra,
                                                    CONCAT(C.simbolom,' ',CONVERT(ROUND(A.precioVenta,2), CHAR)) as precioVenta,
                                                    CONCAT(C.simbolom,' ',CONVERT(ROUND(A.precioVentaMA,2), CHAR)) as precioVentaMA,
                                                    CONCAT(C.simbolom,' ',CONVERT(ROUND(A.oferta,2), CHAR)) as oferta 
                                                    FROM producto A
                                                    INNER JOIN categoria B ON A.idCategoria = B.idCategoria
                                                    INNER JOIN empresa C ON C.idEmpresa = 1");
            $stmt->execute();
            return $stmt->fetchAll();
		
		$stmt = null;
	}

    static public function mdlMostrarPagosVenta($idVenta)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM pago_venta where idVenta = :idVenta");
        $stmt->bindParam(":idVenta", $idVenta, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();

        $stmt = null;
    }
    
}