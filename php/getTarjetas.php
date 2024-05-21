<?php
session_start();
require_once 'config.php';

//crear conexión
$conexion = conexionDb::conexion();
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

$id = $_SESSION['id'];

    $sql = "SELECT * FROM Tarjeta WHERE IdUsuario = $id";
    $result = $conexion->query($sql);
    $tarjetas = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $tarjetas[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($tarjetas);
    } else {
        echo json_encode(array());
    }
$conexion->close();
?>