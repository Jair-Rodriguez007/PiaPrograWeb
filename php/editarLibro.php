<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['bookId']);  // Asegúrate de que este valor se está enviando correctamente
    $nombre = $_POST['editName'];
    $descripcion = $_POST['editDescription'];
    $precio = $_POST['editPrice'];
    $categoria = intval($_POST['editCategory']);
    $cantidad = $_POST['editQuantity'];

    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }

    // Manejar la subida de la imagen
    if ($_FILES['editImage']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['editImage']['tmp_name'];
        $imageName = basename($_FILES['editImage']['name']);
        $imageDir = 'C:/xampp/htdocs/PiaPrograWeb/img/'; // Asegúrate de actualizar esta ruta
        $imagePath = $imageDir . $imageName;

        // Ruta relativa para guardar en la base de datos
        $relativeImagePath = '/PiaPrograWeb/img/' . $imageName;

        // Mueve el archivo subido a la ubicación deseada
        if (move_uploaded_file($imageTmpPath, $imagePath)) {
            // Actualiza el registro del libro con la nueva imagen
            $sql = "UPDATE Producto SET Titulo = '$nombre', Descripcion = '$descripcion', CategoriaPrincipal = $categoria, Precio = $precio, CantidadInventario = $cantidad, Imagen = '$relativeImagePath' WHERE IdProducto = $id";
        } else {
            echo "Error al mover el archivo subido.";
            exit();
        }
    } else {
        // Si no se sube una nueva imagen, no actualiza el campo de la imagen
        $sql = "UPDATE Producto SET Titulo = '$nombre', Descripcion = '$descripcion', CategoriaPrincipal = $categoria, Precio = $precio, CantidadInventario = $cantidad WHERE IdProducto = $id";
    }

    if ($conexion->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
    header('Location: /PiaPrograWeb/html/pantallaAdmin4.html');
    exit();
}
?>