<?php
    session_start();
    require_once "config.php";

    //crear conexión
    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }
    
    $idUsuario = $_SESSION['id'];
    
    $sql = "DELETE FROM Carrito WHERE IdUsuario = $idUsuario";
    
    if ($conexion->query($sql) === TRUE) {
        echo "Se han eliminado los productos del usuario";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
    header("Location: /PiaPrograWeb/html/pantalla5.html");
?>