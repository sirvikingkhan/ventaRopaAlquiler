var rutaOculta = $("#rutaOculta").val();
var table;
var items = [];
var itemProducto = 1;

var idDocalmacen;
var serie;
var nro_boleta;

var simbolom = $("#simbolom").val();
var igvn = $("#igvn").val();
var impuesto = parseFloat(igvn / 100);

var subtotalVenta = $("#subtotal").val();

cargarSelectClientes();
cargarSelectDocumento();
var idAlmacen = $("#idAlmacenV").val();
var idUsuario = $("#idUsuario").val();

var toast2 = Swal.mixin({
  toast: true,
  position: "top",
  showConfirmButton: false,
  timer: 3000,
});

table = $("#lstProductosVenta").DataTable({
  columns: [{
      data: "idProducto",
    },
    {
      data: "codigoBarras",
    },
    {
      data: "descProducto",
    },
    {
      data: "cantidad",
    },
    {
      data: "precio_venta_producto",
    },
    {
      data: "total",
    },
    {
      data: "acciones",
    },
    {
      data: "idProducto",
    },
    {
      data: "stock",
    },
    {
      data: "precioVentaMA",
    },

    {
      data: "oferta",
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

/* ======================================================================================
    TRAER LISTADO DE PRODUCTOS PARA INPUT DE BUSQUEDA
    ======================================================================================*/
$.ajax({
  async: false,
  url: rutaOculta + "ajax/producto.ajax.php",
  method: "POST",
  data: {
    ajaxAutoProductoVenta: "ajaxAutoProductoVenta",
    idAlmacen: idAlmacen,
  },
  dataType: "json",
  success: function (respuesta) {
    for (let i = 0; i < respuesta.length; i++) {
      items.push(respuesta[i]["descripcion_producto"]);
    }
    $("#iptCodigoVenta").autocomplete({
      source: items,
      select: function (event, ui) {
        CargarProductosV(ui.item.value);
        $("#iptCodigoVenta").val("");
        $("#iptCodigoVenta").focus();
        return false;
      },
    });
  },
});

$(document).on("change", "#selDocumentoVenta", function () {
  var Boletas = $(this).val();
  var idAlmacenb = $("#idAlmacenV").val();
  $.ajax({
    async: false,
    url: rutaOculta + "ajax/ventas.ajax.php",
    method: "POST",
    data: {
      ajaxVerNroBoleta: "ajaxVerNroBoleta",
      Documento: Boletas,
      idAlmacen: idAlmacenb,
    },
    dataType: "json",
    success: function (respuesta) {
      idDocalmacen = respuesta["idDocalmacen"];
      serie = respuesta["Serie"];
      nro_boleta = respuesta["nro_venta"];

      $("#iptNroSerie").val(respuesta["Serie"]);
      $("#iptNroVenta").val(respuesta["nro_venta"]);
    },
  });
});

function cargarSelectDocumento() {
  var idAlmacenselect = $("#idAlmacenV").val();
  $.ajax({
    async: false,
    url: rutaOculta + "ajax/ventas.ajax.php",
    method: "POST",
    data: {
      ajaxVerDocumento: "ajaxVerDocumento",
      idAlmacen: idAlmacenselect,
    },
    dataType: "json",
    success: function (respuesta) {
      var options =
        '<option selected value="">Seleccione un Documento</option>';

      for (let index = 0; index < respuesta.length; index++) {
        options =
          options +
          "<option value=" +
          respuesta[index][0] +
          ">" +
          respuesta[index][1] +
          "</option>";
      }

      $("#selDocumentoVenta").append(options);
    },
  });
}

$(".guardarCli").on("click", function () {
  var dni = $(".dni").val(),
    nombres = $(".nombres").val(),
    direccion = $(".direccion").val(),
    telefono = $(".telefono").val(),
    limite_credito = $(".limite_credito").val();

  if (
    dni.length == 0 ||
    nombres.length == 0 ||
    direccion.length == 0 ||
    telefono.length == 0 ||
    limite_credito.length == 0
  ) {
    return Swal.fire(
      "Mensaje De Advertencia",
      "Llene los campos vacios",
      "warning"
    );
  }
  var datos = new FormData();

  datos.append("ajaxRegistrarCliente", "ajaxRegistrarCliente");
  datos.append("dni", dni);
  datos.append("nombres", nombres);
  datos.append("direccion", direccion);
  datos.append("telefono", telefono);
  datos.append("limite_credito", limite_credito);

  $.ajax({
    url: rutaOculta + "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      $("#modalClientes").modal("hide");
      $.ajax({
        async: false,
        url: rutaOculta + "ajax/clientes.ajax.php",
        method: "POST",
        data: {
          ajaxMostrarClienteSelect: "ajaxMostrarClienteSelect",
        },
        dataType: "json",
        success: function (respuesta) {
          for (let index = 1; index < respuesta.length; index++) {
            options =
              "<option selected value=" +
              respuesta[index][0] +
              "> DNI: " +
              respuesta[index][1] +
              " | " +
              respuesta[index][2] +
              "</option>";
            $("#selcredito_usado").val(respuesta[index][6]);
          }

          $("#selCliente").append(options);
        },
      });

      $(".dni").val("");
      $(".nombres").val("");
      $(".direccion").val("");
      $(".telefono").val("");
      $(".limite_credito").val("");

      Swal.fire({
        title: "¡CORRECTO!",
        html: "¡Datos enviados exitosamente!",
        icon: "success",
        timer: 1500,
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading();
          const b = Swal.getHtmlContainer().querySelector("b");
          timerInterval = setInterval(() => {}, 75);
        },
        willClose: () => {
          clearInterval(timerInterval);
        },
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
          console.log("se ha cerrado por el tiempo!");
        }
      });
    },
  });
});

function cargarSelectClientes() {
  $.ajax({
    async: false,
    url: rutaOculta + "ajax/clientes.ajax.php",
    method: "POST",
    data: {
      ajaxMostrarClienteSelect: "ajaxMostrarClienteSelect",
    },
    dataType: "json",
    success: function (respuesta) {
      var options =
        "<option selected value=" +
        respuesta[0]["idCliente"] +
        ">DNI: " +
        respuesta[0]["dni"] +
        " | " +
        respuesta[0]["nombres"] +
        "</option>";
      for (let index = 1; index < respuesta.length; index++) {
        var options =
          options +
          "<option value=" +
          respuesta[index][0] +
          "> DNI: " +
          respuesta[index][1] +
          " | " +
          respuesta[index][2] +
          "</option>";
      }

      $("#selCliente").append(options);
    },
  });
}

var clienteSelectG;

function cargarClienteCreditoU(idCliente) {
  $.ajax({
    async: false,
    url: rutaOculta + "ajax/clientes.ajax.php",
    method: "POST",
    data: {
      ajaxMostrarCliente: "ajaxMostrarCliente",
      idCliente: idCliente,
    },
    dataType: "json",
    success: function (respuesta) {
      $("#iptCreditoDis").val(respuesta["credito_usado"]);
    },
  });
}

$(document).on("change", "#selCliente", function () {
  var idCliente = $(this).val();

  clienteSelectG = idCliente;

  $.ajax({
    async: false,
    url: rutaOculta + "ajax/clientes.ajax.php",
    method: "POST",
    data: {
      ajaxMostrarCliente: "ajaxMostrarCliente",
      idCliente: idCliente,
    },
    dataType: "json",
    success: function (respuesta) {
      //$("#selcredito_usado").val(respuesta["credito_usado"]);
    },
  });
});

$(".dni").change(function () {
  var dni = $(this).val();
  ValidarDni(dni);
  TraerDni(dni);
});

function ValidarDni(dni) {
  var datos = new FormData();
  datos.append("ajaxValidarDni", dni);

  $.ajax({
    url: rutaOculta + "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta) {
        toast2.fire({
          icon: "warning",
          title: "&nbsp;&nbsp;  Este dni ya existe en la base de datos!",
        });
        $(".dni").val("");
      }
    },
  });
}

