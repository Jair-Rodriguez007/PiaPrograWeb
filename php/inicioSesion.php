<?php
require_once 'config.php';

if(isset($_POST)){

  $email = $_POST['email'];
  $password = $_POST['password'];

  $conexion = conexionDb::conexion();
  if ($conexion->connect_error) {
      die("Connection failed: " . $conexion->connect_error);
  }

  // Modificar la consulta SQL para obtener también el Rol del usuario
  $sql = "SELECT IdUsuario, Rol FROM Usuario WHERE CorreoElectronico='$email' AND Contrasena='$password'";
  $result = $conexion->query($sql);

  if ($result->num_rows > 0) {
    // El usuario existe, iniciar sesión
    session_start();
    $_SESSION['loggedin'] = true;
    // Obtener el ID_usuario y el Rol
    $row = $result->fetch_assoc();
    $_SESSION['id'] = $row['IdUsuario'];
    $_SESSION['rol'] = $row['Rol'];

    // Redirigir a la página correspondiente según el Rol
    if ($_SESSION['rol'] == 2) {
        header("Location: /PiaPrograWeb/html/pantalla3.html");
    } else {
        header("Location: /PiaPrograWeb/html/pantallaAdmin1.html");
    }
  } else {
    // El usuario no existe
    echo "Usuario o contraseña incorrectos";
  }
}
?>