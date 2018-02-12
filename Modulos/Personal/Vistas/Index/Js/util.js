$(function() {
    $( "#tabs" ).tabs();
  });

$(function () {
//  $('[data-toggle="tooltip"]').tooltip();
  $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
});

$(function() {
    $("#agregarDatosLaborales").click(function () {
        var guardar = $("#guardarDatosLaborales").val();
        var id = $("#id").val();
        var idProfesional = $("#idProfesional").val();
        var fechaIngreso = $("#fechaIngreso").val();
        var puesto = $("#valorOcupacionEmpresa").val();
        var observaciones = $("#observacionesDatosLaborales").val();
        $.post("?option=Personal&sub=laboral&met=guardar",
          {guardar: guardar, id: id, idProfesional: idProfesional, fechaIngreso: fechaIngreso, puesto: puesto, observaciones: observaciones},
          function(data) {
            alert(data);
            document.location.reload();
          });        
    });
});

$(function() {
    $(".conf-eliminar").click(function () {
        var idPersonal = $("#idPersonal").val();
        $.post("?option=Personal&sub=index&met=eliminar",
          {idProfesional: idPersonal},
          function(data) {
            alert(data);
            document.location.reload();
          });
    });
});  