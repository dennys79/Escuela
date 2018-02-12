$(document).ready(function () {
    var t = $('#lista_iva').dataTable({
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
        select: {
            style:    'os',
            selector: 'td:first-child'
        }
    }
    );
    

    $('#lista_iva tbody').on('click', 'tr', function () {
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
        $('.modal-body').text('¿Está seguro de querer eliminar al Iva: ' + name + '?');
        $('#dlg_eliminar').modal("show");
    }
}

$(function() {
    $("#btn_dlg_eliminar").click(function() {
        var seleccionado = (jQuery(".selected").attr("id"));
        $.post("?mod=Administrator&cont=index&met=eliminarIva", {id: seleccionado},
        function(data) {
            if (data > 0){
                alert('Datos eliminados');
                window.location.assign('?mod=Administrator&cont=index&met=iva');
            }
        });
        
    });
});

function editar(){    
    var seleccionado = (jQuery(".selected").attr("id"));
    if (typeof seleccionado === 'undefined'){
        return ;
    }else{
        window.location.assign('?mod=Administrator&cont=index&met=editarIva&id=' + Number(seleccionado));
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