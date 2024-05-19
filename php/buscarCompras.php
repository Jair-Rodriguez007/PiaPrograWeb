<?php
require_once 'config.php';

$conexion = conexionDb::conexion();
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

// Recoger los parámetros de la solicitud GET
$startDate = $_GET['start-date'];
$endDate = $_GET['end-date'];
$bookTitle = isset($_GET['book-title']) ? $_GET['book-title'] : '';

// Preparar la consulta SQL
$sql = "SELECT Venta.*, Usuario.Nombre, Producto.Titulo, MetodoPago.NombreMetodo, Estado.NombreEstado 
        FROM Venta 
        JOIN DetalleVenta ON Venta.IdVenta = DetalleVenta.IdVenta
        JOIN Producto ON DetalleVenta.IdProducto = Producto.IdProducto 
        JOIN Usuario ON Venta.IdUsuario = Usuario.IdUsuario
        JOIN MetodoPago ON Venta.MetodoPago = MetodoPago.IdMetodo
        JOIN Estado ON Venta.Estado = Estado.IdEstado
        WHERE FechaVenta >= ? AND FechaVenta <= ?";

if ($bookTitle !== '') {
    $sql .= " AND Producto.Titulo LIKE ?";
    $bookTitle = '%' . $bookTitle . '%';
}

$stmt = $conexion->prepare($sql);

// Vincular los parámetros a la consulta
if ($bookTitle !== '') {
    $stmt->bind_param('sss', $startDate, $endDate, $bookTitle);
} else {
    $stmt->bind_param('ss', $startDate, $endDate);
}

// Ejecutar la consulta
$stmt->execute();

// Obtener los resultados
$result = $stmt->get_result();

if ($result) {
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}

// Cierra la conexión
$conexion->close();
?>