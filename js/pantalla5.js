function traerDomicilio() {
    $.ajax({
        url:"/PiaPrograWeb/php/getDomicilios.php",
        type:'GET',
        dataType:'json',
        crossDomain:true
    }).done(function(result) {
        $(result).each(function(index) {
            $("#address").append(`<option value="${this.IdDomicilio}">${this.Calle}</option>`);
        });
        console.log(result);
    }).fail(function(xhr, status, error) {
        alert(error)
    });
}

function traerTarjeta() {
    $.ajax({
        url:"/PiaPrograWeb/php/getTarjetas.php",
        type:'GET',
        dataType:'json',
        crossDomain:true
    }).done(function(result) {
        $(result).each(function(index) {
            $("#payment-method").append(`<option value="${this.IdTarjeta}">${this.NumeroTarjeta}</option>`);
        });
        console.log(result);
    }).fail(function(xhr, status, error) {
        alert(error)
    });
}

function traerCarrito() {
    $.ajax({
        url:"/PiaPrograWeb/php/getCarrito.php",
        type:'GET',
        dataType:'json',
        crossDomain:true
    }).done(function(result) {
        $(result).each(function(index) {
            $('#carrito').append('<p>' + this.Titulo + ': ' + this.Cantidad + '</p><button class="eliminar" data-id="' + this.IdProducto + '">Eliminar</button>');
        });
        console.log(result);
        //Botón eliminar
        $('.eliminar').click(function() {
            var idLibro = $(this).data('id');
            console.log(idLibro);

            $.ajax({
                url: 'eliminarCarrito.php',
                type: 'POST',
                data: { 
                    idProducto: idLibro
                },
                success: function() {
                    alert('Obra eliminada del carrito.');
                    location.reload();
                },
                error: function(error) {
                    console.log(error);
                    alert('Hubo un error al eliminar la obra del carrito. Por favor, inténtalo de nuevo más tarde.');
                }
            });
        });
    }).fail(function(xhr, status, error) {
        alert(error)
    });
}

/*$('#btnConfirmar').click(function() {
    var paymentMethod = $('#payment-method').val();
    console.log(paymentMethod);
    $.ajax({
        url: 'getCarrito.php',
        type: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(carrito) {
            console.log(carrito);
            carrito.forEach(function(item) {
                var idLibro = item.ID_obra;
                var cantidad = item.cantidad;
                console.log(idLibro);
                console.log(cantidad);
                $.ajax({
                    url: 'postCompra.php',
                    type: 'POST',
                    data: {
                        ID_usuario: id,
                        ID_obra: idLibro,
                        metodo_de_pago: paymentMethod,
                        cantidad: cantidad
                    },
                    success: function(response) {
                        console.log(response);
                        alert('Compra de libro con ID ' + idLibro + ' procesada con éxito.');
                    },
                    error: function(error) {
                        console.log(error);
                        alert('Hubo un error al procesar la compra del libro con ID ' + idLibro + '. Por favor, inténtalo de nuevo más tarde.');
                    }
                });
            });
        },
        error: function(error) {
            console.log(error);
            alert('Hubo un error al procesar la compra. Por favor, inténtalo de nuevo más tarde.');
        }
    });
    $.ajax({
        url: 'deleteCarrito.php',
        type: 'POST',
        data: { 
            ID_usuario: id,
            eliminarTodo: true
        },
        success: function() {
            alert('Obras eliminada del carrito.');
            location.reload();
        },
        error: function(error) {
            console.log(error);
            alert('Hubo un error al eliminar las obras del carrito. Por favor, inténtalo de nuevo más tarde.');
        }
    });
});*/

$(document).ready(function() {
    traerDomicilio();
    traerTarjeta();
    traerCarrito();
});