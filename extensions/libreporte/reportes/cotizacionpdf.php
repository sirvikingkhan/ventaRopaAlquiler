<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once '../../conexion_reporte/r_conexion.php';
require_once '../../numeroaletras.php';
require_once '../../../models/rutas.php';
$modelonumero = new modelonumero();
$numeroaletras = new numeroaletras();

$url = Ruta::ctrRuta();
$css=file_get_contents('estilocoti.css');

$consulta= "SELECT 
c.idCotizacion as idCotizacion,
c.cNomCli,
c.cNuDoci,
c.cDirCli,
c.cTelCli,
da.Documento,
CONCAT(c.cSerie, ' - ', LPAD(c.cNroDoc, 8, '0')) as comprobante, 
a.descripcion as nomalmacen,
a.ubicacion,
CONCAT(em.nombres,' ',em.apellidos) as empleado,
CONCAT('S/. ', c.nSubTotal) as nSubTotal,
CONCAT('S/. ', c.nIgv) as nIgv,
CONCAT('S/. ', c.nTotal) as nTotal,
c.nTotal as nTotalNumero,
c.fecha_cotizacion
FROM cotizacion c
INNER JOIN usuario u ON c.idUsuario = u.idUsuario
INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado
INNER JOIN almacen a ON c.idAlmacen = a.idAlmacen
INNER JOIN docalmacen da ON c.cTipDoc = da.idDocalmacen

where c.idCotizacion = '".$_GET['idCotizacion']."'";

$resultado=$mysqli->query($consulta);


