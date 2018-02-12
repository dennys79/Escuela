$(document).ready(function () {
    var loc = location.hostname;
    var t = $('#lista_roles').DataTable({
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
    
    $('#lista_roles tbody').on('click', 'tr', function () {
        var id = (jQuery(".selected").attr("id"));
        if (typeof id === 'undefined'){
            $("#permisos").attr('disabled',true);            
            $("#editar").attr('disabled',true);            
        }else{
            $("#permisos").attr('disabled',false);            
            $("#editar").attr('disabled',false);            
        }
    });    
});

$(function() {
    $("#permisos").click(function() {
        var seleccionado = (jQuery(".selected").attr("id"));
        if (typeof seleccionado === 'undefined'){
            return ;
        }else{
            window.location.assign('?mod=Acl&cont=index&met=permisos_role&idRole=' + Number(seleccionado));
        }
    });
});

function editar(){    
    var seleccionado = (jQuery(".selected").attr("id"));
    if (typeof seleccionado === 'undefined'){
            return ;
    }else{
        window.location.assign('?mod=Acl&cont=index&met=editarRole&idRole=' + Number(seleccionado));        
    }
}