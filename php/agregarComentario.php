<?php
session_start();
require_once 'config.php';

if(isset($_POST)){
    $idUsuario = $_SESSION['id'];
    $idProducto = $_POST['idLibro'];
    $fechaComentario = date('Y-m-d H:i:s');

    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }

    // Escapar los valores
    $comentario = mysqli_real_escape_string($conexion, $_POST['comment']);
    $idUsuario = intval($idUsuario); // Asegurar que sea un entero
    $idProducto = intval($idProducto); // Asegurar que sea un entero

    $sql = "INSERT INTO Comentario (IdUsuario, IdProducto, TextoComentario, FechaComentario) 
    VALUES ($idUsuario, $idProducto, '$comentario', '$fechaComentario')";
    if ($conexion->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
    header('Location: /PiaPrograWeb/html/pantalla4.html?idLibro='.$idProducto);
}
?>