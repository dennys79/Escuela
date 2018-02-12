$(document).ready(function () {
    var loc = location.hostname;
    var t = $('#lista_usuarios').DataTable({
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
    
    $('#lista_usuarios tbody').on('click', 'tr', function () {
        var id = (jQuery(".selected").attr("id"));
        if (typeof id === 'undefined'){
            $("#eliminar").attr('disabled',true);            
            $("#editar").attr('disabled',true);
            $("#permisos").attr('disabled',true);
        }else{
            $("#eliminar").attr('disabled',false);            
            $("#editar").attr('disabled',false);            
            $("#permisos").attr('disabled',false)
        }
    });
    
//    $('#lista_usuarios tbody').on('click', 'tr', function () {
//        var id = this.id;
//        loc = location.hostname;
//        window.location.assign('http://' + loc + '/Cronos/index.php?option=Paciente&sub=index&cont=editar&id=' + Number(id));
//    });
});

function eliminar(){    
    var name = (jQuery(".selected").attr("name"));
    if (typeof name === 'undefined'){
        return ;
    }else{
        $('.modal-body').text('¿Está seguro de querer eliminar el usuario: ' + name + '?');
        $('#dlg_eliminar').modal("show");
    }
}

$(function() {
    $("#btn_dlg_eliminar").click(function() {
        var seleccionado = (jQuery(".selected").attr("id"));
        $.post("?mod=Usuarios&cont=index&met=eliminar", {idUsuario: seleccionado},
        function(data) {
            alert(data);
        });
        window.location.assign('?mod=Usuarios');
    });
});

function editar(){    
    var seleccionado = (jQuery(".selected").attr("id"));
    if (typeof seleccionado === 'undefined'){
        return ;
    }else{
        window.location.assign('?mod=Usuarios&cont=index&met=editar&id=' + Number(seleccionado));
    }
}

function permisos(){    
    var seleccionado = (jQuery(".selected").attr("id"));
    if (typeof seleccionado === 'undefined'){
        return ;
    }else{
        window.location.assign('?mod=Usuarios&cont=index&met=permisos&id=' + Number(seleccionado));
    }
}