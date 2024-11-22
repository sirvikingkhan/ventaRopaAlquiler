var Getruta = $("#Getruta").val();
var idAlmacen = $("#idAlmacen").val();
var idUsuario = $("#idUsuario").val();
var estado_caja;
var simbolom = $("#simbolom").val();
var loRespuesta;
var myChart;
var ingresoChart;
var egresoChart;
var montoInicialChart;
chartJs();
fnc_idCAja();
fnc_actualizar_totales();

var idCajaTotales;
var fechaTotales;

function fnc_idCAja() {
  $.ajax({
    async: false,
    url: "ajax/caja.ajax.php",
    method: "POST",
    data: {
      ajaxrVercaja: "ajaxrVercaja",
      idUsuario: idUsuario,
    },
    dataType: "json",
    success: function (respuesta) {
      if (respuesta == false) {
        $('#cajaAbierta').hide();
        $('#cajaCerrada').show();
        console.log("no tiene caja abierta");
      } else {
       
        $('#cajaAbierta').show();
        $('#cajaCerrada').hide();
        $("#idCaja").val(respuesta["idCaja"]);
        $("#nombreCajero").html("  " + respuesta["empleado"]);
        $("#fechaCaja").html(respuesta["fecha_apertura"]);
       
        idCajaTotales = respuesta["idCaja"];
        fechaTotales = respuesta["fecha_apertura"];
      }
    },
  });
}


function fnc_actualizar_totales() {
  $.ajax({
    async: false,
    url: "ajax/caja.ajax.php",
    method: "POST",
    data: {
      ajaxTotalTodo: "ajaxTotalTodo",
      idCaja: idCajaTotales,
      idUsuario: idUsuario,
      fecha: fechaTotales,
    },
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);

      var ingresos =
        parseFloat(respuesta["TotalVentas"]) + 
        parseFloat(respuesta["Ingreso"]);
        
      var totalEfectivo =
        parseFloat(respuesta["montoApertura"]) +
        ingresos;
      $("#montoInicial").html(simbolom + respuesta["montoApertura"]);
      montoInicialChart = respuesta["montoApertura"];

      $("#ingresoCaja").html(simbolom + ingresos.toFixed(2));
      ingresoChart = ingresos.toFixed(2);

      $("#egresoCaja").html(simbolom + respuesta["Egreso"]);
      egresoChart = respuesta["Egreso"];

      $("#totalEfectivo").html(simbolom + totalEfectivo.toFixed(2));

      //TARJETAS NO EFECTIVO
      $("#totalTarjeta").html(simbolom + respuesta["totalTarjetaTodo"]);
      $("#totalTransferencias").html(
        simbolom + respuesta["totalTransferenciaTodo"]
      );
      $("#totalYape").html(simbolom + respuesta["totalYapeTodo"]);
      $("#totalPlin").html(simbolom + respuesta["totalPlinTodo"]);

      var totalNoEfectivo =
        parseFloat(respuesta["totalTarjetaTodo"]) +
        parseFloat(respuesta["totalTransferenciaTodo"]) +
        parseFloat(respuesta["totalYapeTodo"]) +
        parseFloat(respuesta["totalPlinTodo"]);

      $("#totalNoEfectivoo").html(simbolom + totalNoEfectivo.toFixed(2));
        
      var totalTodo = totalEfectivo + totalNoEfectivo;

      $("#totalTodo").html(simbolom + totalTodo.toFixed(2));
    
      myChart.destroy();
      //chartJs();
      chartJs();

    },
  });
}


$(".guardarAbrirCaja").on("click", function () {
  var html_confirm =
    '<div>Se creará una apertura de caja con los siguientes datos:</div>\
  <br><div style="width: 100% !important; float: none !important;">\
  <table class="table m-b-0">\
  <tr><td class="text-left">Cajero: </td><td class="text-right">' +
    $("#nombreUsuario").val() +
    '</td></tr>\
  <tr><td class="text-left">Monto: </td><td class="text-right">' +
    parseFloat($("#monto_apertura").val()).toFixed(2) +
    '</td></tr>\
  </table>\
  </div><br>\
  <div><span class="text-success" style="font-size: 17px;">¿Está Usted de Acuerdo?</span></div>';
  Swal.fire({
    title: "Necesitamos de tu Confirmación",
    html: html_confirm,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#34d16e",
    confirmButtonText: "Si, Adelante!",
    cancelButtonText: "No!",
    showLoaderOnConfirm: true,
    preConfirm: function () {
      var monto_apertura = $("#monto_apertura").val(),
        idAlmacen = $("#idAlmacen").val();

      var datos = new FormData();

      datos.append("ajaxAperturaCaja", "ajaxAperturaCaja");
      datos.append("monto_apertura", monto_apertura);
      datos.append("idAlmacen", idAlmacen);

      $.ajax({
        url: "ajax/caja.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {

          loRespuesta = JSON.parse(respuesta);

          if (loRespuesta["codigoError"] == 1) {
            var tittle = "¡Error!";
            var mensaje = loRespuesta["mensajeError"];
            var icono = "error";
          } else {
            var tittle = "¡CORRECTO!";
            var mensaje = "¡Caja Abierta exitosamente!"
            var icono = "success";
          }

          AlertaMensaje(tittle, mensaje, icono)

          fnc_idCAja();
          fnc_actualizar_totales();

        },
      });
    },
    allowOutsideClick: false,
  });
});


