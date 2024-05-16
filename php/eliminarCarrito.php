<?php
    session_start();
    require_once "config.php";

    //crear conexión
    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }
    
    if(isset($_POST)) {
        $idUsuario = $_SESSION['id'];
        $eliminarTodo = isset($_POST['eliminarTodo']) ? $_POST['eliminarTodo'] : false;
    
        if($eliminarTodo) {
            $sql = "DELETE FROM Carrito WHERE IdUsuario = $idUsuario";
        } else {
            $idLibro = $_POST['IdProducto'];
            $sql = "DELETE FROM Carrito WHERE IdUsuario = $idUsuario AND IdProducto = $idLibro";
        }
    
        if ($conexion->query($sql) === TRUE) {
            echo "Se han eliminado los productos del usuario";
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
    }
?>