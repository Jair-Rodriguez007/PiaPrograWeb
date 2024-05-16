<?php
require_once 'config.php';

$conexion = conexionDb::conexion();
  if ($conexion->connect_error) {
      die("Connection failed: " . $conexion->connect_error);
  }

$idVenta = $_POST['IdVenta'];
$estado = 2;

// Consulta para obtener los pedidos pendientes
$sql = "UPDATE Venta SET Estado = '$estado' WHERE IdVenta = $idVenta";

$resultado = $conexion->query($sql);

if ($result) {
    echo 'Los datos de la compra se han actualizado correctamente.';
} else {
    echo 'Hubo un error al actualizar los datos de la compra: ' . $conexion->error;
}

// Cierra la conexión
$conexion->close();
?>