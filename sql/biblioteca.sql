CREATE DATABASE biblioteca;
USE biblioteca;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE MetodoPago (
    IdMetodo INT PRIMARY KEY,
    NombreMetodo VARCHAR(50)
);

INSERT INTO MetodoPago (IdMetodo, NombreMetodo)
VALUES (1, 'Visa'), (2, 'MasterCard'), (3, 'American Express');

CREATE TABLE Rol (
    IdRol INT PRIMARY KEY,
    NombreRol VARCHAR(13)
);

INSERT INTO Rol (IdRol, NombreRol)
VALUES (1, 'Usuario'), (2, 'Cliente'), (3, 'Bibliotecario'), (4, 'Administrador');

CREATE TABLE Categoria (
    IdCategoria INT PRIMARY KEY,
    NombreCategoria VARCHAR(25)
);

INSERT INTO Categoria (IdCategoria, NombreCategoria)
VALUES (1, 'Acción y Aventura'), (2, 'Clásicos'), (3, 'Horror');

CREATE TABLE Estado (
    IdEstado INT PRIMARY KEY,
    NombreEstado VARCHAR(10)
);

INSERT INTO Estado (IdEstado, NombreEstado)
VALUES (1, 'Pendiente'), (2, 'Entregado');

CREATE TABLE Usuario (
    IdUsuario INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL,
    CorreoElectronico VARCHAR(200) NOT NULL,
    Contrasena VARCHAR(15) NOT NULL,
    Rol INT NOT NULL,
    FOREIGN KEY (Rol) REFERENCES Rol(IdRol)
);

INSERT INTO Usuario (Nombre, CorreoElectronico, Contrasena, Rol)
VALUES ('Juan Perez', 'juan.perez@example.com', 'contrasena123', 1);

CREATE TABLE Tarjeta (
    IdTarjeta INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    IdUsuario INT NOT NULL,
    IdMetodo INT NOT NULL,
    NumeroTarjeta INT NOT NULL,
    FechaExpiracion DATE NOT NULL,
    CVV INT NOT NULL,
    FOREIGN KEY (IdUsuario) REFERENCES Usuario(IdUsuario),
    FOREIGN KEY (IdMetodo) REFERENCES MetodoPago(IdMetodo)
);

INSERT INTO Tarjeta (IdUsuario, IdMetodo, NumeroTarjeta, FechaExpiracion, CVV)
VALUES (1, 1, '4111111111111111', '2025-12-31', 123);

CREATE TABLE Domicilio (
    IdDomicilio INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    IdUsuario INT NOT NULL,
    Calle VARCHAR(50) NOT NULL,
    Estado VARCHAR(50) NOT NULL,
    Pais VARCHAR(50) NOT NULL,
    NumeroExt INT NOT NULL,
    NumeroInt INT NOT NULL,
    FOREIGN KEY (IdUsuario) REFERENCES Usuario(IdUsuario)
);

INSERT INTO Domicilio (IdUsuario, Calle, Estado, Pais, NumeroExt, NumeroInt)
VALUES (1, 'Calle 123', 'Nuevo León', 'México', 123, 321);

CREATE TABLE Producto (
    IdProducto INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Titulo VARCHAR(50) NOT NULL,
    Descripcion VARCHAR(200) NOT NULL,
    CategoriaPrincipal INT NOT NULL,
    Precio DECIMAL(10, 2) NOT NULL,
    CantidadInventario INT NOT NULL,
    Imagen VARCHAR(1000) NOT NULL,
    FechaAgregado DATETIME NOT NULL,
    FOREIGN KEY (CategoriaPrincipal) REFERENCES Categoria(IdCategoria)
);

INSERT INTO Producto (Titulo, Descripcion, CategoriaPrincipal, Precio, CantidadInventario, Imagen, FechaAgregado)
VALUES ('El Gran Libro de la Aventura', 'Un libro lleno de emocionantes aventuras', 1, 19.99, 10, 'imagen.jpg', NOW());