function TraerDni(dni) {
  $.ajax({
    type: "POST",
    url: rutaOculta + "ajax/consultadni.ajax.php",
    data: "dni=" + dni,
    dataType: "json",
    success: function (data) {
      if (data == 1) {
        alert("El dni tiene que tener 8 digitos");
      } else {
        $(".nombres").val(
          MaysPrimera(data.nombres.toLowerCase()) +
          " " +
          MaysPrimera(data.apellidoPaterno.toLowerCase()) +
          " " +
          MaysPrimera(data.apellidoMaterno.toLowerCase())
        );
        //$(".apellidos").val();
      }
    },
  });
}

function MaysPrimera(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

/* ======================================================================================
    EVENTO PARA ELIMINAR UN PRODUCTO DEL LISTADO
    ======================================================================================*/
$("#lstProductosVenta tbody").on("click", ".btnEliminarproducto", function () {
  table.row($(this).parents("tr")).remove().draw();

  $("#iptCodigoVenta").focus();
  recalcularTotales();
});

$("#lstProductosVenta tbody").on("click", ".dropdown-item", function () {
  event.preventDefault();

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
  recalcularMontos(codigo_producto, precio_venta.replaceAll(simbolom, ""));
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
        cantidad_actual = parseFloat($.parseHTML(data["cantidad"])[0]["value"]);

        // AUMENTAR EN 1 EL VALOR DE LA CANTIDAD
        table
          .cell(index, 4)
          .data(simbolom + parseFloat(precio_venta).toFixed(2))
          .draw();

        // ACTUALIZAR EL NUEVO PRECIO DEL ITEM DEL LISTADO DE VENTA
        NuevoPrecio = (
          parseInt(cantidad_actual) *
          data["precio_venta_producto"].replace(simbolom, "")
        ).toFixed(2);
        NuevoPrecio = simbolom + NuevoPrecio;
        table.cell(index, 5).data(NuevoPrecio).draw();

        // RECALCULAMOS TOTALES
      }
    });

  recalcularTotales();
}

