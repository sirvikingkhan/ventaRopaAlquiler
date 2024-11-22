var tablaVerCotizacion;

var n = new Date();
var y = n.getFullYear();
var m = n.getMonth() + 1;
var d = n.getDate();
if (d < 10) {
    d = '0' + d;
}
if (m < 10) {
    m = '0' + m;

}
document.getElementById('cotizacion_desde').value = y + "-" + m + "-" + d;
document.getElementById('cotizacion_hasta').value = y + "-" + m + "-" + d;

cotizacion_desde = $("#cotizacion_desde").val();
cotizacion_hasta = $("#cotizacion_hasta").val();

// Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
tablaVerCotizacion = $(".tablaVerCotizacion").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "responsive": true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },

    ajax: {
        url: "ajax/tablas/tablaCotizacion.ajax.php",
        dataSrc: "",
        data: {
            'fechaDesde': cotizacion_desde,
            'fechaHasta': cotizacion_hasta //1: LISTAR PRODUCTOS
        },
    },
    columns: [{
            data: "idCotizacion"
        },
        {
            data: "comprobante"
        },
        {
            data: "cliente"
        },
        {
            data: "cTelCli"
        },
        {
            data: "descripcion"
        },
        {
            data: "totalCotizacion"
        },
        {
            data: "estado"
        },
        {
            data: "usuario"
        },
        {
            data: "fecha_cotizacion"
        },
        {
            data: "acciones"
        },
    ],


    bDestroy: true,
    iDisplayLength: 10,
});



$(document).on('click', '.pdf', function () {

    var idCotizacion = $(this).attr("idCotizacion");
    window.open(
        rutaOculta+"/extensions/libreporte/reportes/cotizacionpdf.php?idCotizacion=" +
        idCotizacion +
        "#zoom=100%",
        "Ticket",
        "scrollbars=NO"
      );

})


$("#btnQFiltro").on('click', function () {
    var n = new Date();
    var y = n.getFullYear();
    var m = n.getMonth() + 1;
    var d = n.getDate();
    if (d < 10) {
        d = '0' + d;
    }
    if (m < 10) {
        m = '0' + m;

    }
    document.getElementById('cotizacion_desde').value = y + "-" + m + "-" + d;
    document.getElementById('cotizacion_hasta').value = y + "-" + m + "-" + d;

    cotizacion_desde = $("#cotizacion_desde").val();
    cotizacion_hasta = $("#cotizacion_hasta").val();
    tablaVerCotizacion = $(".tablaVerCotizacion").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },

        ajax: {
            url: "ajax/tablas/tablaCotizacion.ajax.php",
            dataSrc: "",
            data: {
                'fechaDesde': cotizacion_desde,
                'fechaHasta': cotizacion_hasta //1: LISTAR PRODUCTOS
            },
        },
        columns: [{
                data: "idCotizacion"
            },
            {
                data: "comprobante"
            },
            {
                data: "cliente"
            },
            {
                data: "cTelCli"
            },
            {
                data: "descripcion"
            },
            {
                data: "totalCotizacion"
            },
            {
                data: "estado"
            },
            {
                data: "usuario"
            },
            {
                data: "fecha_cotizacion"
            },
            {
                data: "acciones"
            },
        ],


        bDestroy: true,
        iDisplayLength: 10,
    });

})

$("#btnFiltrar").on('click', function () {

    tablaVerCotizacion.destroy();

    if ($("#cotizacion_desde").val() == '') {
        cotizacion_desde = '01/10/2000';
    } else {
        cotizacion_desde = $("#cotizacion_desde").val();
    }

    if ($("#cotizacion_hasta").val() == '') {
        cotizacion_hasta = '10/10/9999';
    } else {
        cotizacion_hasta = $("#cotizacion_hasta").val();
    }

    cotizacion_desde = $("#cotizacion_desde").val();
    cotizacion_hasta = $("#cotizacion_hasta").val();

    tablaVerCotizacion = $(".tablaVerCotizacion").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },

        ajax: {
            url: "ajax/tablas/tablaCotizacion.ajax.php",
            dataSrc: "",
            data: {
                'fechaDesde': cotizacion_desde,
                'fechaHasta': cotizacion_hasta //1: LISTAR PRODUCTOS
            },
        },
        columns: [{
                data: "idCotizacion"
            },
            {
                data: "comprobante"
            },
            {
                data: "cliente"
            },
            {
                data: "cTelCli"
            },
            {
                data: "descripcion"
            },
            {
                data: "totalCotizacion"
            },
            {
                data: "estado"
            },
            {
                data: "usuario"
            },
            {
                data: "fecha_cotizacion"
            },
            {
                data: "acciones"
            },
        ],


        bDestroy: true,
        iDisplayLength: 10,
    });

})

$(".content").keypress(function (event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        $("#btnFiltrar").click();
    }
});