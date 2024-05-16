function traerPedidos() {
    $.ajax({
        url:"/PiaPrograWeb/php/getPedido.php",
        type:'GET',
        dataType:'json',
        crossDomain:true
    }).done(function(result) {
        $(result).each(function(index) {
            $('#historial').append('<p>' + this.Titulo + ': ' + this.Cantidad + ' ('+this.FechaVenta+')</p>');
        });
        console.log(result);
    }).fail(function(xhr, status, error) {
        alert(error)
    });
}

$(document).ready(function() {
    traerPedidos();
});