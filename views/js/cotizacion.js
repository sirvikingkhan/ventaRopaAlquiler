var rutaOculta = $("#rutaOculta").val();
var table;
var toast2 = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
});

var items = [];
var itemProducto = 1;
var idDocalmacen, serie, nro_boleta;

$("#iptCodigoCotizacion").focus();
cargarDocumento();

table = $("#lstProductosCotizacion").DataTable({
    /*"responsive": true, 
    "lengthChange": false, 
    "autoWidth": false,
    "responsive": true,*/
    columns: [{
            data: "idProducto"
        },
        {
            data: "codigoBarras"
        },
        {
            data: "descProducto"
        },
        {
            data: "cantidad"
        },
        {
            data: "precio_venta_producto"
        },
        {
            data: "total"
        },
        {
            data: "acciones"
        },
        {
            data: "idProducto"
        },
        {
            data: "stock"
        },
        {
            data: "precioVentaMA"
        },
        {
            data: "oferta"
        },
    ],

    columnDefs: [{
            targets: 0,
            visible: false,
        },
        {
            targets: 7,
            visible: false,
        },
        {
            targets: 8,
            visible: false,
        },
        {
            targets: 9,
            visible: false,
        },
        {
            targets: 10,
            visible: false,
        },
        
        
    ],
    order: [
        [0, "desc"]
    ],
    language: {
        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
});


$.ajax({
    async: false,
    url: rutaOculta + "ajax/cotizacion.ajax.php",
    method: "POST",
    data: {
        'ajaxListarproductosCotizacion': "ajaxListarproductosCotizacion"
    },
    dataType: 'json',
    success: function (respuesta) {

        for (let i = 0; i < respuesta.length; i++) {
            items.push(respuesta[i]['descripcion_producto'])
        }
        $("#iptCodigoCotizacion").autocomplete({
            source: items,
            select: function (event, ui) {

                CargarProductos(ui.item.value);
                $("#iptCodigoCotizacion").val("");
                $("#iptCodigoCotizacion").focus();
                return false;
            }
        })

    }
})



$("#iptCodigoCotizacion").change(function () {
    CargarProductos();
    $("#iptCodigoCotizacion").val("");
    $("#iptCodigoCotizacion").focus();
});

$("#btnVaciarListado").on("click", function () {
    table.clear().draw();
    //LimpiarInputs();
});

function CargarProductos(producto = "") {
    if (producto != "") {
        var codigo_producto = producto;
    } else {
        var codigo_producto = $("#iptCodigoCotizacion").val();
    }

    var existe = 0;
    var codigo_repetido;
    var NuevoPrecio = 0;
    var TotalVenta = 0;


    // return false;
    // VERIFICAMOS QUE SI EL PRODUCTO YA FUE AGREGADO, AUMENTE EN 1 LA CANTIDAD
    table
        .column(1)
        .data()
        .each(function (value, index) {
            if (parseInt(codigo_producto) == parseInt(value)) {
                existe = 1;
                codigo_repetido = parseInt(value);
            }
        });

    if (existe == 1) {
        table
            .rows()
            .eq(0)
            .each(function (index) {
                var row = table.row(index);

                var data = row.data();

                if (data["codigoBarras"] == codigo_repetido) {
                    table
                        .cell(index, 3)
                        .data(parseInt(data["cantidad"]) + 1 + " Und(s)")
                        .draw();

                    NuevoPrecio = (
                        parseInt(data["cantidad"]) *
                        data["precio_venta_producto"].replace("S./ ", "")
                    ).toFixed(2);
                    NuevoPrecio = "S./ " + NuevoPrecio;

                    table.cell(index, 5).data(NuevoPrecio).draw();

                    $("#iptCodigoCotizacion").val("");
                    recalcularTotales();

                }
            });

        /*============================================================================
              SI EL PRODUCTO NO ESTA REGISTRADO EN EL LISTADO DE VENTAS
              ============================================================================*/
    } else {
        $.ajax({
            url: rutaOculta + "ajax/producto.ajax.php",
            method: "POST",
            data: {
                ajaxGetDatosProductosCotizacion: "ajaxGetDatosProductosCotizacion",
                codigo_producto: codigo_producto,
            },

            dataType: "json",
            success: function (respuesta) {
                //  console.log(respuesta);
                if (respuesta) {
                var TotalVenta = 0.0;


                table.row
                    .add({
                        idProducto: itemProducto,
                        codigoBarras: respuesta["codigoBarras"],
                        descProducto: respuesta["descProducto"],
                        cantidad: respuesta["cantidad"] + " Und(s)",
                        precio_venta_producto: respuesta["precio_venta_producto"],
                        total: respuesta["total"],
                        acciones: "<center>" +
                            //"<span class='btnEditarCantidad text-secondary px-1' idProducto='" + respuesta["idProducto"] + "' codigo='" + respuesta["codigoBarras"] + "'   cantidad='" + respuesta['cantidad'] + "' data-toggle='modal' data-target='#modalCantidadVenta' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Aumentar Stock'> " +
                            //"<i class='fas fa-plus-square fs-5'></i>" +
                            //"</span> " +
                            "<span class='btnAumentarCantidad text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Aumentar Stock'> " +
                            "<i class='fas fa-cart-plus fs-5'></i> " +
                            "</span> " +
                            "<span class='btnDisminuirCantidad text-warning px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Disminuir Stock'> " +
                            "<i class='fas fa-cart-arrow-down fs-5'></i> " +
                            "</span> " +
                            "<span class='btnEliminarproducto text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar producto'> " +
                            "<i class='fas fa-trash fs-5'> </i> " +
                            "</span>" +
                            "<div class='btn-group'>" +
                            "<button type='button' class='transparente p-0 btn transparentbar dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>" +
                            "<i class='fas fa-cog text-primary fs-5'></i> <i class='fas fa-chevron-down text-primary'></i>" +
                            "</button>" +
                            "<ul class='dropdown-menu'>" +
                            "<li><a class='dropdown-item' codigo = '" +
                            respuesta["codigoBarras"] +
                            "' precio_normal=' " +
                            respuesta["precio_venta_producto"] +
                            "' style='cursor:pointer; font-size:14px;'>Normal (" +
                            respuesta["precio_venta_producto"] +
                            ")</a></li>" +
                            "<li><a class='dropdown-item' codigo = '" +
                            respuesta["codigoBarras"] +
                            "' precio_normal=' " +
                            respuesta["precioVentaMA"] +
                            "' style='cursor:pointer; font-size:14px;'>Mayoreo (" +
                            parseFloat(respuesta["precioVentaMA"]).toFixed(2) +
                            ")</a></li>" +
                            "</ul>" +
                            "</div>" +
                            "</center>",
                        idProducto: respuesta["idProducto"],
                        stock: respuesta["stock"],
                        precioVentaMA: respuesta["precioVentaMA"],
                        oferta: respuesta["oferta"],
                    })
                    .draw();


                itemProducto = itemProducto + 1;
                recalcularTotales();

            } else {
                toast2.fire({
                  icon: "error",
                  title: "&nbsp;  El producto no existe!",
                });
    
                $("#iptCodigoVenta").val("");
                $("#iptCodigoVenta").focus();
              }
            }
        });
    }

}


function recalcularTotales() {
    var TotalVenta = 0.0;

    table
        .rows()
        .eq(0)
        .each(function (index) {
            var row = table.row(index);
            var data = row.data();
            pruebatotales = parseFloat(TotalVenta) + parseFloat(data["total"].replace("S./ ", ""));
            TotalVenta =
                parseFloat(TotalVenta) + parseFloat(data["total"].replace("S./ ", ""));
        });

    $("#totalCotizacion").html("");
    $("#totalCotizacion").html(TotalVenta.toFixed(2));

    var totalVenta = $("#totalCotizacion").html();
    var subtotal = parseFloat(totalVenta) / 1.18;
    var igv = parseFloat(subtotal) * 0.18;

    var totaltotal = parseFloat(totalVenta);

    $("#totalCotizacionRegistrar").html(totaltotal.toFixed(2));
    $("#subtotal").val(parseFloat(subtotal).toFixed(2));
    $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
    $("#boleta_igv").html(parseFloat(igv).toFixed(2));
    $("#boleta_total").html(parseFloat(totaltotal).toFixed(2));

    $("#iptCodigoCotizacion").val("");
    $("#iptCodigoCotizacion").focus();

}


/* ======================================================================================
    EVENTO PARA AUMENTAR LA CANTIDAD DE UN PRODUCTO DEL LISTADO
    ======================================================================================*/
$("#lstProductosCotizacion tbody").on("click", ".btnAumentarCantidad", function () {
    //$(document).on("click", ".btnAumentarCantidad", function () {
    var data = table.row($(this).parents("tr")).data();
    var TotalVenta = 0.0;
    var codigo_producto = data["codigoBarras"];

    cantidad = parseInt(data["cantidad"]) + 1;

    var idx = table.row($(this).parents("tr")).index();

    table
        .cell(idx, 3)
        .data(cantidad + " Und(s)")
        .draw();

    NuevoPrecio = (
        parseInt(data["cantidad"]) *
        data["precio_venta_producto"].replace("S./ ", "")
    ).toFixed(2);
    NuevoPrecio = "S./ " + NuevoPrecio;
    table.cell(idx, 5).data(NuevoPrecio).draw();
    recalcularTotales();


});

/* ======================================================================================
  EVENTO PARA DESMINUIR LA CANTIDAD DE UN PRODUCTO DEL LISTADO
  ======================================================================================*/
$("#lstProductosCotizacion tbody").on("click", ".btnDisminuirCantidad", function () {
    var data = table.row($(this).parents("tr")).data();
    var TotalVenta = 0.0;
    if (data["cantidad"].replace("Und(s)", "") >= 2) {
        cantidad = parseInt(data["cantidad"].replace("Und(s)", "")) - 1;

        var idx = table.row($(this).parents("tr")).index();

        table
            .cell(idx, 3)
            .data(cantidad + " Und(s)")
            .draw();

        NuevoPrecio = (
            parseInt(data["cantidad"]) *
            data["precio_venta_producto"].replace("S./ ", "")
        ).toFixed(2);
        NuevoPrecio = "S./ " + NuevoPrecio;
        table.cell(idx, 5).data(NuevoPrecio).draw();
    }
    recalcularTotales();

});

/* ======================================================================================
  EVENTO PARA ELIMINAR UN PRODUCTO DEL LISTADO
  ======================================================================================*/
$("#lstProductosCotizacion tbody").on("click", ".btnEliminarproducto", function () {

    table.row($(this).parents("tr")).remove().draw();

    $("#iptCodigoCotizacion").focus();
    recalcularTotales();

});

$("#lstProductosCotizacion tbody").on("click", ".dropdown-item", function () {
    event.preventDefault();
    console.log("precio_normal", $(this).attr("precio_normal"));
    console.log("precio_mayor", $(this).attr("precio_mayor"));
    console.log("precio_oferta", $(this).attr("precio_oferta"));
    console.log("precio_oferta2", $(this).attr("precio_oferta2"));
    console.log("precio_oferta3", $(this).attr("precio_oferta3"));

    codigo_producto = $(this).attr("codigo");

    if ($(this).attr("precio_normal") != null) {
        precio_venta = $(this).attr("precio_normal");
    }
    if ($(this).attr("precio_mayor") != null) {
        precio_venta = $(this).attr("precio_mayor");
    }
    if ($(this).attr("precio_oferta") != null) {
        precio_venta = $(this).attr("precio_oferta");
    }
    if ($(this).attr("precio_oferta2") != null) {
        precio_venta = $(this).attr("precio_oferta2");
    }
    if ($(this).attr("precio_oferta3") != null) {
        precio_venta = $(this).attr("precio_oferta3");
    }
    recalcularMontos(codigo_producto, precio_venta.replaceAll("S./ ", ""));
});


function recalcularMontos(codigo_producto, precio_venta) {
    // alert(codigo_producto);

    table
        .rows()
        .eq(0)
        .each(function (index) {
            var row = table.row(index);

            var data = row.data();

            if (data["codigoBarras"] == codigo_producto) {
                // AUMENTAR EN 1 EL VALOR DE LA CANTIDAD
                table
                    .cell(index, 4)
                    .data("S./ " + parseFloat(precio_venta).toFixed(2))
                    .draw();

                // ACTUALIZAR EL NUEVO PRECIO DEL ITEM DEL LISTADO DE VENTA
                NuevoPrecio = (
                    parseInt(data["cantidad"]) *
                    data["precio_venta_producto"].replace("S./ ", "")
                ).toFixed(2);
                NuevoPrecio = "S./ " + NuevoPrecio;
                table.cell(index, 5).data(NuevoPrecio).draw();

                // RECALCULAMOS TOTALES
            }
        });

    recalcularTotales();
}

function realizarVenta() {
    var count = 0;
    table
        .rows()
        .eq(0)
        .each(function (index) {
            count = count + 1;
        });
    if (count > 0) {


        var igvVenta = $("#boleta_igv").html();
        var totalVenta = $("#boleta_total").html();
        var formData = new FormData();
        var arr = [];
        table
            .rows()
            .eq(0)
            .each(function (index) {
                // var datos = new FormData();

                var row = table.row(index);

                var data = row.data();

                arr[index] =
                    data["idProducto"] +
                    "," +
                    parseFloat(data["cantidad"]) +
                    "," +
                    data["total"].replace("S./ ", "");
                formData.append("arr[]", arr[index]);

            });

        //cDirCli cTelCli cNomCli cNuDoci

        formData.append("cNuDoci", $("#cNuDoci").val());
        formData.append("cNomCli", $("#cNomCli").val());
        formData.append("cTelCli", $("#cTelCli").val());
        formData.append("cDirCli", $("#cDirCli").val());
        formData.append("cTipDoc", idDocalmacen);
        formData.append("cNroDoc", nro_boleta);
        formData.append("cSerie", serie);
        formData.append("nSubTotal", $("#boleta_subtotal").html());
        formData.append("nIgv", igvVenta);
        formData.append("nTotal", parseFloat(totalVenta));

        $.ajax({
            url: rutaOculta + "ajax/cotizacion.ajax.php",
            method: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                loRespuesta = JSON.parse(respuesta);
                if (loRespuesta["codigoError"] == 0) {

                    Swal.fire({
                        position: "center",
                        title: "Se registró la cotizacion correctamente.",
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Imprimir!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            
                            printJS(rutaOculta + "/extensions/libreporte/reportes/cotizacionpdf.php?idCotizacion=" + loRespuesta["idVenta"])
                            /*window.open(
                              rutaOculta+"/extensions/libreporte/reportes/generar_tickerventa.php?idVenta=" +
                              respuesta +
                              "#zoom=100%",
                              "Ticket",
                              "scrollbars=NO"
                            );*/

                        } else {

                        }
                    });

                    table.clear().draw();

                    $("#cNuDoci").val("");
                    $("#cNomCli").val("");
                    $("#cTelCli").val("");
                    $("#totalVenta").html("0.00");
                    $("#boleta_total").html("0.00");
                    $("#boleta_igv").html("0.00");
                    $("#boleta_subtotal").html("0.00");
                    $("#iptCodigoCotizacion").focus();
                    cargarDocumento();
                }
            },
        });

    } else {
        toast2.fire({
            icon: "error",
            title: "&nbsp; No hay productos en el listado.",
        });

        $("#iptCodigoCotizacion").focus();
    }
    $("#iptCodigoCotizacion").focus();

}

