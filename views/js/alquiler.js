var controlt = $("#controlt").val();
var rutaOculta = $("#rutaOculta").val();
var idAlmacenAlquiler = $("#idAlmacenAlquiler").val();
var tablaReparacion;

cargarSelectAlmacen();
cargarSelectClientes();
horaInput();

$("#idAlmacenAlquiler").change(function () {
  var changeAlmacen = $(this).val();
  idAlmacenAlquiler = changeAlmacen;
  cargarProductosAlquiler();
  $("#iptCodigoRopaAlq").val("");
  tableProductoAlquiler.clear().draw();
  recalcularMontos();
  iniciarTablaAlquilerDet(filtro_desde, filtro_hasta);
});

function horaInput() {
  var fecha = new Date(); //Fecha actual
  var mes = fecha.getMonth() + 1; //obteniendo mes
  var dia = fecha.getDate(); //obteniendo dia
  var ano = fecha.getFullYear(); //obteniendo año
  if (dia < 10) dia = "0" + dia; //agrega cero si el menor de 10
  if (mes < 10) mes = "0" + mes; //agrega cero si el menor de 10
  document.getElementById("fecha_entrega").value = ano + "-" + mes + "-" + dia;
  document.getElementById("fecha_entrega").min = ano + "-" + mes + "-" + dia;
  document.getElementById("fecha_devolucion").min = ano + "-" + mes + "-" + dia;
  document.getElementById("filtro_desde").value = ano + "-" + mes + "-" + dia;
  document.getElementById("filtro_hasta").value = ano + "-" + mes + "-" + dia;
}

filtro_desde = $("#filtro_desde").val();
filtro_hasta = $("#filtro_hasta").val();

var toast2 = Swal.mixin({
  toast: true,
  position: "top",
  showConfirmButton: false,
  timer: 3000,
});

function cargarSelectAlmacen() {
  if (controlt == 1) {
    $.ajax({
      async: false,
      url: "ajax/almacen.ajax.php",
      method: "POST",
      data: {
        ajaxAlmacenS: "ajaxAlmacenS",
      },
      dataType: "json",
      success: function (respuesta) {
        var options = ""; // Inicializa sin la opción "Seleccione Sede"
        for (let index = 0; index < respuesta.length; index++) {
          var selected = index === 0 ? "selected" : ""; // Añade 'selected' a la primera opción
          options += `<option value="${respuesta[index][0]}" ${selected}>${respuesta[index][3]}</option>`;
        }

        $("#idAlmacenAlquiler").html(options);
       // $(".idAlmacen").html(options);

        idAlmacenAlquiler = $("#idAlmacenAlquiler").val();
      },
    });
  } else {
    $("#idAlmacenAlquiler").html("");
   // $(".idAlmacen").html("");
  }
}

function cargarSelectClientes() {
  $.ajax({
    async: false,
    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: {
      ajaxMostrarClienteSelect: "ajaxMostrarClienteSelect",
    },
    dataType: "json",
    success: function (respuesta) {
      var options = '<option selected value="">Seleccione Cliente</option>';
      for (let index = 0; index < respuesta.length; index++) {
        options =
          options +
          "<option value=" +
          respuesta[index][0] +
          ">" +
          respuesta[index][1] +
          " | " +
          respuesta[index][2];
        ("</option>");
      }

      $("#idCliente").html(options);
    },
  });
}


//#region Informacion y guardado de Clientes
function informacionCliente(idCliente) {
  var datos = new FormData();
  datos.append("idCliente", idCliente);
  datos.append("ajaxMostrarCliente", "ajaxMostrarCliente");

  $.ajax({
    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      //$(".idAlumno").val(idAlumno);
      $("#nombres").val(respuesta["nombres"]);
      $("#dni").val(respuesta["dni"]);
      $("#direccion").val(respuesta["direccion"]);
      $("#celular").val(respuesta["telefono"]);
      //$("#correo").val(respuesta["email"]);
    },
  });
}

