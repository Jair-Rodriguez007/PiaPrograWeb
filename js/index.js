function generarHTML(libro) {
    var libroHTML = $('<div/>', { class: 'col-sm-4' });
    libroHTML.html(
        '<h3><a href="pantalla4.html?idLibro=' + libro.IdProducto + '">' + libro.Titulo + '</a></h3>' +
        '<img src="' + libro.Imagen + '" alt="' + libro.Titulo + '" class="book-image">' +
        '<p>' + libro.Descripcion + '</p>' +
        '<p>Precio: ' + libro.Precio + '</p>'
    );
    return libroHTML;
}

$.ajax({
    url: '/PiaPrograWeb/php/getLibros.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        var contenedorVistos = $('#vistos');

        let vistos = data.vistos.slice(0, 3); // Aquí limitamos a los primeros tres libros

        console.log(data);

        vistos.forEach(function(libro) {
            var libroHTML = generarHTML(libro);
            contenedorVistos.append(libroHTML);
        });
    },
    error: function(error) {
        console.log(error);
        alert('Hubo un error al cargar los libros. Por favor, inténtalo de nuevo más tarde.');
    }
});