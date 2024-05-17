//var params = new URLSearchParams(window.location.search);
//var idUsuario = params.get('id');
$.ajax({
    url: '/PiaPrograWeb/php/getLibros.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        var contenedorRecientes = $('#recientes');
        var contenedorVistos = $('#vistos');

        let recientes = data.recientes;

        console.log(data); // Aquí estaba el error, debe ser 'data' en lugar de 'datos'

        for (let i = 0; i < recientes.length; i++) {
            let libro = recientes[i];
            var libroHTML = generarHTML(libro);
            contenedorRecientes.append(libroHTML);
        }

        let vistos = data.vistos; // Aquí estaba el error, debe ser 'data.vistos' en lugar de 'data[vistos]'

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

function generarHTML(libro) {
    var libroHTML = $('<div/>', { class: 'col-md-4' });
    libroHTML.html(
        '<h3><a href="' + 'pantalla4.html?idLibro=' + libro.IdProducto + '">' + libro.Titulo + '</a></h3>' +
        '<p>' + libro.Descripcion + '</p>' +
        '<p>Precio: ' + libro.Precio + '</p>' +
        '<img src="' + libro.Imagen + '" alt="' + libro.Titulo + '">'
    );
    return libroHTML;
}

//Código para buscar libros

document.getElementById('search').addEventListener('input', function() {
    var searchQuery = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/PiaPrograWeb/php/suggest.php?search=' + searchQuery, true);
    xhr.onload = function() {
        if (this.status == 200) {
            var data = JSON.parse(this.responseText);
            var suggestions = document.getElementById('suggestions');
            suggestions.innerHTML = '';
            data.forEach(function(item) {
                var a = document.createElement('a');
                a.textContent = item.Titulo;
                a.href = '/PiaPrograWeb/html/pantalla4.html?idLibro=' + item.IdProducto;
                suggestions.appendChild(a);
            });
        }
    }
    xhr.send();
});