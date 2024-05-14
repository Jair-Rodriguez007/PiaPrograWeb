//var params = new URLSearchParams(window.location.search);
//var idUsuario = params.get('id');
$.ajax({
    url: '/PiaPrograWeb/php/getLibros.php',
    type: 'GET',
    dataType: 'json',
    success: function(libros) {
                console.log(libros);
                var contenedor = $('.row');
                libros.forEach(function(libro) {
                    var libroHTML = $('<div/>', { class: 'col-md-4' });
                    libroHTML.html(
                        '<h3><a href="' + 'pantalla4.html?idLibro=' + libro.IdProducto + '">' + libro.Titulo + '</a></h3>' +
                        '<p>' + libro.Descripcion + '</p>' +
                        '<p>Precio: ' + libro.Precio + '</p>' +
                        '<img src="' + libro.Imagen + '" alt="' + libro.Titulo + '">'
                    );
                    contenedor.append(libroHTML);
                });
            },
            error: function(error) {
                console.log(error);
                alert('Hubo un error al cargar los libros. Por favor, inténtalo de nuevo más tarde.');
            }
});