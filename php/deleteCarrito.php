<?php
    session_start();
    require_once "config.php";

    //crear conexión
    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }

    $idLibro = $_POST['idProducto'];
    $idUsuario = $_SESSION['id'];

    $sql = "DELETE FROM Carrito WHERE IdUsuario = $idUsuario AND IdProducto = $idLibro";
    
    if ($conexion->query($sql) === TRUE) {
        echo "Se ha eliminado el producto del usuario";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }

?>