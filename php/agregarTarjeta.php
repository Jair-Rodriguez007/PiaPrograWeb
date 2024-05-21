<?php
    session_start();
    require_once "config.php";

    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }

    if(isset($_POST)){
        $idUsuario = $_SESSION['id'];
        $idMetodo = 2;
        $numTarjeta = $_POST['numTarjeta'];
        $fechaExp = $_POST['fechaExp'];
        $cvv = $_POST['cvv'];       

        echo "El id del usuario es: ".$idUsuario;

        $sql = "INSERT INTO Tarjeta (IdUsuario, IdMetodo, NumeroTarjeta, FechaExpiracion, CVV) 
        VALUES ($idUsuario, $idMetodo, $numTarjeta, '$fechaExp', $cvv)";

        if ($conexion->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
        header('Location: /PiaPrograWeb/html/pantalla6.html');
    }
?>