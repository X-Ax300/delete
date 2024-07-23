<!-- includes\login.php -->
<?php
session_start();
include("conexion.php");

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $query = "SELECT * FROM datos WHERE email='$email'";
        $result = mysqli_query($conex, $query);

        if ($result) {
            $user = mysqli_fetch_assoc($result);

            if ($user && $user['contraseña'] === $password) {
                $_SESSION['loggedin'] = true;
                header('Location: ../home.php');
                exit();
            } else {
                echo "<h3 class='error'>Correo o contraseña incorrectos</h3>";
            }
        } else {
            echo "<h3 class='error'>Error en la consulta: " . mysqli_error($conex) . "</h3>";
        }
    } else {
        echo "<h3 class='error'>Llena todos los campos</h3>";
    }
}
?>
