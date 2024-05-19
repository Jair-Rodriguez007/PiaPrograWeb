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
                    var infoLibro = '<div class="card">' +
                                    '<h5 class="card-header">Compra ID: ' + libro.IdVenta + '</h5>' +
                                    '<div class="card-body">' +
                                        '<h5 class="card-title">Titulo: ' + libro.Titulo + '</h5>' +
                                        '<p class="card-text">Fecha de compra: ' + libro.FechaVenta + '</p>' +
                                        '<p class="card-text">Método de pago: ' + libro.NombreMetodo + '</p>' +
                                        '<p class="card-text">Estado: ' + libro.NombreEstado + '</p>' +
                                        '<p class="card-text">Nombre: ' + libro.Nombre + '</p>' +
                                    '</div>' +
                                '</div>';
                    lista.append(infoLibro);
                }
            },
            error: function() {
                alert('Hubo un error al buscar las ventas');
            }
        });
    });
});