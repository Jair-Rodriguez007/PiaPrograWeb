<?php
session_start();
require_once 'config.php';

//crear conexión
$conexion = conexionDb::conexion();
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

$id = $_SESSION['id'];

    $sql = "SELECT * FROM Usuario WHERE IdUsuario = $id";
    $result = $conexion->query($sql);
    $usuarios = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($usuarios);
    } else {
        echo "0 results";
    }
$conexion->close();
?>