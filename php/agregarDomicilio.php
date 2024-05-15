<?php
    session_start();
    require_once "config.php";

    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }

    if(isset($_POST)){
        $idUsuario = $_SESSION['id'];
        $calle = $_POST['calle'];
        $estado = $_POST['estado'];
        $pais = $_POST['pais'];
        $numeroExt = intval($_POST['numeroExt']);
        $numeroInt = intval($_POST['numeroInt']);        

        echo "El id del usuario es: ".$idUsuario;

        $sql = "INSERT INTO Domicilio (IdUsuario, Calle, Estado, Pais, NumeroExt, NumeroInt) 
        VALUES ($idUsuario, '$calle', '$estado', '$pais', $numeroExt, $numeroInt)";

        if ($conexion->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
    }
?>