while($row=$resultado->fetch_assoc()){


$fecha = setlocale(LC_TIME, "spanish");					    
$numerosol= $modelonumero->numtoletras(abs($row['nTotalNumero']),$row['moneda'],'centimos').'<br>';
$mesDesc = strftime("%d-%m-%Y", strtotime($row['fecha_cotizacion']));
$html.="
<body>
<div class='tablageneral tablacostos tablaboleta'>        
    
    

<table class='tablareceipt' style=' text-align: center !important;'>
    <tbody>
        <tr >
        <td style=' text-align: center !important;'>

 
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img class='logofactura' text-align: left !important  src='../../../views/img/logo.png'>
                <p style='text-transform: none !important;'><strong>ZANAHORIA REFUGIOS</strong></p>
                <p style='text-transform: none !important;'><img src='../../../views/img/map-marker-alt-solid.svg' style='width: 12px;' /> Dirección: AREQUIPA - AREQUIPA</p>
                <p style='text-transform: none !important;'><img src='../../../views/img/email.png' style='width: 12px;' /> Contacto: ".$row['cTelCli']."</p>
                <p style='text-transform: none !important;'><img src='../../../views/img/store-solid.svg' style='width: 12px;' /> Sucursal : ".$row['nomalmacen']."</p>
                 <p style='text-transform: none !important;'><img src='../../../views/img/map-marker-alt-solid.svg' style='width: 12px;' /> Dirección Sucursal : ".$row['ubicacion']."</p>
            </td>
            <td style=' text-align: left !important;'>
            <br><br><br><br><br><br><br>
               <p style='text-transform: none !important;'><img src='../../../views/img/calendar-alt-solid.svg' style='width: 12px;' /> Fecha Emisión: ".$mesDesc." </p>
                <p style='text-transform: none !important;'><img src='../../../views/img/user-solid.svg' style='width: 12px;' /> Cliente:  ".$row["cNomCli"]."</p>
               <p style='text-transform: none !important;'><img src='../../../views/img/id-card-regular.svg' style='width: 12px;' /> DNI/RUC: ".$row["cNuDoci"]."</p>
                <p style='text-transform: none !important;'><img src='../../../views/img/map-marker-alt-solid.svg' style='width: 12px;' /> Dirección: ".$row["cDirCli"]."</p>
            </td>
            
            <td class='textruc'>
        
                <p style='font-size: 30px'>R.U.C. 20608887483</p>                    
                <p style='font-size: 25px'>".$row['Documento']."</p>
                <p style='font-size: 25px'>".$row['comprobante']."</p>
            </td>
        </tr>
       
       
    </tbody>
</table>

</div>
<div class='tablageneral'>        
    <table cellpadding='0' cellspacing='0'>
   
        <tbody>
            <tr class='titulotable'>
                <td class='cantidadtabla'  style='text-align: center;font-size: 12px'>Codigo</td>
                <td style='text-align: center;font-size: 12px'>Descripción</td>
                
                <td class='preciotabla' style='text-align: center;font-size: 12px'>Precio Unitario</td>
                <td class='cantidadtabla' style='text-align: center;font-size: 12px'>Cantidad</td>
                <td class='preciotabla' style='text-align: center;font-size: 12px'>Sub Total</td>
                </tr>";
$consultatratamiento= "SELECT 
vc.idDetalleCotizacion, 
vc.idCotizacion, 
p.codigoBarras, 
p.descProducto,
ROUND(vc.cantidad,2) cantidad,
CONCAT('S/. ',CONVERT(ROUND(vc.totalcoti/vc.cantidad,2), CHAR)) as precio_cotizacion,
CONCAT('S/. ',CONVERT(ROUND(vc.totalcoti,2), CHAR)) as total_cotizacion
FROM detalle_cotizacion vc 
INNER JOIN producto p 
ON vc.idProducto = p.idProducto 
where vc.idCotizacion='".$_GET['idCotizacion']."'";
$resultadotratamiento=$mysqli->query($consultatratamiento);
$contadortratamiento=0;
while($rowtratamiento=$resultadotratamiento->fetch_assoc()){

$html.="

            <tr class='detalletable'>
                <td style='text-align: center;font-size: 12px'>". $rowtratamiento['codigoBarras']."</td>
                <td style='text-align: center;font-size: 12px'>".utf8_encode($rowtratamiento['descProducto'])."</td>
                <td style='text-align: center;font-size: 12px'>". $rowtratamiento['precio_cotizacion']."</td>
                <td style='text-align: center;font-size: 12px'>".$rowtratamiento['cantidad']."</td>
                <td style='text-align: center;font-size: 12px'>". $rowtratamiento['total_cotizacion']."</td>
               
            </tr>";
}
           
       $html.=" </tbody>
    </table>
</div>

<div class='tablageneral tablacostos tablaboleta'>        
    <table cellpadding='0' cellspacing='0'>
        <tbody>   
            <tr class='detalletable'>                                                                
                <td colspan='2' rowspan='3' style='vertical-align: top'>
                    <div style='font-size: 12px'>SON: ".$numerosol."</div>
                    <hr/><br/>
                    <div  style='font-size: 12px'>Observación</div>
                </td>
                <td class='preciotabla fintabla fintabla fintablados'style='text-align:right; font-size: 12px'><b >TOTAL</b></td>
                <td class='preciotabla ulttable fintabla' style='text-align:right; font-size: 12px'> ".$row['nTotal']."</td>
            </tr>  
           
           
        </tbody>
    </table>        
    
</div>
<table cellpadding='0' cellspacing='0' class='tablacan'>
            <tbody>
                <tr>    
                    <td style=''>
                        <img style='width: 124px; margin-bottom: 11px;' src='../../../views/img/qr.png' />
                        <p style='font-size: 10px'>
                        Cajero/ ".$row["empleado"]."
                        </p>   
                    </td>                    
                    <td style='text-align:center'>
                    <div>
                    <br><b style='text-align: center'>¡Gracias por su preferencia!</b><br>
            
                    <b style='text-align: center;'></b><br>
                    
                    </div>
                        
                    </td>
                </tr>   
            </tbody>
        </table>
        
    
  

</body>
";
if($row['estado']==1){
$estado = true;
}else{
$estado= false;
}
}


$mpdf = new \Mpdf\Mpdf(['mode' => ' utf-8', 'format' => 'A4','margin_left' => 8,'margin_right' => 8,'margin_top' => 5,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]);
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html);
$mpdf->SetWatermarkText('ANULADO',2,50);
$mpdf->showWatermarkText = $estado;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.12;
$mpdf->Output();