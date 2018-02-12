$(function () {
    $("#tabs").tabs();
});
$(function () {
    $("#fechaNac").datepicker(
            {
                changeYear: true
            }
    );
});
$(function () {
    $("#fechaIngreso").datepicker();
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(function () {
    $("#imprimir").click(function () {
        var id = $("#idObraSocial").attr("value");
        var datos = new Object();
        var pacientes;
        var leyenda = $("#leyenda").attr("value");
        var i = 0
        $('.paciente').each(function () {
            var checkbox = $(this);
            if (checkbox.is(':checked')) {
                pacientes += (checkbox.attr('value')) + '-';
            }
            i++;
            datos[0] = pacientes;
            datos[1] = leyenda;
        });
        var jObject = {};
        for (i in datos) {
            jObject[i] = datos[i];
        }

        $.post("?option=pdfphsrl&sub=facturacion&id=" + id,
                {datos: jObject},
                function (data) {
                    alert("Data Loaded: " + data);
                });
    });

    $(function () {
        $("#btn_inscribir").click(function () {
            var id = $("#id").attr("value");
            $("#preinscriptos option:selected").each(function () {
                $.post("?mod=Cursos&cont=index&met=inscribirAlumno&id=" + id +
                        '&idAlumno=' + $(this).attr('value'),
                function (data){
//                        alert (data);
                });
                location.reload(true);
            });
        });
    });
    $(function () {
        $("#btn_quitar").click(function () {
            var id = $("#id").attr("value");
            $("#sel_inscriptos option:selected").each(function () {
                $.post("?mod=Cursos&cont=index&met=desinscribirAlumno&id=" + id +
                        '&idAlumno=' + $(this).attr('value'),
                function (data){
                        alert (data);
                });
//                location.reload(true);
            });
        });
    });
    
    $(function () {
        $("#btn_agregar").click(function () {
            var idCurso = '';
            $("#cursos_disponibles option:selected").each(function () {
                idCurso = $(this).attr('value');
                $.post("?mod=Cursos&cont=index&met=agregarCurso&"+
                        'idCurso=' + idCurso,
                function (data){
//                        alert (data);
                });
                location.reload(true);
            });
        });
    });
    $(function () {
        $("#btn_quitarCurso").click(function () {
            var idCurso = '';
            $("#cursos_activos option:selected").each(function () {
                idCurso = $(this).attr('value');
                $.post("?mod=Cursos&cont=index&met=quitarCurso"+
                        '&idCurso=' + idCurso,
                function (data){
//                        alert (data);
                });
                location.reload(true);
            });
        });
    });

});
