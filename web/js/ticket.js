$(document).ready( function () {
    $('#ticketTable').DataTable(
        {
            language: {
                info: "Mostrando _START_ a _END_ de _TOTAL_ lineas",
                lengthMenu: "Mostrar _MENU_ lineas",
                search: "Buscar:"
            }
        }
    );
} );