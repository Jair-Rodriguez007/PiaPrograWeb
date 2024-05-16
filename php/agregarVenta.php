<?php
    session_start();
    require_once "config.php";

    $conexion = conexionDb::conexion();
    if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
    }

    if(isset($_POST)){
        $idDomicilio = $_POST['address'];
        $idTarjeta = $_POST['payment-method'];
        $idUsuario = $_SESSION['id'];

        // Obtén el IdMetodo asociado con el IdTarjeta
        $stmt = $conexion->prepare("SELECT IdMetodo FROM Tarjeta WHERE IdTarjeta = ?");
        $stmt->bind_param("i", $idTarjeta);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $idMetodo = $row['IdMetodo'];
        } else {
            echo "No se encontró un IdMetodo para el IdTarjeta proporcionado";
            exit;
        }
        $stmt->close();

        // Inserta una nueva fila en la tabla Venta
        $fechaVenta = date('Y-m-d H:i:s'); // Obtiene la fecha y hora actual

        //Obtener el total consultando los registros en la tabla carrito que tengan este idUsuario y realizar la operación correspondiente para calcular el total
        // Obtener el total
        $sqlTotal = "SELECT SUM(Producto.Precio * Carrito.Cantidad) AS Total
        FROM Carrito
        INNER JOIN Producto ON Carrito.IdProducto = Producto.IdProducto
        WHERE Carrito.IdUsuario = $idUsuario";
        $resultadoTotal = $conexion->query($sqlTotal);
        if ($rowTotal = $resultadoTotal->fetch_assoc()) {
        $total = $rowTotal['Total'];
        } else {
        echo "No se pudo calcular el total";
        exit;
        }

        $estado = 1;

        $sql = "INSERT INTO Venta (IdUsuario, FechaVenta, MetodoPago, Domicilio, Total, Estado) 
                VALUES ($idUsuario, '$fechaVenta', $idMetodo, $idDomicilio, $total, $estado)";

        if ($conexion->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
    }

    // Obtén el IdVenta de la venta recién insertada
    $idVenta = $conexion->insert_id;

    // Suponiendo que $conexion es tu objeto de conexión a la base de datos
    // y que $idUsuario es el ID del usuario actual

    $sql = "SELECT * FROM Carrito WHERE IdUsuario = $idUsuario";
    $resultado = $conexion->query($sql);

    $carrito = array();
    while ($row = $resultado->fetch_assoc()) {
        $carrito[] = $row;
    }

    // Ahora, para cada producto en el carrito del usuario, inserta un detalle de venta
    foreach ($carrito as $item) {
        $idProducto = $item['IdProducto'];
        $cantidad = $item['Cantidad'];

        // Obtén el precio del producto de la tabla Producto
        $sqlPrecio = "SELECT Precio FROM Producto WHERE IdProducto = $idProducto";
        $resultadoPrecio = $conexion->query($sqlPrecio);
        if ($rowPrecio = $resultadoPrecio->fetch_assoc()) {
            $precio = $rowPrecio['Precio'];
        } else {
            echo "No se pudo obtener el precio del producto con IdProducto = $idProducto";
            exit;
        }

        // Inserta el detalle de venta
        $sqlDetalle = "INSERT INTO DetalleVenta (IdVenta, IdProducto, Cantidad, Precio) 
                    VALUES ($idVenta, $idProducto, $cantidad, $precio)";
        if ($conexion->query($sqlDetalle) !== TRUE) {
            echo "Error: " . $sqlDetalle . "<br>" . $conexion->error;
        }
    }
    header("Location: /PiaPrograWeb/php/eliminarCarrito.php");
?>
