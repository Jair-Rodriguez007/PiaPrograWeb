$.ajax({
    url: '/PiaPrograWeb/php/getPedidosPendientes.php',
    type: 'GET',
    dataType: 'json',
    success: function(pedidos) {
        var contenedor = $('#pedidosPendientes');
        pedidos.forEach(function(pedido) {
            console.log(pedido);
            var pedidoDiv = $(`
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-text">Pedido: ${pedido.IdVenta}</h5>
                        <p class="card-text">Usuario: ${pedido.IdUsuario} ${pedido.Nombre}</p>
                        <p class="card-text">Método de pago: ${pedido.NombreMetodo}</p>
                    </div>
                </div>
            `);
            contenedor.append(pedidoDiv);
        
            // Agrega un evento de clic a cada pedido
            pedidoDiv.click(function() {
                var contenedorPedido = $('#contenedorPedido');
                contenedorPedido.empty(); // Limpia el contenedor
                contenedorPedido.append('<h2>Libros seleccionados</h2>');
                var btnPedido = $(`
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-text">Pedido: ${pedido.IdVenta}</h5>
                        <p class="card-text">Usuario: ${pedido.IdUsuario} ${pedido.Nombre}</p>
                        <p class="card-text">Método de pago: ${pedido.NombreMetodo}</p>
                        <button class="btn btn-danger" id="btnCancelar" data-idventa="${pedido.IdVenta}">Cancelar pedido</button>
                        <button class="btn btn-success" id="btnEntregado" data-idventa="${pedido.IdVenta}">Declarar como entregado</button>
                    </div>
                </div>
            `);
            contenedorPedido.append(btnPedido); // Clona y agrega la tarjeta del pedido
            });
        });        

        // Asigna un controlador de eventos al botón "Declarar como entregado"
        $(document).on('click', '#btnEntregado', function() {
            var IdVenta = $(this).data('idventa'); // Recupera el ID_compra del botón
            console.log(IdVenta);
            $.ajax({
                url: '/PiaPrograWeb/php/entregarPedido.php',
                type: 'POST',
                data: {
                    'IdVenta': IdVenta
                },
                success: function(response) {
                    alert('El estado del pedido ha sido actualizado a entregado');
                    location.reload(true);
                },
                error: function() {
                    alert('Hubo un error al actualizar el estado del pedido');
                }
            });
        });

        // Asigna un controlador de eventos al botón "Cancelar Pedido"
        $(document).on('click', '#btnCancelar', function() {
            var IdVenta = $(this).data('idventa'); // Recupera el ID_compra del botón
            console.log(IdVenta);
            $.ajax({
                url: '/PiaPrograWeb/php/cancelarPedido.php',
                type: 'POST',
                data: { 'IdVenta': IdVenta },
                success: function(response) {
                    alert('El estado del pedido ha sido cambiado a cancelado');
                    location.reload(true);
                },
                error: function() {
                    alert('Hubo un error al cancelar el pedido');
                }
            });
        });
    },
    error: function(error) {
        console.log(error);
    }
});