$('#btnBuscar').click(function(event) {
    event.preventDefault();

    $.get('/PiaPrograWeb/php/buscarLibros.php', { searchName: $('#searchName').val() }, function(data) {
        var books = JSON.parse(data);
        console.log(data);
        console.log(books);

        for (var i = 0; i < books.length; i++) {
            var book = books[i];
            console.log(book);
            var bookElement = $('<div>').text(book.Titulo);
            var editButton = $('<button>').text('Editar').addClass('btn btn-primary edit-button').attr('data-book-id', book.ID_obra).attr('data-toggle', 'modal').attr('data-target', '#editBookModal');
            bookElement.append(editButton);
            $('#divContenedor').append(bookElement);
        }

        $(document).on('click', '.edit-button', function() {
            var bookId = $(this).attr('data-book-id');
            console.log(bookId);
            $('#editBookModal').attr('data-book-id', bookId);
            $('#editBookModal').modal('show');

                $('#editName').val(books[0].titulo);
                $('#editDescription').val(books[0].descripcion);
                $('#editPrice').val(books[0].precio);
                $('#editCategory').val(books[0].categoria_principal);
                $('#editQuantity').val(books[0].cantidad_inventario);
                $('#bookId').val(bookId);
        });
    });
});