<?php
require_once 'config.php';

//crear conexión
$conexion = conexionDb::conexion();
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

    $sql = "SELECT * FROM Categoria";
    $result = $conexion->query($sql);
    $categorias = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $categorias[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($categorias);
    } else {
        echo "0 results";
    }
$conexion->close();
?>