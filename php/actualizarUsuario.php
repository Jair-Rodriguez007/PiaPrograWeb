<?php
session_start();
require_once 'config.php';

// Crear conexión
$conexion = conexionDb::conexion();
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

$id = $_SESSION['id'];

// Recibir los datos del formulario
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Crear la consulta SQL
$sql = "UPDATE Usuario SET ";
if (!empty($name)) {
    $sql .= "Nombre = '$name', ";
}
if (!empty($email)) {
    $sql .= "CorreoElectronico = '$email', ";
}
if (!empty($password)) {
    $sql .= "Contrasena = '$password', ";
}

// Eliminar la última coma y agregar la cláusula WHERE
$sql = rtrim($sql, ', ') . " WHERE IdUsuario = $id";

// Ejecutar la consulta
if ($conexion->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conexion->error;
}

$conexion->close();
?>
