<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once '../../conexion_reporte/r_conexion.php';

require_once '../../numeroaletras.php';
require_once '../../../models/rutas.php';
$modelonumero = new modelonumero();
$numeroaletras = new numeroaletras();

$url = Ruta::ctrRuta();

$consultaEmpresa = "SELECT * FROM empresa where idEmpresa = 1";

$consulta= "SELECT A.idAlquiler,
D.Documento, 
CONCAT(A.cSerie,' - ',A.cNumCom) as comprobante,
E.descripcion as nomalmacen,
E.ubicacion,
concat(C.nombres,' ',C.apellidos) as empleado,
A.nTotal, 
A.idCliente,
A.tFecEnt, 
A.tFecDev,
A.cCodUsu,
A.cObsDet,
G.nombres as 'nomCli',
A.tModifi,
A.cEstRep,
A.cEstado,
A.cInstitucion,
A.cdirInstitucion,
(SELECT IF(COUNT(*) > 0, 1, 0) FROM alquiler_detalle WHERE idAlquiler = A.idAlquiler) as 'prenda',
(SELECT (A.nTotal - IFNULL(SUM(total_pago), 0)) FROM alquiler_detalle WHERE  idAlquiler = A.idAlquiler) as 'manoObraPrecio'
FROM alquiler A
INNER JOIN usuario B ON A.cCodUsu = B.idUsuario
INNER JOIN empleado C ON B.idEmpleado = C.idEmpleado
INNER JOIN docalmacen D ON A.idDocAlm = D.idDocalmacen
INNER JOIN almacen E ON A.idAlmacen = E.idAlmacen
INNER JOIN clientes G ON G.idCliente = A.idCliente
where A.idAlquiler = '".$_GET['idAlquiler']."'";

