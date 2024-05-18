<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['name'];
    $descripcion = $_POST['description'];
    $precio = $_POST['price'];
    $categoria = intval($_POST['category']);
    $cantidad = $_POST['quantity'];
    $fechaAgregado = date('Y-m-d H:i:s');
    $imagen = 'imagen132.jpg'; // Asegúrate de ajustar esto para manejar correctamente la subida de imágenes

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