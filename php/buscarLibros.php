<?php
require_once 'config.php';

$conexion = conexionDb::conexion();
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

    $search_name = $_GET['searchName'];

    $sql = "SELECT * FROM Producto WHERE Titulo LIKE '%$search_name%'";
    $result = $conexion->query($sql);

    $books = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }

    echo json_encode($books);

    $conexion->close();
?>