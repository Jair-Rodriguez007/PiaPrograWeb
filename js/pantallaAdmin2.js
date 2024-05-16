$(document).ready(function() {
    $('form').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: '/PiaPrograWeb/php/buscarCompras.php',
            type: 'GET',
            data: $(this).serialize(),
            success: function(data) {
                console.log(data);
                // Parsea los datos a un objeto JSON
                var libros = JSON.parse(data);
                var lista = $('#lista-libros');
                lista.empty();
                for (var i = 0; i < libros.length; i++) {
                    var libro = libros[i];
                    var infoLibro = 'Compra ID: ' + libro.IdVenta + ', Usuario ID: ' + libro.IdUsuario + ', Obra ID: ' + libro.IdProducto + ', Fecha de compra: ' + libro.FechaCompra + ', Método de pago: ' + libro.NombreMetodo + ', Estado: ' + libro.estado + ', Cantidad: ' + libro.cantidad + ', Nombre: ' + libro.nombre + ', Título: ' + libro.titulo;
                    lista.append('<li>' + infoLibro + '</li>');
                }
            },
            error: function() {
                alert('Hubo un error al buscar las ventas');
            }
        });
    });
});
