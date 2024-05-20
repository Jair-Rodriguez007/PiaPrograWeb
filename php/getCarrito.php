<?php
session_start();
require_once 'config.php';

//crear conexión
$conexion = conexionDb::conexion();
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

$id = $_SESSION['id'];

$sql = "SELECT Carrito.*, Producto.* 
        FROM Carrito 
        INNER JOIN Producto ON Carrito.IdProducto = Producto.IdProducto 
        WHERE Carrito.IdUsuario = $id";


    $result = $conexion->query($sql);
    $carrito = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $carrito[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($carrito);
    } else {
        echo json_encode(array());
    }
$conexion->close();
?>