$resultado=$mysqli->query($consulta);
$resultadoEmpresa=$mysqli->query($consultaEmpresa);
while($rowEmpresa=$resultadoEmpresa->fetch_assoc()){

while($row=$resultado->fetch_assoc()){

$fecha = setlocale(LC_TIME, "spanish");					    
$numerosol= $modelonumero->numtoletras(abs($row['nTotal']),$rowEmpresa['moneda'],'centimos').'<br>';
$mesDesc = strftime("%d-%m-%Y", strtotime($row['tModifi']));
$html="
<body>
<table width='100%'>
<tr>

<td style='font-size: 8px;text-align:center'><img src='".$url."".$rowEmpresa["logo"]."' alt='Girl in a jacket' width='60' height='60'>
</td>
</tr>
</table>

<h2 style='font-size: 16px;text-align: center;margin: 0 0 5px 0;'>".$rowEmpresa["razon_social"]."</h2>
<div style='text-align:center;  font-size: 13px;' >
<span>".$rowEmpresa["direccion"]."</span><br>
<span>R.U.C: ".$rowEmpresa["ruc"]."</span><br>
<span>Email: ".$rowEmpresa["email"]."</span><br>
<span>".$row["nomalmacen"]."</span><br>
<span>".$row["ubicacion"]."</span>

<hr style='height:1.5px;border:none;color:#333;background-color:#333;' />
<h2 style='font-size: 15px;text-align: center;margin: 0;'>".$row['Documento']."</h2>
<div style='text-align:center;  font-size: 13px;' >
<span>".$row['comprobante']."</span>
<hr style='height:1.5px;border:none;color:#333;background-color:#333;' />

<div style='text-align:left;  font-size: 13px;' >
<span>Fecha Registro: ".$row['tModifi']." </span><br>
<span>Cliente: ".$row['nomCli']."</span><br>
<span>Usuario: ".$row['empleado']."</span><br>
<hr style='height:1.5px;border:none;color:#333;background-color:#333;' />
<span>F. Entrega: ".$row['tFecEnt']."</span><br>
<span>F. Devolución: ".$row['tFecDev']."</span><br>
<hr style='height:1.5px;border:none;color:#333;background-color:#333;' />
<span>Costo Adicional: ".$rowEmpresa["simbolom"]." ".number_format($row['manoObraPrecio'], 2, '.', ',')."</span><br>
<hr style='height:1.5px;border:none;color:#333;background-color:#333;' />
<span>Institucion: ".$row['cInstitucion']."</span><br>
<span>Dirección Inst.: ".$row['cdirInstitucion']."</span><br>
<span>Observació: ".$row['cObsDet']."</span><br>

<hr style='height:1.5px;border:none;color:#333;background-color:#333;' />";

if($row['prenda'] == 1){

$html .= "<table width='100%' style='margin: 0;border-bottom:1px solid;border-left:0px;border-right:0px;border-top:0px;'>
<thead>
<tr style='background-color: #CCCDCF;'>
<th width:'40%' style='font-size: 14px; margin: 0;border-bottom:0px solid;border-left:0px;border-right:0px;border-top:0px;'>Cant.</th>
<th width:'40%' style='font-size: 14px; margin: 0;border-bottom:0px solid;border-left:0px;border-right:0px;border-top:0px;'>Prenda</th>
<th width:'30%' style='font-size: 14px; margin: 0;border-bottom:0px solid;border-left:0px;border-right:0px;border-top:0px;'>Importe</th>
</tr>
</thead>";
$consultaRepuesto= "SELECT vc.idAlquilerDetalle, vc.idAlquiler, vc.codigo_producto, p.descProducto,vc.cantidad,
CONCAT(CONVERT(ROUND(vc.total_pago/vc.cantidad,2), CHAR)) as precio_venta,
CONCAT(CONVERT(ROUND(vc.total_pago,2), CHAR)) as total_venta
FROM alquiler_detalle vc 
INNER JOIN producto p 
ON vc.codigo_producto = p.codigoBarras 
WHERE vc.idAlquiler = '".$_GET['idAlquiler']."'";
$resultadotratamiento=$mysqli->query($consultaRepuesto);
$contadortratamiento=0;
while($rowRepuesto=$resultadotratamiento->fetch_assoc()){

$html.="<tbody>
<tr>
<td  style='font-size: 14px; text-align:center'>".$rowRepuesto['cantidad']."</td>
<td  style='font-size: 14px; text-align:center'>".utf8_encode($rowRepuesto['descProducto'])."</td>
<td  style='font-size: 14px; text-align:center'>".$rowEmpresa["simbolom"]." ". $rowRepuesto['total_venta']."</td>
</tr>
</tbody>";
}
$html.="</table>";

}

$html.="<div style='margin:8px'></div>
<div style='text-align:right; margin:0 15px 0 0'>
<b style=' font-size: 14px;'>TOTAL: &nbsp;&nbsp;".$rowEmpresa["simbolom"]." ".$row['nTotal']."</b></span><div style='margin:3px'></div>";

$consultaPagosAnt= "SELECT metodo_pago as metodo, 
DATE_FORMAT(fecha_pago, '%Y-%m-%d') AS fecha,
ROUND(monto_pago, 2) as monto
FROM pago_alquiler
WHERE idAlquiler = '".$_GET['idAlquiler']."'
ORDER BY idPagoAlquiler desc";
$resultadoPagosAnt=$mysqli->query($consultaPagosAnt);
$contadorPagosAnt=0;
if ($resultadoPagosAnt->num_rows > 0) {
$html.="<hr>
<div style='text-align:center; font-size: 13px;' >
<b style='font-size: 13px; text-align: center;'>Pagos realizados</b>
</div>
<table width='100%' style='margin: 0;border-bottom:1px solid;border-left:0px;border-right:0px;border-top:0px;'>
<thead>
<tr style='background-color: #CCCDCF;'>
<th width:'40%' style='font-size: 12px; margin: 0;border-bottom:0px solid;border-left:0px;border-right:0px;border-top:0px;'>Metodo.</th>
<th width:'40%' style='font-size: 12px; margin: 0;border-bottom:0px solid;border-left:0px;border-right:0px;border-top:0px;'>Monto</th>
<th width:'30%' style='font-size: 12px; margin: 0;border-bottom:0px solid;border-left:0px;border-right:0px;border-top:0px;'>Fecha</th>
</tr>
</thead> ";


while($rowPagosAnt=$resultadoPagosAnt->fetch_assoc()){
    $html.= "<tr>
    <td  style='font-size: 12px; text-align:center'>".$rowPagosAnt['metodo']."</td>
    <td  style='font-size: 12px; text-align:center'> S/. ".number_format($rowPagosAnt['monto'], 2, '.', ',')."</td>
    <td  style='font-size: 12px; text-align:center'>".$rowPagosAnt['fecha']."</td>
    </tr>";
}
$html.="<tbody>
</tbody>
</table>";
}

$html.="<hr>";
    
$html.="<br><div style='text-align:center'>
<b style='font-size: 13px; text-align: center;'>!Gracias por su preferencia¡</b><br>
<b style='font-size: 13px; text-align: center;'>!NO SE ACEPTAN DEVOLUCIONES¡</b>
</div>
</body>";

$Documento = $row['Documento'];
$comprobante = $row['comprobante'];
$filename = $comprobante.'.pdf';
if($row['cEstRep']==3){
$estado = true;
}else{
$estado= false;
}

if(preg_match('/Boleta.*/', $row['Documento'])){
$directorio = '../../libreporte/BOLETAS/';
}else{
$directorio = '../../libreporte/TICKET/';
}

}
}
//function mPDF($mode='',$format='format',$=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P')
//$mpdf = new \Mpdf\Mpdf(['mode' => ' utf-8', 'format' => [85, 250], 'default_font_size' => '', 'mgl' => 2 ,'mgr' => 2]);

			
$mpdf= new \Mpdf\Mpdf(['mode' => 'utf-8','format' => [80,250],'margin_left' => 5,'margin_right' => 5,'margin_top' => 2,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]); 
$mpdf->SetWatermarkText('ANULADO',1,20);
$mpdf->showWatermarkText = $estado;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.2;
$mpdf->SetTitle($Documento);
$mpdf->WriteHTML($html);

$mpdf->Output($filename,'I');
//$mpdf->Output($directorio.$filename,'F');