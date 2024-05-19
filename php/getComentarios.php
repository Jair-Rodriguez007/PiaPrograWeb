<?php
session_start();
require_once 'config.php';

$conexion = conexionDb::conexion();
  if ($conexion->connect_error) {
      die("Connection failed: " . $conexion->connect_error);
  }

$idProducto = $_GET['id'];

// Consulta para obtener los pedidos pendientes
//$sql = "SELECT * FROM compra WHERE estado = 'Pendiente'";
$sql = "SELECT Comentario.*, Usuario.Nombre 
        FROM Comentario 
        INNER JOIN Usuario ON Comentario.IdUsuario = Usuario.IdUsuario 
        WHERE Comentario.IdProducto = $idProducto";

$resultado = $conexion->query($sql);

$comentarios = array();

if ($resultado->num_rows > 0) {
    // Agregamos cada pedido pendiente al array
    while($comentario = $resultado->fetch_assoc()) {
        $comentarios[] = $comentario;
    }
}

echo json_encode($comentarios);

$conexion->close();

?>