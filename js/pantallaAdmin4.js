$('#btnBuscar').click(function(event) {
    event.preventDefault();

    $.get('/PiaPrograWeb/php/buscarLibros.php', { searchName: $('#searchName').val() }, function(data) {
        var books = JSON.parse(data);
        console.log(data);
        console.log(books);

        for (var i = 0; i < books.length; i++) {
          var book = books[i];
          console.log(book);
          var bookElement = $('<div>').addClass('card mb-3').append(
              $('<div>').addClass('card-body').append(
                  $('<h5>').addClass('card-text').text(book.Titulo),
                  $('<button>').text('Editar').addClass('btn btn-primary edit-button').attr({
                      'data-book-id': book.IdProducto,
                      'data-toggle': 'modal',
                      'data-target': '#editBookModal'
                  })
              )
          );
          $('#divContenedor').append(bookElement);
      }
      

        $(document).on('click', '.edit-button', function() {
            var bookId = $(this).attr('data-book-id');
            console.log(bookId);
            $('#editBookModal').attr('data-book-id', bookId);
            $('#editBookModal').modal('show');

                $('#editName').val(books[0].Titulo);
                $('#editDescription').val(books[0].Descripcion);
                $('#editPrice').val(books[0].Precio);
                $('#editCategory').val(books[0].CategoriaPrincipal);
                $('#editQuantity').val(books[0].CantidadInventario);
                $('#bookId').val(bookId);
        });
    });
});

function traerCategorias() {
    $.ajax({
        url:"/PiaPrograWeb/php/getCategorias.php",
        type:'GET',
        dataType:'json'
    }).done(function(result) {
        $(result).each(function(index) {
            console.log(this.NombreCategoria);
            $("#category").append(`<option value="${this.IdCategoria}">${this.NombreCategoria}</option>`);
            $("#editCategory").append(`<option value="${this.IdCategoria}">${this.NombreCategoria}</option>`);
        });
        console.log(result);
    }).fail(function(xhr, status, error) {
        alert(error)
    });
}

$(document).ready(function() {
    traerCategorias();;
    // Función para cargar los elementos
    function loadElements() {
      $.ajax({
        url: '/PiaPrograWeb/php/getCategorias.php', // Reemplaza con la URL de tu API
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
          // Ordena los registros por el value del ID
          data.sort((a, b) => a.IdCategoria - b.IdCategoria);
  
          let container = $('#dynamic-container');
          container.empty(); // Limpiamos el contenedor por si ya hay contenido
  
          // Variables para controlar las filas y columnas
          let columnIndex = 0;
          let rowIndex = 0;
  
          // Crear una fila inicial
          let row = $('<div class="row"></div>');
          container.append(row);
  
          // Iterar sobre los datos
          data.forEach((item, index) => {
            // Crear un nuevo elemento de columna
            let col = $(`<div class="col-md-4 mb-3">
                    <div class="card">
                    <div class="card-body">
                        <p class="card-text">${item.NombreCategoria}</p>
                        <div class="form-check">
                        <input class="form-check-input secondary-category" type="checkbox" id="checkbox-${item.IdCategoria}" value="${item.IdCategoria}">
                        <label class="form-check-label" for="checkbox-${item.IdCategoria}">
                            Seleccionar
                        </label>
                        </div>
                    </div>
                    </div>
                </div>`);
  
            // Agregar la columna a la fila actual
            row.append(col);
  
            // Incrementar el índice de columna
            columnIndex++;
  
            // Si tenemos 3 columnas, reiniciamos el índice de columna y creamos una nueva fila
            if (columnIndex === 3) {
              columnIndex = 0;
              rowIndex++;
              if (rowIndex < 5) {
                row = $('<div class="row"></div>');
                container.append(row);
              }
            }
          });
        },
        error: function(error) {
          console.error('Error al cargar los elementos:', error);
        }
      });
    }
  
    // Llamar a la función para cargar los elementos al cargar la página
    loadElements();
    
    // Manejar la selección de categorías secundarias
    $('form').on('submit', function(event) {
        let selectedCategories = [];
        $('.secondary-category:checked').each(function() {
        selectedCategories.push($(this).val());
        });
        $('#secondaryCategories').val(selectedCategories.join(','));
    });
  });
  
  $('#editBookModal').on('hidden.bs.modal', function (e) {
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
  })
  