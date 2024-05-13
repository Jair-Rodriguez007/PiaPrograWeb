<?php
require_once 'config.php';

if(isset($_POST)){
    $nombre = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }

    $sql = "INSERT INTO Usuario (Nombre, CorreoElectronico, Contrasena, Rol) VALUES 
    ('$nombre', '$email', '$password', 2)";
    if ($conexion->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
    header('Location: index.html');
}
?>