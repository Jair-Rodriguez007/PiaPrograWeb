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
            $('#carrito').append(`
            <div class="card mb-3">
                <div class="card-body">
                    <p class="card-text">Producto: ${this.Titulo}</p>
                    <p class="card-text">Cantidad: ${this.Cantidad}</p>
                    <button class="eliminar" data-id="${this.IdProducto}">Eliminar</button>
                </div>
            </div>
        `); // Inserta el comentario en una tarjeta de Bootstrap
        });
        console.log("result es: ");
        console.log(result);
        //Botón eliminar
        $('.eliminar').click(function() {
            var idLibro = $(this).data('id');
            console.log(idLibro);

            $.ajax({
                url: '/PiaPrograWeb/php/deleteCarrito.php',
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

function traerUsuario() {
    $.ajax({
        url:"/PiaPrograWeb/php/getUsuarios.php",
        type:'GET',
        dataType:'json',
        crossDomain:true
    }).done(function(result) {
        $(result).each(function(index, item) {
            console.log(item.Nombre);
            $("#name").append(`<input type="text" class="form-control" id="name" name="name" placeholder="${item.Nombre}" required readonly>`);
            $("#correo").append(`<input type="text" class="form-control" id="correo" name="correo" placeholder="${item.CorreoElectronico}" required readonly>`);
        });
        console.log(result);
    }).fail(function(xhr, status, error) {
        alert(error)
    });
}

$(document).ready(function() {
    traerDomicilio();
    traerTarjeta();
    traerCarrito();
    traerUsuario();
});