$(document).ready(function () {
    var t = $('#listar_alumnos').dataTable({
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
    
});


function inscribir(){    
    var seleccionado = $("#listar_alumnos").attr("curso");
    window.location.assign('?mod=Cursos&cont=index&met=inscribir&id=' + Number(seleccionado));
}