function redondear(numero, decimales) {
  if (typeof numero != "number" || typeof decimales != "number") {
    return null;
  }

  let signo = numero >= 0 ? 1 : -1;

  return (
    Math.round(numero * Math.pow(10, decimales) + signo * 0.0001) /
    Math.pow(10, decimales)
  ).toFixed(decimales);
}

var pruebatotales;

function recalcularTotales() {
  var TotalVenta = 0.0;

  table
    .rows()
    .eq(0)
    .each(function (index) {
      var row = table.row(index);
      var data = row.data();
      pruebatotales =
        parseFloat(TotalVenta) +
        parseFloat(data["total"].replace(simbolom, ""));
      TotalVenta =
        parseFloat(TotalVenta) +
        parseFloat(data["total"].replace(simbolom, ""));
    });

  $("#totalVenta").html("");
  $("#totalVenta").html(parseFloat(redondear(TotalVenta, 1)).toFixed(2));

  var deliverys = $("#iptDelivery").val();
  var descuento = $("#iptDescuento").val();
  var totalVenta = $("#totalVenta").html();
  var igv = parseFloat(totalVenta) * impuesto;
  var subtotal = parseFloat(totalVenta) - parseFloat(igv);

  var totaltotal =
    parseFloat(totalVenta) + parseFloat(deliverys) - parseFloat(descuento);
  //var igv = parseFloat(totaltotal) * impuesto;
  //var subtotal = parseFloat(totaltotal) - parseFloat(igv);

  $("#totalVentaRegistrar").html(totaltotal.toFixed(2));
  $("#subtotal").val(parseFloat(subtotal).toFixed(2));
  $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
  $("#boleta_igv").html(parseFloat(igv).toFixed(2));

  //console.log(parseFloat(redondear(66.56, 1)).toFixed(2));

  $("#boleta_total").html(parseFloat(redondear(totaltotal, 1)).toFixed(2));

  $("#iptCodigoVenta").val("");
  $("#iptCodigoVenta").focus();
}

$("#chkDeliveryExacto").change(function () {
  // alert($("#chkEfectivoExacto").is(':checked'))

  if ($("#chkDeliveryExacto").is(":checked")) {
    $(".deliveryaparece").html(
      '<input type="number" min="0" name="iptDelivery" id="iptDelivery" class="form-control form-control-sm"  value="0"placeholder="Monto delivery recibido"> <br>'
    );
  } else {
    $(".deliveryaparece").html(
      '<input id="iptDelivery" type="hidden" value = "0" >'
    );
  }
  recalcularTotales();
});

$(document).on("change", "#iptDelivery", function () {
  recalcularTotales();
});

$("#chkDescuentoExacto").change(function () {
  // alert($("#chkEfectivoExacto").is(':checked'))

  if ($("#chkDescuentoExacto").is(":checked")) {
    $(".descuentoaparece").html(
      '<input type="number" min="0" name="iptDescuento" id="iptDescuento" class="form-control form-control-sm"  value="0"placeholder="Monto delivery recibido"> <br>'
    );
  } else {
    $(".descuentoaparece").html(
      '<input id="iptDescuento" type="hidden" value = "0" >'
    );
  }
  recalcularTotales();
});

$(document).on("change", "#iptDescuento", function () {
  recalcularTotales();
});

//17/06/2022

