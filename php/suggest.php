<?php
session_start();
require_once 'config.php';

//crear conexión
$conexion = conexionDb::conexion();
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

if (isset($_GET['search'])) {
    // Si se proporciona una consulta de búsqueda, selecciona los libros que corresponden a esa consulta
    $searchQuery = $_GET['search'];
    $sql = "SELECT Producto.Titulo, Producto.IdProducto FROM Producto WHERE Producto.Titulo LIKE '%$searchQuery%'";
    $result = $conexion->query($sql);
    $libros = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $libros[] = $row;
        }
    }
    header('Content-Type: application/json');
    echo json_encode($libros);
} else {
    // El resto de tu código existente...
}
$conexion->close();
?>
