<?php
session_start();
require_once 'config.php';

//crear conexión
$conexion = conexionDb::conexion();
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

if (isset($_GET['id'])) {
    // Si se proporciona un ID, selecciona solo el libro que corresponde a ese ID
    $id = $_GET['id'];
    //$sql = "SELECT * FROM Obra WHERE ID_obra = $id";
    // Traer la información del producto y la categoría principal
    $sql = "SELECT Producto.*, Categoria.NombreCategoria 
            FROM Producto 
            INNER JOIN Categoria ON Producto.CategoriaPrincipal = Categoria.IdCategoria 
            WHERE Producto.IdProducto = $id";
    $result = $conexion->query($sql);
    $libro = $result->fetch_assoc();

    // Traer las categorías secundarias
    $sql_secundarias = "SELECT Categoria.NombreCategoria 
                        FROM DetalleCategoriaSecundaria 
                        INNER JOIN Categoria ON DetalleCategoriaSecundaria.IdCategoria = Categoria.IdCategoria 
                        WHERE DetalleCategoriaSecundaria.IdProducto = $id";
    $result_secundarias = $conexion->query($sql_secundarias);
    $categorias_secundarias = [];
    while ($row = $result_secundarias->fetch_assoc()) {
        $categorias_secundarias[] = $row['NombreCategoria'];
    }

    // Añadir las categorías secundarias al array del libro
    $libro['CategoriasSecundarias'] = $categorias_secundarias;
    // Insertar visualización del libro
    if (isset($_SESSION['id'])) {
        $IdUsuario = $_SESSION['id'];
        $IdProducto = $libro['IdProducto'];
        $IdCategoria = $libro['CategoriaPrincipal'];
        $fecha = date('Y-m-d');

        // Verificar si ya existe una visualización del libro
        $sqlCheckLibro = "SELECT * FROM VisualizacionLibro WHERE IdUsuario = $IdUsuario AND IdProducto = $IdProducto AND Fecha = '$fecha'";
        $resultCheckLibro = $conexion->query($sqlCheckLibro);

        if ($resultCheckLibro->num_rows == 0) {
            $sqlInsertLibro = "INSERT INTO VisualizacionLibro (IdUsuario, IdProducto, Fecha) VALUES ($IdUsuario, $IdProducto, '$fecha')";
            $conexion->query($sqlInsertLibro);
        }

        // Verificar si ya existe una visualización de la categoría
        $sqlCheckCategoria = "SELECT * FROM VisualizacionCategoria WHERE IdUsuario = $IdUsuario AND IdCategoria = $IdCategoria AND Fecha = '$fecha'";
        $resultCheckCategoria = $conexion->query($sqlCheckCategoria);

        if ($resultCheckCategoria->num_rows == 0) {
            $sqlInsertCategoria = "INSERT INTO VisualizacionCategoria (IdUsuario, IdCategoria, Fecha) VALUES ($IdUsuario, $IdCategoria, '$fecha')";
            $conexion->query($sqlInsertCategoria);
        }
    }
    header('Content-Type: application/json');
    echo json_encode($libro);
} else {
    // Obtén los libros más recientes
    $sql_recientes = "SELECT * FROM Producto ORDER BY FechaAgregado DESC LIMIT 10";
    $result_recientes = $conexion->query($sql_recientes);
    $libros_recientes = array();
    if ($result_recientes->num_rows > 0) {
        while($row = $result_recientes->fetch_assoc()) {
            $libros_recientes[] = $row;
        }
    }

    // Obtén los libros más vistos
    $sql_vistos = "SELECT Producto.*, COUNT(*) as visualizaciones FROM Producto JOIN VisualizacionLibro ON Producto.IdProducto = VisualizacionLibro.IdProducto GROUP BY Producto.IdProducto ORDER BY visualizaciones DESC LIMIT 1";
    $result_vistos = $conexion->query($sql_vistos);
    $libros_vistos = array();
    if ($result_vistos->num_rows > 0) {
        while($row = $result_vistos->fetch_assoc()) {
            $libros_vistos[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode(array('recientes' => $libros_recientes, 'vistos' => $libros_vistos));
}
$conexion->close();
?>