function realizarVenta() {
  var count = 0;

  var igvVenta = $("#boleta_igv").html();

  var totalVenta = $("#boleta_total").html();
  var selCliente = $("#selCliente").val();

  var delivery = $("#iptDelivery").val();
  var descuento = $("#iptDescuento").val();

  table
    .rows()
    .eq(0)
    .each(function (index) {
      count = count + 1;
    });

  if (count > 0) {
    var formData = new FormData();
    var arr = [];

    table
      .rows()
      .eq(0)
      .each(function (index) {
        var row = table.row(index);

        var data = row.data();

        arr[index] =
          data["codigoBarras"] +
          "," +
          parseFloat($.parseHTML(data["cantidad"])[0]["value"]) +
          "," +
          data["total"].replace(simbolom, "") +
          "," +
          data["idProducto"] +
          "," +
          data["stock"];
        formData.append("arr[]", arr[index]);
      });

    formData.append("idCliente", selCliente);
    formData.append("idAlmacen", idAlmacen);
    formData.append("idUsuario", idUsuario);
    formData.append("idDocalmacen", idDocalmacen);
    formData.append("serie", serie);
    formData.append("nro_comprobante", nro_boleta);
    formData.append("descripcion", "Venta realizada con Nro: " + nro_boleta);
    formData.append("subtotal", $("#subtotal").val());
    formData.append("igv", igvVenta);
    formData.append("delivery", delivery);
    formData.append("descuento", descuento);
    formData.append("total_venta", parseFloat(totalVenta));
    formData.append("listaMetodoPagoVenta", listaMetodoPagoVenta);

    $.ajax({
      url: rutaOculta + "ajax/ventas.ajax.php",
      method: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        loRespuesta = JSON.parse(respuesta);

        if (loRespuesta["codigoError"] == 1) {
          toast2.fire({
            icon: "error",
            title: loRespuesta["mensajeError"],
          });
        } else {
          Swal.fire({
            position: "center",
            title: "Se registró la venta correctamente.",
            icon: "success",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Imprimir!",
          }).then((result) => {
            if (result.isConfirmed) {
              printJS(
                rutaOculta +
                "/extensions/libreporte/reportes/generar_tickerventa.php?idVenta=" +
                loRespuesta["mensajeModel"]
              );
            } else {}
          });

          table.clear().draw();
          traerNotificacionBajoInv();
          reiniciarDespuesVenta();
          //cargarSelectDocumento();
        }
      },
    });
  } else {
    toast2.fire({
      icon: "error",
      title: "&nbsp; No hay productos en el listado.",
    });

    $("#iptCodigoVenta").focus();
  }
  items = [];
  $("#iptCodigoVenta").focus();
}
//})

function validarDatosVenta() {
  var resultado = true;

  if ($("#selDocumentoVenta").val() == "") {
    toast2.fire({
      icon: "warning",
      title: "&nbsp; seleccione un documento",
    });

    resultado = false;
    return;
  }

  if ($("#boleta_total").html() == 0.0) {
    toast2.fire({
      icon: "warning",
      title: "El monto de la venta es de 0, no puede continuar.",
    });

    resultado = false;
  }

  /*if ($("#iptCreditoDis").val() < parseFloat(totalVenta)) {
    toast2.fire({
      icon: "warning",
      title: "El total no debe exceder al credito establecido",
    });

    resultado = false;
  }*/

  return resultado;
}

function reiniciarDespuesVenta() {
  $("#selDocumentoVenta").val("");
  $("#selTipoPago").val("");

  $("#selCliente").val("1").trigger("change");

  $("#iptNroSerie").val("");
  $("#iptNroVenta").val("");
  $("#totalVenta").html("0.00");
  $("#totalVentaRegistrar").html("0.00");
  $("#boleta_total").html("0.00");
  $("#boleta_igv").html("0.00");
  $("#boleta_subtotal").html("0.00");
  $("#subtotal").val("0.00");
  $("#comision_bol").html("0.00");

  $("#iptTransaccion").val("");
  $("#nroContacto").val("");
  $("#iptYape").val("");

  $("#iptEfectivoRecibido").val("");
  $("#EfectivoEntregado").html("0.00");
  $("#Vuelto").html("0.00");
  $("#chkEfectivoExacto").prop("checked", false);
  $("#chkDeliveryExacto").prop("checked", false);
  $("#chkDescuentoExacto").prop("checked", false);
  $(".deliveryaparece").html(
    '<input id="iptDelivery" type="hidden" value = "0" >'
  );
  $(".descuentoaparece").html(
    '<input id="iptDescuento" type="hidden" value = "0" >'
  );
  $("#iptCodigoVenta").focus();
}

$(document).ready(function () {
  function CargaNroBoletaValidate() {
    var Boletas = $("#selDocumentoVenta").val();
    var idAlmacenb = $("#idAlmacenV").val();
    $.ajax({
      async: false,
      url: rutaOculta + "ajax/ventas.ajax.php",
      method: "POST",
      data: {
        ajaxVerNroBoleta: "ajaxVerNroBoleta",
        Documento: Boletas,
        idAlmacen: idAlmacenb,
      },
      dataType: "json",
      success: function (respuesta) {
        // console.log(respuesta["idDocalmacen"])
        idDocalmacen = respuesta["idDocalmacen"];
        serie = respuesta["Serie"];
        nro_boleta = respuesta["nro_venta"];

        $("#iptNroSerie").val(respuesta["Serie"]);
        $("#iptNroVenta").val(respuesta["nro_venta"]);
      },
    });
  }

  /*setInterval(function () {
    CargaNroBoletaValidate();
  }, 1000);*/
});

