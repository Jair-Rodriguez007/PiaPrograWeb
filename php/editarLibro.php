<?php
require_once 'config.php';

if(isset($_POST)){
    $id = $_POST['bookId'];  // Asegúrate de que este valor se está enviando correctamente
    $nombre = $_POST['editName'];
    $descripcion = $_POST['editDescription'];
    $precio = $_POST['editPrice'];
    $categoria = intval($_POST['editCategory']);
    $cantidad = $_POST['editQuantity'];

    echo gettype($categoria);
    echo 'El id del libro es: '.$id;

    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }

    $sql = "UPDATE Producto SET Titulo = '$nombre', Descripcion = '$descripcion', CategoriaPrincipal = $categoria, Precio = $precio, CantidadInventario = $cantidad WHERE IdProducto = $id";
    if ($conexion->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
    header('Location: /PiaPrograWeb/html/pantallaAdmin4.html');
}
?>