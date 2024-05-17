<?php
require_once 'config.php';

if(isset($_POST)){
    $nombre = $_POST['name'];
    $descripcion = $_POST['description'];
    $precio = $_POST['price'];
    $categoria = intval($_POST['category']);
    $cantidad = $_POST['quantity'];
    $fechaAgregado = date('Y-m-d H:i:s');
    $imagen = 'imagen132.jpg';

    echo gettype($categoria);

    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }

    $sql = "INSERT INTO Producto (Titulo, Descripcion, CategoriaPrincipal, Precio, CantidadInventario, Imagen, FechaAgregado) 
    VALUES ('$nombre', '$descripcion', $categoria, $precio, $cantidad, '$imagen', '$fechaAgregado')";
    if ($conexion->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
    header('Location: /PiaPrograWeb/html/pantallaAdmin4.html');
}
?>