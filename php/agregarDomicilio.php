<?php
    session_start();
    require_once "config.php";

    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }

    if(isset($_POST)){
        $idUsuario = $_SESSION['id'];
        $calle = $_POST['Calle'];
        $estado = $_POST['Estado'];
        $pais = $_POST['Pais'];
        $numeroExt = $_POST['NumeroExt'];   
        $numeroInt = $_POST['NumeroInt'];     

        echo "El id del usuario es: ".$idUsuario;

        $sql = "INSERT INTO Domicilio (IdUsuario, Calle, Estado, Pais, NumeroExt, NumeroInt) 
        VALUES ($idUsuario, '$calle', '$estado', '$pais', $numeroExt, $numeroInt)";

        if ($conexion->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
        header('Location: /PiaPrograWeb/html/pantalla6.html');
    }
?>