//verificar que acepte letras y numeros en su codigo de barras
$("#btnVaciarListado").on("click", function () {
  VaciarListado();
});

function VaciarListado() {
  table.clear().draw();
  LimpiarInputs();
}

function LimpiarInputs() {
  $("#totalVenta").html("0.00");
  $("#totalVentaRegistrar").html("0.00");
  $("#boleta_total").html("0.00");
  $("#iptEfectivoRecibido").val("");
  $("#EfectivoEntregado").html("0.00");
  $("#boleta_subtotal").html("0.00");
  $("#subtotal").val("0.00");

  $("#boleta_igv").html("0.00");
  $("#Vuelto").html("0.00");
  $("#chkEfectivoExacto").prop("checked", false);
}

/* ======================================================================================
    EVENTO QUE REGISTRA EL PRODUCTO EN EL LISTADO CUANDO SE INGRESA EL CODIGO DE BARRAS
    ======================================================================================*/
$("#iptCodigoVenta").change(function () {
  CargarProductosV();
  $("#iptCodigoVenta").val("");
  $("#iptCodigoVenta").focus();
});

function CargarProductosV(producto = "") {
  if (producto != "") {
    var codigo_producto = producto;
  } else {
    var codigo_producto = $("#iptCodigoVenta").val();
  }
  codigo_producto = $.trim(codigo_producto.split("-")[0]);
  var producto_repetido = 0;
  // VERIFICAMOS QUE EL PRODUCTO TENGA STOCK
  table
    .rows()
    .eq(0)
    .each(function (index) {
      var row = table.row(index);

      var data = row.data();

      if (parseInt(codigo_producto) == data["codigoBarras"]) {
        producto_repetido = 1;
        cantidad_a_comprar =
          parseFloat($.parseHTML(data["cantidad"])[0]["value"]) + 1;

        $.ajax({
          async: false,
          url: rutaOculta + "ajax/producto.ajax.php",
          method: "POST",
          data: {
            ajaxVerificarStock: "ajaxVerificarStock",
            codigo_producto: codigo_producto,
            cantidad_a_comprar: cantidad_a_comprar,
            idAlmacen: idAlmacen,
          },

          dataType: "json",
          success: function (respuesta) {
            if (parseInt(respuesta["existe"]) == 0) {
              // alert('entro')

              toast2.fire({
                icon: "error",
                title: "&nbsp;  El producto " +
                  "'" + data["descProducto"] + "'" +
                  " ya no tiene stock <br>" +
                  " Solo cuenta con " + respuesta["stock_actual"] + " de stock!",
              });

              $("#iptCodigoVenta").val("");
              $("#iptCodigoVenta").focus();
            } else {
              table
                .cell(index, 3)
                .data(
                  '<input type="text" style="width:80px;" codigoProducto = "' +
                  codigo_producto +
                  '" class="form-control text-center iptCantidad m-0 p-0" value="' +
                  cantidad_a_comprar +
                  '">'
                )
                .draw();

              // ACTUALIZAR EL NUEVO PRECIO DEL ITEM DEL LISTADO DE VENTA
              NuevoPrecio = (
                parseFloat(cantidad_a_comprar) *
                data["precio_venta_producto"].replaceAll(simbolom, "")
              ).toFixed(2);
              NuevoPrecio = simbolom + NuevoPrecio;
              table.cell(index, 5).data(NuevoPrecio).draw();

              // RECALCULAMOS TOTALES
              recalcularTotales();
            }
          },
        });
      }
    });

  if (producto_repetido == 1) {
    return;
  }

  $.ajax({
    url: rutaOculta + "ajax/producto.ajax.php",
    method: "POST",
    data: {
      ajaxGestorProductoV: "ajaxGestorProductoV",
      codigo_producto: codigo_producto,
      idAlmacen: idAlmacen,
    },

    dataType: "json",
    success: function (respuesta) {
      if (respuesta) {
        var TotalVenta = 0.0;

        table.row
          .add({
            idProducto: itemProducto,
            codigoBarras: respuesta["codigoBarras"],
            descProducto: respuesta["descProducto"],
            cantidad: '<input type="text" style="width:80px;" codigoProducto = "' +
              respuesta["codigoBarras"] +
              '" class="form-control  text-center iptCantidad p-0 m-0" value="1">',
            precio_venta_producto: respuesta["precio_venta_producto"],
            total: respuesta["total"],
            acciones: "<center>" +
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
              "' precio_mayor=' " +
              respuesta["precioVentaMA"] +
              "' style='cursor:pointer; font-size:14px;'>Mayoreo (S./ " +
              parseFloat(respuesta["precioVentaMA"]).toFixed(2) +
              ")</a></li>" +
              "<li><a class='dropdown-item' codigo = '" +
              respuesta["codigoBarras"] +
              "' precio_oferta2=' " +
              respuesta["oferta"] +
              "' style='cursor:pointer; font-size:14px;'>Oferta (S./ " +
              parseFloat(respuesta["oferta"]).toFixed(2) +
              ")</a></li>" +
              //"<li><a class='dropdown-item' codigo = '" + respuesta['codigoBarras'] + "' precio_oferta3=' " + respuesta['ofertaDNI'] + "' style='cursor:pointer; font-size:14px;'>Oferta DNI (S./ " + parseFloat(respuesta['ofertaDNI']).toFixed(2) + ")</a></li>" +
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
          title: "&nbsp;  El producto no existe o no tiene stock",
        });

        $("#iptCodigoVenta").val("");
        $("#iptCodigoVenta").focus();
      }
    },
  });
}

