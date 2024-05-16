<?php
session_start();
require_once 'config.php';

$conexion = conexionDb::conexion();
  if ($conexion->connect_error) {
      die("Connection failed: " . $conexion->connect_error);
  }

$idUsuario = $_SESSION['id'];

// Consulta para obtener los pedidos pendientes
//$sql = "SELECT * FROM compra WHERE estado = 'Pendiente'";
$sql = "SELECT Venta.IdVenta, Producto.Titulo, DetalleVenta.Cantidad, Venta.FechaVenta, MetodoPago.NombreMetodo, Usuario.*
        FROM Venta
        INNER JOIN DetalleVenta ON Venta.IdVenta = DetalleVenta.IdVenta
        INNER JOIN Producto ON DetalleVenta.IdProducto = Producto.IdProducto
        INNER JOIN MetodoPago ON Venta.MetodoPago = MetodoPago.IdMetodo
        INNER JOIN Usuario ON Venta.IdUsuario = Usuario.IdUsuario
        WHERE Venta.IdUsuario = $idUsuario AND Venta.Estado = 1";

$resultado = $conexion->query($sql);

$pedidos = array();

if ($resultado->num_rows > 0) {
    // Agregamos cada pedido pendiente al array
    while($pedido = $resultado->fetch_assoc()) {
        $pedidos[] = $pedido;
    }
}

echo json_encode($pedidos);

$conexion->close();

?>