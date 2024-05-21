<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['name'];
    $descripcion = $_POST['description'];
    $precio = $_POST['price'];
    $categoria = intval($_POST['category']);
    $cantidad = $_POST['quantity'];
    $fechaAgregado = date('Y-m-d H:i:s');

    // Manejar la subida de la imagen
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $imageDir = 'C:/xampp/htdocs/PiaPrograWeb/img/'; // Asegúrate de actualizar esta ruta
        $imagePath = $imageDir . $imageName;

        // Ruta relativa para guardar en la base de datos
        $relativeImagePath = '/PiaPrograWeb/img/' . $imageName;

        // Mueve el archivo subido a la ubicación deseada
        if (move_uploaded_file($imageTmpPath, $imagePath)) {
            $imagen = $relativeImagePath;
        } else {
            echo "Error al mover el archivo subido.";
            exit();
        }
    }

    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }

    $sql = "INSERT INTO Producto (Titulo, Descripcion, CategoriaPrincipal, Precio, CantidadInventario, Imagen, FechaAgregado) 
            VALUES ('$nombre', '$descripcion', $categoria, $precio, $cantidad, '$imagen', '$fechaAgregado')";
    if ($conexion->query($sql) === TRUE) {
        // Obtener el ID del producto recién insertado
        $idProducto = $conexion->insert_id;

        // Obtener las categorías secundarias seleccionadas
        $secondaryCategories = isset($_POST['secondaryCategories']) ? explode(',', $_POST['secondaryCategories']) : [];

        // Insertar en la tabla DetalleCategoriaSecundaria
        if (!empty($secondaryCategories)) {
            $values = [];
            foreach ($secondaryCategories as $idCategoria) {
                $values[] = "($idCategoria, $idProducto)";
            }
            $sql = "INSERT INTO DetalleCategoriaSecundaria (IdCategoria, IdProducto) VALUES " . implode(', ', $values);

            if ($conexion->query($sql) === TRUE) {
                echo "New records created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }

    // Redirigir después de la inserción
    header('Location: /PiaPrograWeb/html/pantallaAdmin4.html');
    exit();
}
?>