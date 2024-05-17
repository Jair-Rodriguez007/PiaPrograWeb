$(document).ready(function() {
    var params = new URLSearchParams(window.location.search);
    var id = params.get('idLibro');
    console.log("Esta es la variable params: "+params);
    console.log("Esta es la variable id: "+id);
    $.ajax({
        url: '/PiaPrograWeb/php/getLibros.php',
        type: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(libro) {
            console.log(libro);
            $('#titulo-libro').text(libro.Titulo);
            $('#descripcion-libro').text(libro.Descripcion);
            $('#precio-libro').text('Precio: $' + libro.Precio);
            if(libro.CantidadInventario > 0) {
                $('#cantidad-libro').text('Estado: En existencia');
            } else {
                $('#cantidad-libro').text('Estado: Agotado');
            }
            $('#categoria-libro').text('Categoría: ' + libro.NombreCategoria);
            $('#imagen-libro').attr('src', libro.imagen);
        },
        error: function(error) {
            console.log(error);
            alert('Hubo un error al cargar los detalles del libro. Por favor, inténtalo de nuevo más tarde.');
        }
    });

    $('#btnCarrito').click(function() {
        var idLibro = params.get('idLibro');
        //var idUsuario = params.get('idUsuario');
        var cantidad = $('#quantity').val();
        console.log("Esta es la variable idLibro: "+idLibro);
        //console.log("Esta es la variable idUsuario: "+idUsuario);
        console.log("Esta es la variable cantidad: "+cantidad);
        $.ajax({
            url: '/PiaPrograWeb/php/agregarCarrito.php',
            type: 'POST',
            data: { 
                idLibro: idLibro,
                cantidad: cantidad
            },
            success: function(response) {
                console.log(response);
                alert('Libro añadido al carrito exitosamente');
            },
            error: function(error) {
                console.log(error);
                alert('Hubo un error al añadir el libro al carrito. Por favor, inténtalo de nuevo más tarde.');
            }
        });
    });
    document.getElementById("idLibro").value = id;
});