$("#idCliente").change(function () {
  var idCliente = $(this).val();
  informacionCliente(idCliente);
});

$("#ClienteCancelar").click(function () {
  $("#idCliente").val("").trigger("change");
  informacionCliente("");
});

//GUARDADO DE CLIENTES

$("#modalClientes").on("show.bs.modal", function (event) {
  $(".modal-header").css("color", "white");
  $(".modal-title").text("Agregar Cliente");

  //$(".guardarCli").show();
  //$(".editarCli").hide();
  //$("#tipoDocumento").removeAttr("disabled");
  //$("#tipoDocumento").val("");
  $(".dni").removeAttr("disabled");
  $(".dni").val("");
  $(".nombres").val("");
  $(".direccion").val("");
  $(".telefono").val("");
});

$(".guardarCli").on("click", function () {
  var 
    dni = $(".dni").val(),
    nombres = $(".nombres").val(),
    direccion = $(".direccion").val(),
    telefono = $(".telefono").val(),
    limite_credito = $(".limite_credito").val();


    var datos = new FormData();
    datos.append("ajaxRegistrarCliente", "ajaxRegistrarCliente");
    datos.append("dni", dni);
    datos.append("nombres", nombres);
    datos.append("direccion", direccion);
    datos.append("telefono", telefono);
    datos.append("limite_credito", limite_credito);

    $.ajax({
    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
        // Restablecer formulario
        $(".dni").val("");
        $(".nombres").val("");
        $(".direccion").val("");
        $(".telefono").val("");
        

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

        $.ajax({
        async: false,
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: {
            ajaxMostrarClienteSelect: "ajaxMostrarClienteSelect",
        },
        dataType: "json",
        success: function (respuesta) {
            for (let index = 0; index < respuesta.length; index++) {
            options =
                "<option value=" +
                respuesta[index][0] +
                ">" +
                respuesta[index][1] +
                " | " +
                respuesta[index][2] +
                "</option>";
            }
            $("#idCliente").append(options);
            // Selecciona automáticamente la última opción
            var lastIndex = respuesta.length - 1;
            $("#idCliente").val(respuesta[lastIndex][0]);
            informacionCliente(respuesta[lastIndex][0]);
        },
        });
        cerrarModal("#modalClientes");
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
    url: "ajax/clientes.ajax.php",
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
    url: "ajax/consultadni.ajax.php",
    data: "dni=" + dni,
    dataType: "json",
    success: function (data) {
      if (data == 1) {
        alert("El dni tiene que tener 8 digitos");
      } else {
        console.log(data);
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


//#endregion

//#region Reparacion Venta Repuesto

var tableProductoAlquiler;
var items = [];
var itemProducto = 1;
var simbolom = $("#simbolom").val();

tableProductoAlquiler = $("#lstAlquiler").DataTable({
  columns: [
    {
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
      data: "oferta",
    },
  ],

  columnDefs: [
    {
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
  ],
  order: [[0, "desc"]],
  language: {
    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
  },
});

/* ======================================================================================
    TRAER LISTADO DE PRODUCTOS PARA INPUT DE BUSQUEDA
    ======================================================================================*/

function cargarProductosAlquiler() {
  $.ajax({
    async: false,
    url: rutaOculta + "ajax/producto.ajax.php",
    method: "POST",
    data: {
      ajaxAutoProductoVenta: "ajaxAutoProductoVenta",
      idAlmacen: idAlmacenAlquiler,
    },
    dataType: "json",
    success: function (respuesta) {
      items = []; // Limpia el array items
      for (let i = 0; i < respuesta.length; i++) {
        items.push(respuesta[i]["descripcion_producto"]);
      }
      $("#iptCodigoRopaAlq").autocomplete({
        source: items,
        select: function (event, ui) {
          CargarProductosAlquileres(ui.item.value);
          $("#iptCodigoRopaAlq").val("");
          $("#iptCodigoRopaAlq").focus();
          return false;
        },
      });
    },
  });
}

// Llama a cargarProductosAlquiler() cuando se inicie la página o cuando se cambie el almacen por primera vez
$(document).ready(function () {
  cargarProductosAlquiler();
  iniciarTablaAlquilerDet(filtro_desde, filtro_hasta);
});

function CargarProductosAlquileres(producto = "") {
  if (producto != "") {
    var codigo_producto = producto;
  } else {
    var codigo_producto = $("#iptCodigoRopaAlq").val();
  }
  codigo_producto = $.trim(codigo_producto.split("-")[0]);
  var producto_repetido = 0;
  // VERIFICAMOS QUE EL PRODUCTO TENGA STOCK
  tableProductoAlquiler
    .rows()
    .eq(0)
    .each(function (index) {
      var row = tableProductoAlquiler.row(index);

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
            idAlmacen: idAlmacenAlquiler,
          },

          dataType: "json",
          success: function (respuesta) {
            if (parseInt(respuesta["existe"]) == 0) {
              // alert('entro')

              toast2.fire({
                icon: "error",
                title:
                  "&nbsp;  El producto " +
                  "'" +
                  data["descProducto"] +
                  "'" +
                  " ya no tiene stock <br>" +
                  " Solo cuenta con " +
                  respuesta["stock_actual"] +
                  " de stock!",
              });

              $("#iptCodigoVenta").val("");
              $("#iptCodigoVenta").focus();
            } else {
              tableProductoAlquiler
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
              tableProductoAlquiler.cell(index, 5).data(NuevoPrecio).draw();

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
      idAlmacen: idAlmacenAlquiler,
    },

    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);
      if (respuesta) {
        var TotalVenta = 0.0;
        tableProductoAlquiler.row
          .add({
            idProducto: itemProducto,
            codigoBarras: respuesta["codigoBarras"],
            descProducto: respuesta["descProducto"],
            cantidad:
              '<input type="text" style="width:80px;" codigoProducto = "' +
              respuesta["codigoBarras"] +
              '" class="form-control  text-center iptCantidad p-0 m-0" value="1">',
            precio_venta_producto: respuesta["precio_venta_producto"],
            total: respuesta["total"],
            acciones:
              "<center>" +
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
              "' precio_oferta2=' " +
              respuesta["precioVentaMA"] +
              "' style='cursor:pointer; font-size:14px;'>Minimo (S./ " +
              parseFloat(respuesta["precioVentaMA"]).toFixed(2) +
              ")</a></li>" +
              "<li><a class='dropdown-item' codigo = '" +
              respuesta["codigoBarras"] +
              "' precio_oferta3=' " +
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
$("#lstAlquiler tbody").on("change", ".iptCantidad", function () {
  var data = tableProductoAlquiler.row($(this).parents("tr")).data();

  cantidad_actual = $(this)[0]["value"];
  cod_producto_actual = $(this)[0]["attributes"][2]["value"];

  if (!$.isNumeric($(this)[0]["value"]) || $(this)[0]["value"] <= 0) {
    toast2.fire({
      icon: "error",
      title: "INGRESE UN VALOR NUMERICO Y MAYOR A 0",
    });

    $(this)[0]["value"] = "1";

    $("#iptCodigoRopaAlq").val("");
    $("#iptCodigoRopaAlq").focus();
    return;
  }

  tableProductoAlquiler
    .rows()
    .eq(0)
    .each(function (index) {
      var row = tableProductoAlquiler.row(index);

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
            idAlmacen: idAlmacenAlquiler,
          },
          dataType: "json",
          success: function (respuesta) {
            if (parseInt(respuesta["existe"]) == 0) {
              toast2.fire({
                icon: "error",
                title:
                  "&nbsp;  El producto " +
                  "'" +
                  data["descProducto"] +
                  "'" +
                  " ya no tiene stock <br>" +
                  " Solo cuenta con " +
                  respuesta["stock_actual"] +
                  " de stock!",
              });

              tableProductoAlquiler
                .cell(index, 3)
                .data(
                  '<input type="text" style="width:80px;" codigoProducto = "' +
                    cod_producto_actual +
                    '" class="form-control text-center iptCantidad m-0 p-0" value="1">'
                )
                .draw();

              $("#iptCodigoRopaAlq").val("");
              $("#iptCodigoRopaAlq").focus();

              // ACTUALIZAR EL NUEVO PRECIO DEL ITEM DEL LISTADO DE VENTA
              NuevoPrecio = (
                parseFloat(1) *
                data["precio_venta_producto"].replaceAll(simbolom, "")
              ).toFixed(2);
              NuevoPrecio = simbolom + NuevoPrecio;
              tableProductoAlquiler.cell(index, 5).data(NuevoPrecio).draw();

              // RECALCULAMOS TOTALES
              recalcularTotales();
            } else {
              // AUMENTAR EN 1 EL VALOR DE LA CANTIDAD
              tableProductoAlquiler
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
              tableProductoAlquiler.cell(index, 5).data(NuevoPrecio).draw();

              // RECALCULAMOS TOTALES
              recalcularTotales();
            }
          },
        });
      }
    });
});

$("#lstAlquiler tbody").on("click", ".btnEliminarproducto", function () {
  tableProductoAlquiler.row($(this).parents("tr")).remove().draw();

  $("#iptCodigoRopaAlq").focus();
  recalcularTotales();
});

$("#lstAlquiler tbody").on("click", ".dropdown-item", function () {
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

  tableProductoAlquiler
    .rows()
    .eq(0)
    .each(function (index) {
      var row = tableProductoAlquiler.row(index);

      var data = row.data();

      if (data["codigoBarras"] == codigo_producto) {
        cantidad_actual = parseFloat($.parseHTML(data["cantidad"])[0]["value"]);

        // AUMENTAR EN 1 EL VALOR DE LA CANTIDAD
        tableProductoAlquiler
          .cell(index, 4)
          .data(simbolom + parseFloat(precio_venta).toFixed(2))
          .draw();

        // ACTUALIZAR EL NUEVO PRECIO DEL ITEM DEL LISTADO DE VENTA
        NuevoPrecio = (
          parseInt(cantidad_actual) *
          data["precio_venta_producto"].replace(simbolom, "")
        ).toFixed(2);
        NuevoPrecio = simbolom + NuevoPrecio;
        tableProductoAlquiler.cell(index, 5).data(NuevoPrecio).draw();

        // RECALCULAMOS TOTALES
      }
    });

  recalcularTotales();
}

var pruebatotales;

function recalcularTotales() {
  var TotalVenta = 0.0;

  tableProductoAlquiler
    .rows()
    .eq(0)
    .each(function (index) {
      var row = tableProductoAlquiler.row(index);
      var data = row.data();
      pruebatotales =
        parseFloat(TotalVenta) +
        parseFloat(data["total"].replace(simbolom, ""));
      TotalVenta =
        parseFloat(TotalVenta) +
        parseFloat(data["total"].replace(simbolom, ""));
    });

  var TotalCostoVenta = 0.0;
  var costoAdicional = parseFloat($("#costoAdicional").val()) || 0; // Obtén el valor de costoAdicional como número o establece 0 si está vacío

  TotalCostoVenta = TotalVenta + costoAdicional;

  $("#totalVenta").html("");
  $("#totalVenta").html(parseFloat(redondear(TotalCostoVenta, 1)).toFixed(2));

  $("#iptCodigoRopaAlq").val("");
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

$(document).on("change", "#costoAdicional", function () {
  recalcularTotales();
});
//#endregion

//#region Guardado de Alquiler empezar aqui
$(".btnCerrarModal").click(function () {
  $("#modal_pagar").modal("hide");
});

$(".btnCerrarComprobante").click(function () {
  $("#modalComprobante").modal("hide");
});

$("#btnRegistrarAlquiler").on("click", function () {
  var totalVenta = $("#totalVenta").html();
  $(".guardarPagoCre").hide();
  $(".guardarPago").show();

  if (validarDatosVenta()) {
    $(".totalPagarModal").val(totalVenta);
    //$(".guardarPagoCre").hide();
    //$(".guardarPago").show();
    Swal.fire({
      position: "center",
      title: "¿Desea dejar a cuenta algun monto?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
      cancelButtonText: "No",
      allowOutsideClick: false,
    }).then((result) => {
      if (result.isConfirmed) {
        var forms = document.getElementsByClassName("needs-validation");
        var validation = Array.prototype.filter.call(forms, function (form) {
          if (form.checkValidity() === true) {
            if (validarDatosVenta()) {
              $("#modal_pagar").modal("show");
            }
          } else {
            console.log("No paso la validacion");
          }
          form.classList.add("was-validated");
          return false;
        });
      } else {
        var forms = document.getElementsByClassName("needs-validation");
        var validation = Array.prototype.filter.call(forms, function (form) {
          if (form.checkValidity() === true) {
            realizarAlquiler();
          } else {
            console.log("No paso la validacion");
          }
          form.classList.add("was-validated");
          return false;
        });
      }
    });
  }

  //COLOCAR UN SWEET ALERT SI DESEA PAGAR AHORA
});

function validarDatosVenta() {
  var resultado = true;

  var costoAdicional = parseFloat($("#costoAdicional").val());

  if (costoAdicional < 0) {
    toast2.fire({
      icon: "warning",
      title: "El costo de reparación no puede ser un valor negativo.",
    });

    resultado = false;
    $("#costoAdicional").focus();
  }
  if ($("#totalVenta").html() == 0.0) {
    toast2.fire({
      icon: "warning",
      title: "El monto a pagar es de 0.00, no puede continuar.",
    });

    resultado = false;
  }
  return resultado;
}

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

$(document).on("keyup", ".montoPagar", function () {
  var totalVenta = $("#totalVenta").html();
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

var listaMetodoPagoVenta;

$(document).on("click", ".guardarPago", function () {
  var forms = document.getElementsByClassName("needs-validation");
  var validation = Array.prototype.filter.call(forms, function (form) {
    if (form.checkValidity() === true) {
      var listaMetodosPago = [];
      var valid = true;
      var validar = true;
      var totalVenta = parseFloat($("#totalVenta").html());
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

      });

      if (valid) {
       
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

        if (totalMetodosPago > totalVenta) {
          toast2.fire({
            icon: "warning",
            title: "El monto a pagar no debe ser mayor al total.",
          });

          return;
        }

        listaMetodoPagoVenta = JSON.stringify(listaMetodosPago);
        realizarAlquiler();
        $("#modal_pagar").modal("hide");
        $(".eliminarMetodoSecundarios").remove();
        $(".metodoPago").val("");
        $(".montoPagar").val("");
        $(".nroOperacion").val("");
        //}
      } else {
        toast2.fire({
          icon: "warning",
          title: "Por favor complete todos los campos",
        });
      }
    } else {
      console.log("No paso la validacion");
    }
    form.classList.add("was-validated");
    return false;
  });
});

function realizarAlquiler() {
  var count = 0;

  var totalVenta = $("#totalVenta").html();
  var idCliente = $("#idCliente").val();
  var cInstitucion = $("#cInstitucion").val();
  var cdirInstitucion = $("#cdirInstitucion").val();
  var fecha_entrega = $("#fecha_entrega").val();
  var fecha_devolucion = $("#fecha_devolucion").val();
  var contactoSecundario = $("#contactoSecundario").val();
  var observaciones = $("#observaciones").val();

  tableProductoAlquiler
    .rows()
    .eq(0)
    .each(function (index) {
      count = count + 1;
    });

  if (count > 0) {
    var formData = new FormData();
    var arr = [];

    tableProductoAlquiler
      .rows()
      .eq(0)
      .each(function (index) {
        var row = tableProductoAlquiler.row(index);

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
  } else {
    var formData = new FormData();

    formData.append("arr[]", "");
  }

  formData.append("idCliente", idCliente);
  formData.append("idAlmacen", idAlmacenAlquiler);
  formData.append("cInstitucion", cInstitucion);
  formData.append("cdirInstitucion", cdirInstitucion);
  formData.append("tFecEnt", fecha_entrega);
  formData.append("tFecDev", fecha_devolucion);
  formData.append("cContac", contactoSecundario);
  formData.append("cObsDet", observaciones);
  formData.append("nTotal", parseFloat(totalVenta));
  formData.append("listaMetodoPagoVenta", listaMetodoPagoVenta);

  $.ajax({
    url: rutaOculta + "ajax/alquiler.ajax.php",
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
          title: "Se registró el alquiler correctamente.",
          icon: "success",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Imprimir!",
        }).then((result) => {
          if (result.isConfirmed) {
            var comprobantePDF =
              rutaOculta +
              "/extensions/libreporte/reportes/ticketAlquiler.php?idAlquiler=" +
              loRespuesta["mensajeModel"];

            $("#modalComprobante").modal("show"); // Abre el modal
            $("#modalComprobante iframe").attr("src", comprobantePDF); // Cambia la fuente del iframes

            $(".btncdr").hide();
            $(".btnxml").hide();
            $(".btna4").hide();
          } else {
          }
        });

        tableProductoAlquiler.clear().draw();
        tablaReparacion.ajax.reload();
        //traerNotificacionBajoInv();
        reiniciarDespuesReparacion();
        //cargarSelectDocumento();
      }
    },
  });

  items = [];
  $("#iptCodigoRopaAlq").focus();
}

function reiniciarDespuesReparacion() {
  $("#totalVenta").html("0.00");
  $("#idCliente").val("").trigger("change");
  $("#cInstitucion").val("");
  $("#cdirInstitucion").val("");
  $("#fecha_entrega").val("");
  $("#fecha_devolucion").val("");
  $("#contactoSecundario").val("").trigger("change");
  $("#observaciones").val("");
  $("#costoAdicional").val("");
  $(".needs-validation").removeClass("was-validated");
}
//#endregion

//#region Tabla Reparacion mostrar

$(".buttons-excel").hide();
function iniciarTablaAlquilerDet(filtro_desde, filtro_hasta) {
  tablaAlquilerDet = $(".tablaAlquilerDet").DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    responsive: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    dom: "Bfrtip",
    buttons: [
      {
        text: 'Exportar a Excel   &nbsp; <i class="fas fa-file-excel"></i>',
        extend: "excelHtml5",
        className: "btn btn-success",
        exportOptions: {
          columns: [1, 2, 3, 4, 5, 6],
        },
        filename: function () {
          return "Reporte_Reparacion";
        },
        pageStyle: {
          sheetPr: {
            pageSetUpPr: {
              fitToPage: 1,
            },
          },
          printOptions: {
            horizontalCentered: true,
            verticalCentered: true,
          },
          pageSetup: {
            orientation: "landscape",
            paperSize: "9",
            fitToWidth: "1",
            fitToHeight: "0",
          },
          pageMargins: {
            left: "0.2",
            right: "0.2",
            top: "0.4",
            bottom: "0.4",
            header: "0",
            footer: "0",
          },
          repeatHeading: true,
          repeatCol: "A:A",
        },
        excelStyles: [
          {
            template: "blue_medium",
          },
          {
            cells: "A2:",
            //template: "cyan_medium",
            style: {
              alignment: {
                vertical: "center",
                horizontal: "center",
                wrapText: true,
              },
            },
          },
        ],
      },
    ],
    ajax: {
      url: rutaOculta + "ajax/tablas/tablaAlquiler.ajax.php",
      dataSrc: "",
      data: {
        idAlmacen: idAlmacenAlquiler,
        fechaDesde: filtro_desde,
        fechaHasta: filtro_hasta,
      },
    },
    columns: [
      {
        data: "acciones",
      },
      {
        data: "estado",
      },
      {
        data: "nombres",
      },
      {
        data: "cNomMot",
      },
      {
        data: "detAlquiler",
      },
      {
        data: "pagos",
      },
      {
        data: "fechas",
      },
    ],
    bDestroy: true,
    iDisplayLength: 10,
  });
}

$("#btnFiltrarRep").on("click", function () {
  tablaAlquilerDet.destroy();

  if ($("#filtro_desde").val() == "") {
    filtro_desde = "01/10/2000";
  } else {
    filtro_desde = $("#filtro_desde").val();
  }

  if ($("#filtro_hasta").val() == "") {
    filtro_hasta = "10/10/9999";
  } else {
    filtro_hasta = $("#filtro_hasta").val();
  }

  filtro_desde = $("#filtro_desde").val();
  filtro_hasta = $("#filtro_hasta").val();

  iniciarTablaAlquilerDet(filtro_desde, filtro_hasta);
});

$("#btnQFiltroRep").on("click", function () {
  tablaAlquilerDet.destroy();
  var n = new Date();
  var y = n.getFullYear();
  var m = n.getMonth() + 1;
  var d = n.getDate();
  if (d < 10) {
    d = "0" + d;
  }
  if (m < 10) {
    m = "0" + m;
  }
  document.getElementById("filtro_desde").value = y + "-" + m + "-" + d;
  document.getElementById("filtro_hasta").value = y + "-" + m + "-" + d;

  filtro_desde = $("#filtro_desde").val();
  filtro_hasta = $("#filtro_hasta").val();

  iniciarTablaAlquilerDet(filtro_desde, filtro_hasta);
});

//#endregion

//#region pagar en la tabla reparacion

$(document).on("click", ".pagarAlquiler", function () {
  var nTotal = $(this).attr("nTotal");
  var idAlquilerPagar = $(this).attr("idAlquiler");

  //var totalVenta = $("#totalVenta").html();
  $("#idAlquilerPagar").val(idAlquilerPagar);
  $(".totalPagarModal").val(nTotal);
  $(".guardarPagoCre").show();
  $(".guardarPago").hide();

  $("#modal_pagar").modal("show");
});

var listaMetodoPagos;

$(document).on("click", ".guardarPagoCre", function () {
  var listaMetodosPago = [];
  var valid = true;
  var validar = true;
  var totalVenta = parseFloat($(".totalPagarModal").val());
  var totalMetodosPago = 0;

  $(".metodoPago").each(function () {
    var metodoPago = $(this).val();
    var monto = $(this).closest(".row").find(".montoPagar").val();
    var nroOperacion = $(this).closest(".row").find(".nroOperacion").val();

    if (metodoPago === "" || monto === "") {
      valid = false;
    }

    listaMetodosPago.push({
      metodoPago: metodoPago,
      monto: monto,
      nroOperacion: nroOperacion,
    });
  });

  if (valid) {
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

    if (totalMetodosPago > totalVenta) {
      toast2.fire({
        icon: "warning",
        title: "El monto a pagar no debe ser mayor al total.",
      });

      return;
    }

    listaMetodoPagos = JSON.stringify(listaMetodosPago);
    realizarPagoAlquiler();
    $("#modal_pagar").modal("hide");
    $(".eliminarMetodoSecundarios").remove();
    $(".metodoPago").val("");
    $(".montoPagar").val("");
    $(".nroOperacion").val("");
    //}
  } else {
    toast2.fire({
      icon: "warning",
      title: "Por favor complete todos los campos",
    });
  }
});

function realizarPagoAlquiler() {
  var idAlquilerPagar = $("#idAlquilerPagar").val();

  var formData = new FormData();

  formData.append("ajaxPagarAlquiler", "ajaxPagarAlquiler");
  formData.append("idAlquiler", idAlquilerPagar);
  formData.append("listaMetodoPagoVenta", listaMetodoPagos);

  $.ajax({
    url: rutaOculta + "ajax/alquiler.ajax.php",
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
          title: "Se registró el pago correctamente.",
          icon: "success",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Imprimir!",
        }).then((result) => {
          if (result.isConfirmed) {
            var comprobantePDF =
              rutaOculta +
              "/extensions/libreporte/reportes/ticketAlquiler.php?idAlquiler=" +
              loRespuesta["mensajeModel"];

            $("#modalComprobante").modal("show"); // Abre el modal
            $("#modalComprobante iframe").attr("src", comprobantePDF); // Cambia la fuente del iframes

            $(".btncdr").hide();
            $(".btnxml").hide();
            $(".btna4").hide();
          } else {
          }
        });

        tableProductoAlquiler.clear().draw();
        tablaAlquilerDet.ajax.reload(null, false);
        //traerNotificacionBajoInv();
        reiniciarDespuesReparacion();
        //cargarSelectDocumento();
      }
    },
  });
}

//#endregion

//#region entregar repracion cambio de estado

$(document).on("click", ".entregarAlquiler", function () {
  var idAlquilerEstado = $(this).attr("idAlquiler");

  Swal.fire({
    title: "¿Está seguro de devolver el alquiler?",
    text: "¡Si no lo está puede cancelar la acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, devolver!",
  }).then((result) => {
    if (result.isConfirmed) {
      var formData = new FormData();

      formData.append(
        "ajaxEditarEstadoAlquiler",
        "ajaxEditarEstadoAlquiler"
      );
      formData.append("idAlquiler", idAlquilerEstado);

      $.ajax({
        url: rutaOculta + "ajax/alquiler.ajax.php",
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

            tablaAlquilerDet.ajax.reload(null, false);
            //notificacionesReparacion();
            //traerNotificacionBajoInv();
            //cargarSelectDocumento();
          }
        },
      });
    }
  });
});

