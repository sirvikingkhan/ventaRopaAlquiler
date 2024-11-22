<?php

class CotizacionController{
    public $loRespuesta = [];

    static public function ctrObtenerNroBoleta(){
        $nroBoleta = CotizacionModel::mdlObtenerNroBoleta();
        return $nroBoleta;
    }

    static public function ctrListarproductosCotizacion(){
        $listadoProducto = CotizacionModel::mdlListarproductosCotizacion();
        return $listadoProducto;
    }

    static public function ctrRegistrarCotizacion($datos,$cNuDoci,$cNomCli,$cTelCli,$cDirCli,$cTipDoc,$cNroDoc,$cSerie,$nSubTotal,$nIgv,$nTotal,$idUsuario,$idAlmacen){
        
        $respuesta = CotizacionModel::mdlRegistrarCotizacionCabecera($cNuDoci,$cNomCli,$cTelCli,$cDirCli,$cTipDoc,$cNroDoc,$cSerie,$nSubTotal,$nIgv,$nTotal,$idUsuario,$idAlmacen);

        foreach ($datos as $dato) {
            $listaProductos = explode(",", $dato);
            CotizacionModel::mdlRegistrarDetalleCotizacion($listaProductos[0], $listaProductos[1], $listaProductos[2]);
        }

        CotizacionModel::mdlActualizarDocumento($cTipDoc);

        $loRespuesta["codigoError"] = 0;
        $loRespuesta["mensajeError"] = "";
        $loRespuesta["idVenta"] = $respuesta;
        return $respuesta = $loRespuesta;
    }

    static public function ctrMostrarCotizacion($fechaDesde,$fechaHasta){
        $listadoProducto = CotizacionModel::mdlMostrarCotizacion($fechaDesde,$fechaHasta);
        return $listadoProducto;
    }

   
}