$(document).on("click", ".btnCerrarCajaAr", function () {
  var idCaja = $("#idCaja").val();
  var monto_ingreso = $("#ingresoCaja").html().replace(simbolom, "");
  var monto_egreso = $("#egresoCaja").html().replace(simbolom, "");
  var monto_cierre = $("#totalTodo").html().replace(simbolom, "");

  Swal.fire({
    title: "¿Está seguro de cerrar caja?",
    text: "¡Si no lo está puede cancelar la acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cerrar!",
  }).then((result) => {
    if (result.isConfirmed) {
      var datos = new FormData();
      datos.append("ajaxCierreCaja", "ajaxCierreCaja");
      datos.append("idCaja", idCaja);
      datos.append("monto_ingreso", monto_ingreso);
      datos.append("monto_egreso", monto_egreso);
      datos.append("monto_cierre", monto_cierre);
      $.ajax({
        url: "ajax/caja.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          AlertaMensaje("¡CORRECTO!", "Se cerro correctamente.", "success")
          fnc_idCAja();
        },
      });
    }
  });
});

$(document).on("click", ".btnIngreso", function () {
  $("#tipo").val("Ingreso");
  $(".modal-header").removeClass("bg-red");
  $(".modal-header").addClass("bg-success");

  $("#idCajaM").val(idCajaTotales);
});

$(document).on("click", ".btnEgreso", function () {
  $("#tipo").val("Egreso");
  $(".modal-header").removeClass("bg-success");
  $(".modal-header").addClass("bg-red");

  $("#idCajaM").val(idCajaTotales);
});

$(document).on("click", ".btnGuardar", function () {
  var idCaja = $("#idCajaM").val();
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
      datos.append("idCaja", idCaja);
      datos.append("tipo", tipo);
      datos.append("descripcion", descripcion);
      datos.append("monto", monto);
      datos.append("idUsuario", idUsuario);
      $.ajax({
        url: "ajax/caja.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          loRespuesta = JSON.parse(respuesta);
          if (loRespuesta["codigoError"] == 1) {
            var tittle = "¡Error!";
            var mensaje = loRespuesta["mensajeError"];
            var icono = "error";
          } else {
            var tittle = "¡CORRECTO!";
            var mensaje = text2
            var icono = "success";
          }
          AlertaMensaje(tittle, mensaje, icono)
          $("#mdlGestionarCaja").modal("hide");
          fnc_actualizar_totales();
        },
      });
    }
  });
});


function AlertaMensaje(tittle, mensaje, icono) {
  Swal.fire({
    title: tittle,
    html: mensaje,
    icon: icono,
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
}

//CHARTJS


function chartJs() {

  var donutData = {
    labels: [
      'Monto Inicial',
      'Ingreso',
      'Egreso',
    ],

    datasets: [{
      data: [montoInicialChart, ingresoChart, egresoChart],
      backgroundColor: ['#d2d6de', '#0080FF', '#FF2D00'],
    }]
  }


  //------------- 
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
  var pieData = donutData;
  var pieOptions = {
    maintainAspectRatio: false,
    responsive: true,
  }
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  myChart = new Chart(pieChartCanvas, {
    type: 'pie',
    data: pieData,
    options: pieOptions
  })

}



$(document).on("click", ".btnImprimirCaja", function () {
  //var idCaja = $(this).attr("idCaja");
  var idCaja = $("#idCaja").val();
  //var data = tablaCaja.row($(this).parents("tr")).data();
  //console.log("🚀 ~ file: productos.php ~ line 751 ~ $ ~ data", data)

  //var fechaTraer = data["fecha_apertura"];

  var fechaImpr = fechaTotales.substr(-20, 10);

  //printJS(rutaOculta+"/extensions/libreporte/reportes/generar_tickerventa.php?idCaja="+idCaja)
  window.open(
    rutaOculta + "/extensions/libreporte/reportes/generar_caja.php?idCaja=" +
    idCaja + "&fecha=" + fechaImpr +
    "#zoom=100%",
    "Ticket",
    "scrollbars=NO"
  );

});