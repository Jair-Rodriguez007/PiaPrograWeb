$.ajax({
    url: '/PiaPrograWeb/php/getPedidosPendientes.php',
    type: 'GET',
    dataType: 'json',
    success: function(pedidos) {
        var contenedor = $('#pedidosPendientes');
        pedidos.forEach(function(pedido) {
            console.log(pedido);
            var pedidoDiv = $('<div class="pedido"></div>');
            pedidoDiv.append('<h5>Pedido #' + pedido.IdVenta +' '+ pedido.Titulo + '</h5>');
            pedidoDiv.append('<p>#' + pedido.IdUsuario + ' ' + pedido.Nombre +' </p></br>');
            pedidoDiv.append('<p>Método de pago: ' + pedido.NombreMetodo +' </p></br>');
            contenedor.append(pedidoDiv);

            // Agrega un evento de clic a cada pedido
            pedidoDiv.click(function() {
                var contenedorPedido = $('#contenedorPedido');
                contenedorPedido.empty(); // Limpia el contenedor
                contenedorPedido.append('<h2>Libros seleccionados</h2>');
                contenedorPedido.append('<h5>Pedido #' + pedido.IdVenta +' '+ pedido.Titulo + '</h5>');
                contenedorPedido.append('<p>#' + pedido.IdUsuario + ' ' + pedido.Nombre +' </p></br>');
                contenedorPedido.append('<p>Método de pago: ' + pedido.NombreMetodo +' </p></br>');
                var btnCancelar = $('<button class="btn btn-danger" id="btnCancelar">Cancelar pedido</button>');
                var btnEntregado = $('<button class="btn btn-success" id="btnEntregado">Declarar como entregado</button>');
                btnEntregado.data('IdVenta', pedido.IdVenta); // Almacena el ID_compra en el botón
                btnCancelar.data('IdVenta', pedido.IdVenta); // Almacena el ID_compra en el botón
                contenedorPedido.append(btnEntregado);
                contenedorPedido.append(btnCancelar);
            });
        });

        // Asigna un controlador de eventos al botón "Declarar como entregado"
        $(document).on('click', '#btnEntregado', function() {
            var IdVenta = $(this).data('IdVenta'); // Recupera el ID_compra del botón
            $.ajax({
                url: '/PiaPrograWeb/php/entregarPedido.php',
                type: 'POST',
                data: {
                    'IdVenta': IdVenta
                },
                success: function(response) {
                    alert('El estado del pedido ha sido actualizado a entregado');
                },
                error: function() {
                    alert('Hubo un error al actualizar el estado del pedido');
                }
            });
        });

        // Asigna un controlador de eventos al botón "Cancelar Pedido"
        $(document).on('click', '#btnCancelar', function() {
            var IdVenta = $(this).data('IdVenta'); // Recupera el ID_compra del botón
            console.log(IdVenta);
            $.ajax({
                url: '/PiaPrograWeb/php/cancelarPedido.php',
                type: 'POST',
                data: { 'IdVenta': IdVenta },
                success: function(response) {
                    alert('El estado del pedido ha sido cambiado a cancelado');
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