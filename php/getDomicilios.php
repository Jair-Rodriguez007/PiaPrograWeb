<?php
session_start();
require_once 'config.php';

//crear conexión
$conexion = conexionDb::conexion();
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

$id = $_SESSION['id'];

    $sql = "SELECT * FROM Domicilio WHERE IdUsuario = $id";
    $result = $conexion->query($sql);
    $domicilios = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $domicilios[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($domicilios);
    } else {
        echo "0 results";
    }
$conexion->close();
?>