/* ======================================================================================
        EVENTO PARA MODIFICAR LA CANTIDAD DE PRODUCTOS A COMPRAR
        ======================================================================================*/
$("#lstProductosVenta tbody").on("change", ".iptCantidad", function () {
  var data = table.row($(this).parents("tr")).data();

  cantidad_actual = $(this)[0]["value"];
  cod_producto_actual = $(this)[0]["attributes"][2]["value"];

  if (!$.isNumeric($(this)[0]["value"]) || $(this)[0]["value"] <= 0) {
    toast2.fire({
      icon: "error",
      title: "INGRESE UN VALOR NUMERICO Y MAYOR A 0",
    });

    $(this)[0]["value"] = "1";

    $("#iptCodigoVenta").val("");
    $("#iptCodigoVenta").focus();
    return;
  }

  table
    .rows()
    .eq(0)
    .each(function (index) {
      var row = table.row(index);

      var data = row.data();

      if (data["codigoBarras"] == cod_producto_actual) {
        $.ajax({
          async: false,
          url: rutaOculta + "ajax/producto.ajax.php",
          method: "POST",

          data: {
            ajaxVerificarStock: "ajaxVerificarStock",
            codigo_producto: cod_producto_actual,
            cantidad_a_comprar: cantidad_actual,
            idAlmacen: idAlmacen,
          },
          dataType: "json",
          success: function (respuesta) {
            if (parseInt(respuesta["existe"]) == 0) {
              toast2.fire({
                icon: "error",
                title: "&nbsp;  El producto " +
                  "'" + data["descProducto"] + "'" +
                  " ya no tiene stock <br>" +
                  " Solo cuenta con " + respuesta["stock_actual"] + " de stock!",
              });

              table
                .cell(index, 3)
                .data(
                  '<input type="text" style="width:80px;" codigoProducto = "' +
                  cod_producto_actual +
                  '" class="form-control text-center iptCantidad m-0 p-0" value="1">'
                )
                .draw();

              $("#iptCodigoVenta").val("");
              $("#iptCodigoVenta").focus();

              // ACTUALIZAR EL NUEVO PRECIO DEL ITEM DEL LISTADO DE VENTA
              NuevoPrecio = (
                parseFloat(1) *
                data["precio_venta_producto"].replaceAll(simbolom, "")
              ).toFixed(2);
              NuevoPrecio = simbolom + NuevoPrecio;
              table.cell(index, 5).data(NuevoPrecio).draw();

              // RECALCULAMOS TOTALES
              recalcularTotales();
            } else {
              // AUMENTAR EN 1 EL VALOR DE LA CANTIDAD
              table
                .cell(index, 3)
                .data(
                  '<input type="text" style="width:80px;" codigoProducto = "' +
                  cod_producto_actual +
                  '" class="form-control text-center iptCantidad m-0 p-0" value="' +
                  cantidad_actual +
                  '">'
                )
                .draw();

              // ACTUALIZAR EL NUEVO PRECIO DEL ITEM DEL LISTADO DE VENTA
              NuevoPrecio = (
                parseFloat(cantidad_actual) *
                data["precio_venta_producto"].replaceAll(simbolom, "")
              ).toFixed(2);
              NuevoPrecio = simbolom + NuevoPrecio;
              table.cell(index, 5).data(NuevoPrecio).draw();

              // RECALCULAMOS TOTALES
              recalcularTotales();
            }
          },
        });
      }
    });
});

$(document).on("click", "#btnEntradaDinero", function () {
  $("#tipo").val("Ingreso");
  $(".modal-header").removeClass("bg-red");
  $(".modal-header").addClass("bg-success");
});

$(document).on("click", "#btnSalidadaDinero", function () {
  $("#tipo").val("Egreso");
  $(".modal-header").removeClass("bg-success");
  $(".modal-header").addClass("bg-red");
});

