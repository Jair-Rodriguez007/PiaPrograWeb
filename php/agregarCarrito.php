<?php
    session_start();
    require_once "config.php";

    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }

    if(isset($_POST)){
        $idLibro = $_POST['idLibro'];
        $idUsuario = $_SESSION['id'];
        $cantidad = $_POST['cantidad'];

        $sql = "INSERT INTO Carrito (IdUsuario, IdProducto, Cantidad) VALUES ($idUsuario, $idLibro, $cantidad)";

        if ($conexion->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
    }
?>