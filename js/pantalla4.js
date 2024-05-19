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
            $('#categoria-libro').text('Categorías: ' + libro.NombreCategoria);
            // Mostrar las categorías secundarias (puedes adaptar esto según tu estructura de datos)
            libro.CategoriasSecundarias.forEach(function(categoria) {
                console.log(categoria);
                $('#categoria-libro').append(', ' + categoria);
            });
            $('#imagen-libro').attr('src', libro.Imagen);
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

    //Establece el id del libro para los comentarios
    document.getElementById("idLibro").value = id;

    $.ajax({
        url: '/PiaPrograWeb/php/getComentarios.php',
        type: 'GET',
        data: {
            id: id
        },
        dataType: 'json',
        success: function(comentario) {
            console.log(comentario);
            comentario.forEach(comentario => {
                console.log(comentario.TextoComentario); // Muestra el texto del comentario en la consola
                $('#comentarios').append(`
                    <div class="card mb-3">
                        <div class="card-body">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                        <small>
                            <span class="me-1"><i class="fas fa-calendar-alt"></i>${comentario.FechaComentario}</span>
                        </small>
                        </div>
                            <p></p>
                            <p class="card-text">${comentario.TextoComentario}</p>
                            <div class="d-flex w-100 justify-content-between align-items-center">
                            <small>
                                <span class="me-1" id="txtUsuario"><i class="fa fa-user"></i>${comentario.Nombre}</span>
                            </small>
                            </div>
                        </div>
                    </div>
                `); // Inserta el comentario en una tarjeta de Bootstrap
            });
        },
        error: function(error) {
            console.log(error);
            alert('Hubo un error al cargar los comentarios del libro. Por favor, inténtalo de nuevo más tarde.');
        }
    });
});