function realizarIngresoEgreso() {

  var tipo = $("#tipo").val();
  var descripcion = $("#descripcion").val();
  var monto = $("#monto").val();

  var texto = "";
  var text2 = "";

  if (tipo == "Ingreso") {
    texto = "¿Está seguro de realizar un ingreso a caja?";
    text2 = "Se realizo el ingreso correctamente.";
  } else {
    texto = "¿Está seguro de realizar un egreso a caja?";
    text2 = "Se realizo el Egreso correctamente.";
  }

  Swal.fire({
    title: texto,
    text: "¡Si no lo está puede cancelar la acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
  }).then((result) => {
    if (result.isConfirmed) {
      var datos = new FormData();
      datos.append("ajaxGuardarDetalle", "ajaxGuardarDetalle");
      datos.append("tipo", tipo);
      datos.append("descripcion", descripcion);
      datos.append("monto", monto);
      //datos.append("idUsuario", idUsuario);
      $.ajax({
        url: rutaOculta + "ajax/caja.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          loRespuesta = JSON.parse(respuesta);

          if (loRespuesta["codigoError"] == 1) {
            toast2.fire({
              icon: "error",
              title: loRespuesta["mensajeError"],
            });
          } else {

            let timerInterval;
            Swal.fire({
              title: "¡CORRECTO!",
              html: text2,
              icon: "success",
              timer: 1500,
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector("b");
                timerInterval = setInterval(() => {}, 75);
              },
              willClose: () => {
                clearInterval(timerInterval);
              },
            }).then((result) => {
              if (result.dismiss === Swal.DismissReason.timer) {
                console.log("se ha cerrado por el tiempo!");
              }
            });
            $("#mdlGestionarCajaV").modal("hide");
          }
        },
      });
    }
  });

}

$(document).on("click", ".btnGuardarCaja", function () {
  realizarIngresoEgreso();
});

var maxRows = 3; // Máximo número de filas permitidas
var currentRows = 0; // Contador actual de filas

$(document).on("click", ".agregarMetodoPago", function () {
  if (currentRows < maxRows) {
    var contenidoHTML = `
                          <div class="row eliminarMetodoSecundarios" style="margin-bottom:-18px;">

                                <div class="col-sm-6" style="padding-right: 0px">
                                    <div class="input-group">

                                        <label class="col-form-label" for="selCategoriaReg">
                                            <span class="small">Metodo de Pago</span><span class="text-danger">*</span></label>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-money-bill"></i></span>
                                            </div>
                                            <select class="form-control  form-control-sm metodoPago" name="metodoPago" required>
                                                <option value="" selected="true">Seleccione Tipo Pago</option>
                                                <option value="Efectivo">Efectivo</option>
                                                <option value="Tarjeta">Tarjeta</option>
                                                <option value="Transferencia">Transferencia</option>
                                                <option value="Yape">Yape</option>
                                                <option value="Plin">Plin</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-3 ingresoPrecio">
                                    <label class="col-form-label" for="selCategoriaReg">
                                        <span class="small">Monto</span><span class="text-danger">*</span></label>

                                    <div class="input-group input-group-sm mb-3">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/. </span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm montoPagar" name="montoPagar" required>
                                    </div>

                                </div>

                                <div class="col-sm-3 ingresoCantidad">
                                    <label class="col-form-label" for="selCategoriaReg">
                                        <span class="small">Nro. Operación</span></label>

                                    <input type="number" class="form-control form-control-sm nroOperacion" name="nroOperacion">
                                </div>


                            </div>`;
    currentRows++;
    $(".cajaMetodoPago").append(contenidoHTML);

    if (currentRows === maxRows) {
      $(this).prop("disabled", true); // Deshabilitar el botón después de alcanzar el límite
    }
  }
});
var selectedMethods = {}; // Objeto para llevar el seguimiento de los métodos seleccionados

$(document).on("click", ".quitarMetodoPago", function () {
  var lastRow = $(".cajaMetodoPago").children(".row").last();
  var rowIndex = lastRow.index(); // Obtener el índice de la fila
  if (lastRow.hasClass("eliminarMetodoSecundarios")) {
    lastRow.remove();
    currentRows--;
    delete selectedMethods[rowIndex]; // Eliminar el método de pago seleccionado en esta fila

    $(".agregarMetodoPago").prop("disabled", false); // Habilitar el botón después de eliminar una fila
  }
});