$(document).on("click", ".anularAlquiler", function () {
  var idAlquilerEstado = $(this).attr("idAlquiler");

  Swal.fire({
    title: "¿Está seguro de anular el alquiler?",
    text: "¡Si no lo está puede cancelar la acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, seguro!",
  }).then((result) => {
    if (result.isConfirmed) {
      var formData = new FormData();

      formData.append("ajaxAnularAlquiler", "ajaxAnularAlquiler");
      formData.append("idAlquiler", idAlquilerEstado);

      $.ajax({
        url: rutaOculta + "ajax/alquiler.ajax.php",
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
              title: "¡CORRECTO!",
              html: "¡Anulado exitosamente!",
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

            tablaAlquilerDet.ajax.reload(null, false);   
          }
        },
      });
    }
  });
});

$(document).on("click", ".pdfAlquiler", function () {
  var idAlquilerEstado = $(this).attr("idAlquiler");

  var comprobantePDF =
    rutaOculta +
    "/extensions/libreporte/reportes/ticketAlquiler.php?idAlquiler=" +
    idAlquilerEstado;

  $("#modalComprobante").modal("show"); // Abre el modal
  $("#modalComprobante iframe").attr("src", comprobantePDF); // Cambia la fuente del iframes

  $(".btncdr").hide();
  $(".btnxml").hide();
  $(".btna4").hide();
});

//#endregion