CREATE TABLE Venta (
    IdVenta INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    IdUsuario INT NOT NULL,
    FechaVenta DATETIME NOT NULL,
    MetodoPago INT NOT NULL,
    Domicilio INT NOT NULL,
    Total DECIMAL(10, 2) NOT NULL,
    Estado INT NOT NULL,
    FOREIGN KEY (IdUsuario) REFERENCES Usuario(IdUsuario),
    FOREIGN KEY (MetodoPago) REFERENCES MetodoPago(IdMetodo),
    FOREIGN KEY (Domicilio) REFERENCES Domicilio(IdDomicilio),
    FOREIGN KEY (Estado) REFERENCES Estado(IdEstado)
);

INSERT INTO Venta (IdUsuario, FechaVenta, MetodoPago, Domicilio, Total, Estado)
VALUES (1, NOW(), 1, 1, 19.99, 1);

CREATE TABLE DetalleVenta (
    IdVenta INT NOT NULL,
    IdProducto INT NOT NULL,
    Cantidad INT NOT NULL,
    Precio DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (IdVenta, IdProducto),
    FOREIGN KEY (IdVenta) REFERENCES Venta(IdVenta),
    FOREIGN KEY (IdProducto) REFERENCES Producto(IdProducto)
);

INSERT INTO DetalleVenta (IdVenta, IdProducto, Cantidad, Precio)
VALUES (1, 1, 1, 19.99);

CREATE TABLE Comentario (
    IdComentario INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    IdUsuario INT NOT NULL,
    IdProducto INT NOT NULL,
    TextoComentario TEXT NOT NULL,
    FechaComentario DATETIME NOT NULL,
    FOREIGN KEY (IdUsuario) REFERENCES Usuario(IdUsuario),
    FOREIGN KEY (IdProducto) REFERENCES Producto(IdProducto)
);

INSERT INTO Comentario (IdUsuario, IdProducto, TextoComentario, FechaComentario)
VALUES (1, 1, '¡Este libro es increíble!', NOW());

CREATE TABLE Carrito (
    IdUsuario INT NOT NULL,
    IdProducto INT NOT NULL,
    Cantidad INT,
    PRIMARY KEY (IdUsuario, IdProducto),
    FOREIGN KEY (IdUsuario) REFERENCES Usuario(IdUsuario),
    FOREIGN KEY (IdProducto) REFERENCES Producto(IdProducto)
);

INSERT INTO Carrito (IdUsuario, IdProducto, Cantidad)
VALUES (1, 1, 1);

CREATE TABLE DetalleCategoriaSecundaria (
    IdCategoria INT NOT NULL,
    IdProducto INT NOT NULL,
    PRIMARY KEY (IdCategoria, IdProducto),
    FOREIGN KEY (IdCategoria) REFERENCES Categoria(IdCategoria),
    FOREIGN KEY (IdProducto) REFERENCES Producto(IdProducto)
);

INSERT INTO DetalleCategoriaSecundaria (IdCategoria, IdProducto)
VALUES (2, 1);

CREATE TABLE VisualizacionLibro (
    IdUsuario INT NOT NULL,
    IdProducto INT NOT NULL,
    Fecha DATE NOT NULL,
    PRIMARY KEY (IdUsuario, IdProducto, Fecha),
    FOREIGN KEY (IdUsuario) REFERENCES Usuario(IdUsuario),
    FOREIGN KEY (IdProducto) REFERENCES Producto(IdProducto)
);

INSERT INTO VisualizacionLibro (IdUsuario, IdProducto, Fecha)
VALUES (1, 1, CURDATE());

CREATE TABLE VisualizacionCategoria (
    IdUsuario INT NOT NULL,
    IdCategoria INT NOT NULL,
    Fecha DATE NOT NULL,
    PRIMARY KEY (IdUsuario, IdCategoria, Fecha),
    FOREIGN KEY (IdUsuario) REFERENCES Usuario(IdUsuario),
    FOREIGN KEY (IdCategoria) REFERENCES Categoria(IdCategoria)
);

INSERT INTO VisualizacionCategoria (IdUsuario, IdCategoria, Fecha)
VALUES (1, 1, CURDATE());