$(document).on("change", ".metodoPago", function () {
  var selectedMethod = $(this).val(); // Método de pago seleccionado en el cambio
  var rowIndex = $(this).closest(".row").index(); // Índice de la fila en la que se realizó el cambio

  if (selectedMethod !== "") {
    // Verificar si el método de pago ya ha sido seleccionado en otra fila
    if (
      Object.values(selectedMethods).includes(selectedMethod) &&
      selectedMethods[rowIndex] !== selectedMethod
    ) {
      toast2.fire({
        icon: "warning",
        title: "Este método de pago ya ha sido seleccionado.",
      });
      $(this).val(""); // Reiniciar la selección del método
    } else {
      selectedMethods[rowIndex] = selectedMethod; // Marcar el método como seleccionado en esta fila
    }
  } else {
    delete selectedMethods[rowIndex]; // Eliminar el método de pago seleccionado en esta fila
  }
});

var listaMetodoPagoVenta;

$(document).on("click", ".guardarPago", function () {
  var listaMetodosPago = [];
  var valid = true;
  var validar = true;
  var totalVenta = parseFloat($("#boleta_total").html());
  var totalMetodosPago = 0;

  $(".metodoPago").each(function () {
    var metodoPago = $(this).val();
    var monto = $(this).closest(".row").find(".montoPagar").val();
    var montoPrincipal = $(".montoPagar").val();
    var nroOperacion = $(this).closest(".row").find(".nroOperacion").val();

    if (metodoPago === "" || monto === "") {
      valid = false;
    }

    listaMetodosPago.push({
      metodoPago: metodoPago,
      monto: monto,
      nroOperacion: nroOperacion,
    });

    if (
      listaMetodosPago.length === 1 &&
      listaMetodosPago[0].metodoPago === "Efectivo"
    ) {
      if (montoPrincipal < parseFloat(totalVenta)) {
        validar = false; // Establecer "valid" como falso para detener el proceso
      }
      listaMetodosPago[0].monto = totalVenta; // Actualizar el monto al totalVenta
    } else {
      listaMetodosPago[0].monto = montoPrincipal;
      validar = true;
    }
  });

  if (valid) {
    if (!validar) {
      toast2.fire({
        icon: "warning",
        title: "El efectivo es menor al costo total de la venta",
      });
    } else {
      if (totalVenta === 0) {
        toast2.fire({
          icon: "warning",
          title: "El monto total de la venta es 0. No se puede continuar.",
        });

        return;
      }

      // Sumamos los montos de la lista de métodos de pago
      for (var i = 0; i < listaMetodosPago.length; i++) {
        var montoMetodoPago = parseFloat(listaMetodosPago[i].monto);
        if (!isNaN(montoMetodoPago)) {
          totalMetodosPago += montoMetodoPago;
        }
      }

      if (totalMetodosPago !== totalVenta) {
        toast2.fire({
          icon: "warning",
          title: "La suma de los montos de los métodos de pago no coincide con el monto total de la venta.",
        });

        return;
      }

      listaMetodoPagoVenta = JSON.stringify(listaMetodosPago);
      realizarVenta();
      $("#modal_pagar").modal("hide");
      $(".eliminarMetodoSecundarios").remove();
      $(".metodoPago").val("");
      $(".montoPagar").val("");
      $(".nroOperacion").val("");
    }
  } else {
    toast2.fire({
      icon: "warning",
      title: "Por favor complete todos los campos",
    });
  }
});

$(document).on("keyup", ".montoPagar", function () {
  var totalVenta = $("#boleta_total").html();
  var metodoPago = $(this).closest(".row").find(".metodoPago").val();
  var cantidadMetodosPago = $(".metodoPago").length; // Contar la cantidad de métodos de pago

  if (metodoPago === "Efectivo") {
    var montoPagar = parseFloat($(this).val());

    if (!isNaN(montoPagar) && montoPagar >= 0) {
      // Verificar si es efectivo y solo hay un método de pago
      if (cantidadMetodosPago === 1) {
        var vuelto = montoPagar - parseFloat(totalVenta);
        $(".Vuelto").val(vuelto.toFixed(2));
      } else {
        $(".Vuelto").val("0.00"); // No calcular vuelto si hay más de un método de pago
      }
    } else {
      $(".Vuelto").val("0.00");
    }
  } else {
    $(".Vuelto").val("0.00");
  }
});

$("#btnIniciarPago").on("click", function () {
  var totalVenta = $("#boleta_total").html(); // Obtener el valor de boleta_total

  $(".totalPagarModal").val(totalVenta);

  if (validarDatosVenta()) {
    $("#modal_pagar").modal("show");
  }
});

$("#checkDescuento").change(function () {
  if ($(this).is(":checked")) {
    $(".totalDescuento").prop("disabled", false);
    $(".descDescuento").prop("disabled", false);
  } else {
    $(".totalDescuento").prop("disabled", true);
    $(".totalDescuento").val("0.00");
    $(".descDescuento").prop("disabled", true);
    $(".descDescuento").val("");
  }
});