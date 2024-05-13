<?php
require_once 'config.php';

if(isset($_POST)){

  $email = $_POST['email'];
  $password = $_POST['password'];

  $conexion = conexionDb::conexion();
  if ($conexion->connect_error) {
      die("Connection failed: " . $conexion->connect_error);
  }

  $sql = "SELECT IdUsuario FROM Usuario WHERE CorreoElectronico='$email' AND Contrasena='$password'";
  $result = $conexion->query($sql);

  if ($result->num_rows > 0) {
    // El usuario existe, iniciar sesión
    session_start();
    $_SESSION['loggedin'] = true;
    // Obtener el ID_usuario
    $row = $result->fetch_assoc();
    $_SESSION['id'] = $row['IdUsuario'];
    header("Location: pantalla3.html"); // Redirigir a la siguiente página
  } else {
    // El usuario no existe
    echo "Usuario o contraseña incorrectos";
  }
}
?>