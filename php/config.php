<?php

class conexionDb{
    public static function conexion(){
        $conexion = new mysqli('localhost', 'root', '', 'biblioteca');
        return $conexion;
    }
}

?>