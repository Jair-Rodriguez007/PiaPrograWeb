function generarHTML(libro) {
    var libroHTML = $('<div/>', { class: 'col-md-4' });
    libroHTML.html(
        '<h3><a href="pantalla4.html?idLibro=' + libro.IdProducto + '">' + libro.Titulo + '</a></h3>' +
        '<img src="' + libro.Imagen + '" alt="' + libro.Titulo + '" class="book-image">' +
        '<p>' + libro.Descripcion + '</p>' +
        '<p>Precio: ' + libro.Precio + '</p>'
    );
    return libroHTML;
}

function agregarLibrosACarruselRecientes(libros) {
    var $carouselInner = $('#recientes');
    var $currentItem;
    var $row;

    libros.forEach(function(libro, index) {
        if (index % 3 === 0) {
            $currentItem = $('<div/>', { class: 'carousel-item' + (index === 0 ? ' active' : '') });
            $row = $('<div/>', { class: 'row' });
            $carouselInner.append($currentItem);
            $currentItem.append($row);
        }
        $row.append(generarHTML(libro));
    });
}

function agregarLibrosACarruselVistos(libros) {
    var $carouselInner = $('#vistos');
    var $currentItem;
    var $row;

    libros.forEach(function(libro, index) {
        if (index % 3 === 0) {
            $currentItem = $('<div/>', { class: 'carousel-item' + (index === 0 ? ' active' : '') });
            $row = $('<div/>', { class: 'row' });
            $carouselInner.append($currentItem);
            $currentItem.append($row);
        }
        $row.append(generarHTML(libro));
    });
}

$.ajax({
    url: '/PiaPrograWeb/php/getLibros.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        //var contenedorVistos = $('#vistos');

        let recientes = data.recientes;
        let vistos = data.vistos;

        console.log(data);

        agregarLibrosACarruselRecientes(recientes);
        agregarLibrosACarruselVistos(vistos);

        /*vistos.forEach(function(libro) {
            var libroHTML = generarHTML(libro);
            contenedorVistos.append(libroHTML);
        });*/
    },
    error: function(error) {
        console.log(error);
        alert('Hubo un error al cargar los libros. Por favor, inténtalo de nuevo más tarde.');
    }
});

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