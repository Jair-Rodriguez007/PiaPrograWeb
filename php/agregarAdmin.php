<?php
require_once 'config.php';

if(isset($_POST)){
    $nombre = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $check = $_POST['admin'];

    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }

    if ($check) {
        $rol = 4;
    } else {
        $rol = 3;
    }

    $sql = "INSERT INTO Usuario (Nombre, CorreoElectronico, Contrasena, Rol) VALUES 
    ('$nombre', '$email', '$password', $rol)";
    if ($conexion->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
    header('Location: /PiaPrograWeb/html/index.html');
}
?>