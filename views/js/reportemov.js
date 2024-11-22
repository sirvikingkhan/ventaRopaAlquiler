var rutaOculta = $("#rutaOculta").val();
var idAlmacenReportemov = null;
var simbolom = $("#simbolom").val();
cargarMostrarSede();
cargarFechayHoraReporteCaja();
cargarTotalesReporte();
iniciarTablaDetalleMov() ;
//--------------------------------------------------------------
//- TRAEMOS LA LISTA DE TRABAJADORES EXCEPTO A LOS INSTRUCTORES -
//--------------------------------------------------------------

function cargarFechayHoraReporteCaja() {
  var n = new Date();
  var y = n.getFullYear();
  var m = n.getMonth() + 1;
  var d = (n.getDate(), 1);
  var d2 = n.getDate();

  if (d < 10) {
    d = "0" + d;
  }
  if (m < 10) {
    m = "0" + m;
  }
  if (d2 < 10) {
    d2 = "0" + d2;
  }

  document.getElementById("desde_reporte").value = y + "-" + m + "-" + d;
  document.getElementById("hasta_reporte").value = y + "-" + m + "-" + d2;
}

function cargarMostrarSede() {
  $.ajax({
    async: false,
    url: "ajax/almacen.ajax.php",
    method: "POST",
    data: {
      ajaxAlmacenS: "ajaxAlmacenS",
    },
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);
      var options = '<option selected value="">Seleccione Sede</option>';
      for (let index = 0; index < respuesta.length; index++) {
        options =
          options +
          "<option value=" +
          respuesta[index][0] +
          ">" +
          respuesta[index][3];
        ("</option>");
      }
      $("#idAlmacenReporte").html(options);
    },
  });
}


function cargarTotalesReporte() {

  $.ajax({
    async: false,
    url: "ajax/caja.ajax.php",
    method: "POST",
    data: {
      'ajaxMovimientoCaja': 'ajaxMovimientoCaja',
      'idAlmacen': idAlmacenReportemov,
      'fechaDesde': $("#desde_reporte").val(),
      'fechaHasta': $("#hasta_reporte").val(),
    },
    dataType: 'json',
    success: function (respuesta) {
      console.log(respuesta);
      $("#rptingresoEgreso").html(simbolom + respuesta["Total_Todo"]);
      $("#rptIngreso").html(simbolom + respuesta["Total_Ingresos"]);
      $("#rptEgreso").html(simbolom + respuesta["Total_Egresos"]);

    }
  });


}

$("#btnFiltro").on("click", function () {

  idAlmacenReportemov = $("#idAlmacenReporte").val();

  if ($("#desde_reporte").val() == "") {
    desde_reporte = "01/10/2000";
  } else {
    desde_reporte = $("#desde_reporte").val();
  }

  if ($("#hasta_reporte").val() == "") {
    hasta_reporte = "10/10/9999";
  } else {
    hasta_reporte = $("#hasta_reporte").val();
  }

  //idAlmacen = $("#idAlmacen").val();
  desde_reporte = $("#desde_reporte").val();
  hasta_reporte = $("#hasta_reporte").val();

  cargarTotalesReporte();
  iniciarTablaDetalleMov() ;
});

$("#btnQFiltro").on("click", function () {
  idAlmacenReportemov = null;
  $("#idAlmacenReporte").val("");
  cargarFechayHoraReporteCaja();
  cargarTotalesReporte();
  iniciarTablaDetalleMov() ;
});

/* */
function iniciarTablaDetalleMov() {
  lstReporteMov = $("#lstReporteMov").DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    responsive: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    ajax: {
      url: rutaOculta + "ajax/caja.ajax.php",
      data: {
        ajaxMovimientoCajaDetalle: "ajaxMovimientoCajaDetalle",
        idAlmacen: idAlmacenReportemov,
        fechaDesde: $("#desde_reporte").val(),
        fechaHasta: $("#hasta_reporte").val(),
      },
      type: "post",
      dataSrc: "",
    },
    columns: [
      { data: "fecha" },
      { data: "empleado" },
      { data: "descripcion" },
      { 
        data: "tipo",
        createdCell: function(td, cellData, rowData, row, col) {
          // Cambiar color de fondo de la celda de la columna 'tipo'
          if (cellData === 'Ingreso') {
            $(td).css('background-color', 'green');
            $(td).css('color', 'white'); // Opcional: cambiar color de texto
          } else if (cellData === 'Egreso') {
            $(td).css('background-color', 'red');
            $(td).css('color', 'white'); // Opcional: cambiar color de texto
          }
        }
      },
      { data: "monto" },
    ],
    bDestroy: true,
    iDisplayLength: 10,
    bPaginate: false,
    bFilter: false,
    bInfo: false,
  });
}


