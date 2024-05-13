<?php
require_once 'config.php';

//crear conexión
$conexion = conexionDb::conexion();
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

if (isset($_GET['id'])) {
    // Si se proporciona un ID, selecciona solo el libro que corresponde a ese ID
    $id = $_GET['id'];
    //$sql = "SELECT * FROM Obra WHERE ID_obra = $id";
    $sql = "SELECT Producto.*, Categoria.NombreCategoria FROM Producto INNER JOIN Categoria ON Producto.CategoriaPrincipal = Categoria.IdCategoria WHERE Producto.IdProducto = $id";
    $result = $conexion->query($sql);
    $libro = $result->fetch_assoc();
    header('Content-Type: application/json');
    echo json_encode($libro);
} else {
    // Si no se proporciona un ID, selecciona todos los libros
    $sql = "SELECT * FROM Producto";
    $result = $conexion->query($sql);
    $libros = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $libros[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($libros);
    } else {
        echo "0 results";
    }
}
$conexion->close();
?>