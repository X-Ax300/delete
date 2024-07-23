<!-- includes/conexion2.php -->
<?php
$conex = mysqli_connect("localhost", "root", "", "reservas_db");

if (!$conex) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
