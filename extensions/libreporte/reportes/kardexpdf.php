<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once '../../conexion_reporte/r_conexion.php';
require_once '../../../models/rutas.php';
$url = Ruta::ctrRuta();

$consultaEmpresa = "SELECT * FROM empresa where idEmpresa = 1";
$consulta= "SELECT A.fecha_registro, A.motivo, A.observacion, A.stock,
B.descProducto, C.descripcion, 
concat(E.nombres,' ',E.apellidos) as empleado, A.tipo, A.habia, A.hay
FROM kardex A 
INNER JOIN producto B ON A.idProducto = B.idProducto
INNER JOIN almacen C ON A.idAlmacen = C.idAlmacen
INNER JOIN usuario D ON A.idUsuario = D.idUsuario
INNER JOIN empleado E ON E.idEmpleado = D.idEmpleado
WHERE A.idKardex = ".$_GET['idKardex']."
";

$resultado=$mysqli->query($consulta);
$resultadoEmpresa=$mysqli->query($consultaEmpresa);
while($rowEmpresa=$resultadoEmpresa->fetch_assoc()){
while($row=$resultado->fetch_assoc()){
$fecha = setlocale(LC_TIME, "spanish");					    
$mesDesc = strftime("%d de %B de %Y", strtotime($row['fecha_registro']));

$html="
<table width='100%'>
<tr>

<td style='font-size: 8px;text-align:center'><img src='".$url."".$rowEmpresa["logo"]."' alt='Girl in a jacket' width='60' height='60'>
</td>
</tr>
</table>

<h2 style='font-size: 20px;text-align: center;margin: 0 0 5px 0;border-radius: 5px;'>Movimiento Kardex</h2>
<h4 style='font-size: 13px;text-align: center;margin: 0 0 5px 0;border-radius: 5px;'> * ".$row['empleado']." * </h4>
<h4 style='font-size: 13px;text-align: center;margin: 0 0 5px 0;border-radius: 5px;'>$mesDesc</h4>

<hr style='height:1.5px;border:none;color:#333;background-color:#333; margin: 0 0 10px 0' />


<table width='100%'>
<tr>
<td style='font-size: 11px;text-align:left'>PRODUCTO: </td>
<td style='font-size: 11px;text-align:Right '>".$row["descProducto"]."</td>
</tr>
<tr>
<td style='font-size: 11px;text-align:left'>SEDE: </td>
<td style='font-size: 11px;text-align:Right '>  ".$row['descripcion']."</td>
</tr>
<tr>
<td style='font-size: 11px;text-align:left'>TIPO: </td>
<td style='font-size: 11px;text-align:Right '>  ".$row['tipo']."</td>
</tr>
<tr>
<td style='font-size: 11px;text-align:left'>MOTIVO: </td>
<td style='font-size: 11px;text-align:Right '>  ".$row['motivo']."</td>
</tr>
<tr>
<td style='font-size: 11px;text-align:left'>OBSERVACION: </td>
<td style='font-size: 11px;text-align:Right '>  ".$row['observacion']."</td>
</tr>
<tr>
<td></td>
</tr>
</table>


<hr style='height:1.5px;border:none;color:#333;background-color:#333; margin: 0 0 13px 0' />
<table width='100%'>
<tr>
<td style='font-size: 11px;text-align:left'>HABIA: </td>
<td style='font-size: 11px;text-align:Right '>".$row['habia']."</td>
</tr>
<tr>
<td style='font-size: 11px;text-align:left'>STOCK: </td>
<td style='font-size: 11px;text-align:Right '>".$row['stock']."</td>
</tr>
<tr>
<td style='font-size: 11px;text-align:left'>HAY: </td>
<td style='font-size: 11px;text-align:Right '>".$row['hay']."</td>
</tr>
<tr>
<td></td>
</tr>
</table>
<hr style='height:1.5px;border:none;color:#333;background-color:#333; margin: 0 0 0px 0' />

</div>
";
}
}
//$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Letter-L']);
$mpdf= new \Mpdf\Mpdf(['mode' => 'utf-8','format' => [80, 100],'margin_left' => 5,'margin_right' => 5,'margin_top' => 2,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]); 
$mpdf->WriteHTML($html);
$mpdf->Output();