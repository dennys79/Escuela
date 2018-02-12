$(document).ready(function () {
    var t = $('#lista_inasistencias').dataTable({
        "order": [[3, "asc"]],
        "language": {
            "url": "Public/Js/Spanish.json"
            },
        stateSave: true,
        "columnDefs": [{
                "targets": 0,
                "searchable": false,
                "orderable": false,
                "className": 'select-checkbox'
            }
        ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        }
    }
    );
    

    $('#lista_ciclos tbody').on('click', 'tr', function () {
        var id = (jQuery(".selected").attr("id"));
        if (typeof id === 'undefined'){
            $("#eliminar").attr('disabled',true);            
            $("#editar").attr('disabled',true);
            $("#setInasistencias_Actual").attr('disabled',true);
        }else{
            $("#eliminar").attr('disabled',false);            
            $("#editar").attr('disabled',false);            
            $("#setInasistencias_Actual").attr('disabled',false);
        }
    });
});

function inasistencia_curso(){    
    var name = (jQuery("select[name=curso]").val());
    var fecha = (jQuery("input[name=fechaInasistencia]").val());
    if (name === "0"){
        window.location.assign('?mod=Inasistencias&cont=index&met=inasistenciaAlumnos&fecha='+fecha);
    }else{
        window.location.assign('?mod=Inasistencias&cont=index&met=inasistenciaAlumnos&curso='+name+'&fecha='+fecha);
    }
}

$(function() {
    $("#btn_dlg_eliminar").click(function() {
        var seleccionado = (jQuery(".selected").attr("id"));
        $.post("?mod=Inasistencias&cont=index&met=eliminar", {id: seleccionado},
        function(data) {
            if (data > 0){
                alert('Datos eliminados');
                window.location.assign('?mod=Inasistencias&cont=index');
            }
        });
        
    });
});

function editar(){    
    var seleccionado = (jQuery(".selected").attr("id"));
    if (typeof seleccionado === 'undefined'){
        return ;
    }else{
        window.location.assign('?mod=Inasistencias&cont=index&met=editar&id=' + Number(seleccionado));
    }
}

$(function() {
    $(".glyphicon-remove").click(function() {
        var v = $(this).parent('a').attr("id_alumno");
        var c = $(this).parent('a').attr("id_contacto");
        var contexto = '';
        if (c > 0) {
            contexto = 'contacto';
        } else {
            c = $(this).parent('a').attr("idTerapia");
            if (c > 0) {
                contexto = 'terapia';
            } else {
                c = $(this).parent('a').attr("idFamilia");
                contexto = 'familia';
            }
        };
        $.post("?mod=Alumno&cont=" + contexto + "&met=eliminar",
            {id: c},
            function(data) {
                if (data > 0) {
                    $("#" + c).fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);
                }
            }
        );
    });
});

function crearTabla(){
    var r = confirm("La Tabla Inasistenciass no existe.\n ¿Desea crearla?");
    if (r == true) {
        window.location.assign('?mod=Inasistencias&cont=index&met=crearTabla');
    } else {
        window.location.assign('index.php');
    }
}

function setInasistenciasActual(){
        var idInasistencias = $( "#setInasistenciasActual" ).attr('idInasistencias');
        var seleccionado = (jQuery(".selected").attr("id"));
        if(idInasistencias === seleccionado){
            $.post("?mod=Inasistencias&cont=index&met=setInasistenciasActual",
                {idInasistencias: idInasistencias},
                function(data) {
//                    alert(data);
                    window.location.reload();
                }
            );
        }
}