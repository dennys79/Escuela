$(document).ready(function () {
    var t = $('#lista_alumnos').dataTable({
        "order": [[1, "asc"]],
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
        select: true
//        select: {
//            style:    'os',
//            selector: 'td:first-child'
//        }
    }
    );
    

    $('#lista_alumnos tbody').on('click', 'tr', function () {
        var id = (jQuery(".selected").attr("id"));
        if (typeof id === 'undefined'){
            $("#eliminar").attr('disabled',true);            
            $("#editar").attr('disabled',true);
        }else{
            $("#eliminar").attr('disabled',false);            
            $("#editar").attr('disabled',false);            
        }
    });
});

function eliminar(){    
    var name = (jQuery(".selected").attr("name"));
    if (typeof name === 'undefined'){
        return ;
    }else{
        $('.modal-body').text('¿Está seguro de querer eliminar al Alumno: ' + name + '?');
        $('#dlg_eliminar').modal("show");
    }
}

$(function() {
    $("#btn_dlg_eliminar").click(function() {
        var seleccionado = (jQuery(".selected").attr("id"));
        $.post("?mod=Alumno&cont=index&met=eliminar", {idAlumno: seleccionado},
        function(data) {
            if (data > 0){
                alert('Datos eliminados');
                window.location.assign('?mod=Alumno&cont=index');
            }
        });
        
    });
});

function editar(){    
    var seleccionado = (jQuery(".selected").attr("id"));
    if (typeof seleccionado === 'undefined'){
        return ;
    }else{
        window.location.assign('?mod=Alumno&cont=index&met=editar&id=' + Number(seleccionado));
    }
}

function imprimirFicha(){    
    var id = $("#id").attr("value");
    window.location.assign('?mod=Alumno&cont=index&met=imprimirFicha&id=' + Number(id));
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