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
    }).fail(function(xhr, status, error) {
        alert(error)
    });
}

$(document).ready(function() {
    traerDomicilio();
    traerTarjeta();
    traerCarrito();
});