function cargarDocumento() {
    $.ajax({
        async: false,
        url: rutaOculta + "ajax/cotizacion.ajax.php",
        method: "POST",
        data: {
            ajaxVerNroBoleta: "ajaxVerNroBoleta",
        },
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta)
            idDocalmacen = respuesta["idDocalmacen"];
            serie = respuesta["Serie"];
            nro_boleta = respuesta["nro_venta"];

            //$("#iptNroSerie").val(respuesta["Serie"]);
            $("#nro_cotizacion").val(respuesta["Serie"] + " - " + respuesta["nro_venta"]);
        },
    });
}

$("#btnIniciarCotizacion").on("click", function () {
    if (validarCamposVacios()) {
        realizarVenta();
    }

});

function validarCamposVacios() {
    var resultado = true;
    
    if ($("#cNuDoci").val() == "") {
        toast2.fire({
            icon: "warning",
            title: "Llenar el campo DNI",
        });

        resultado = false;
    }
    if ($("#cNomCli").val() == "") {
        toast2.fire({
            icon: "warning",
            title: "Llenar el campo NOMBRE CLIENTE",
        });

        resultado = false;
    }
    if ($("#cTelCli").val() == "") {
        toast2.fire({
            icon: "warning",
            title: "Llenar el campo TELEFONO CLIENTE",
        });

        resultado = false;
    }
    if ($("#cDirCli").val() == "") {
        toast2.fire({
            icon: "warning",
            title: "Llenar el campo DIRECCIÓN CLIENTE",
        });

        resultado = false;
    }

    return resultado;

}


$("#cNomCli").on("input", function () {
    var textoFiltrado = $(this).val().replace(/[0-9]/g, ''); // Filtrar números
    $(this).val(textoFiltrado);
});