function traerPedidos() {
    $.ajax({
        url:"/PiaPrograWeb/php/getPedido.php",
        type:'GET',
        dataType:'json',
        crossDomain:true
    }).done(function(result) {
        $(result).each(function(index) {
            $('#historial').append(`
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text">Producto: ${this.Titulo}</p>
                        <p class="card-text">Cantidad: ${this.Cantidad}</p>
                        <div class="d-flex w-100 justify-content-between align-items-center">
                        <small>
                            <span class="me-1"><i class="fas fa-calendar-alt"></i> ${this.FechaVenta}</span>
                        </small>
                        </div>
                    </div>
                </div>
            `); // Inserta el comentario en una tarjeta de Bootstrap
        });
        console.log(result);
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
            $("#name").val(item.Nombre);
            $("#email").val(item.CorreoElectronico);
            $("#password").val(item.Contrasena);
        });
        console.log(result);
    }).fail(function(xhr, status, error) {
        alert(error)
    });
}

$(document).ready(function() {
    traerPedidos();
    traerUsuario();
});