<?php
session_start();
include('includes/conexion2.php'); // Asegúrate de que la ruta es correcta

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

// Inicializar variable de éxito de reserva
$reservation_success = false;

// Almacenamiento de reservas en la base de datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $name = trim($_POST['name']);
    $id = trim($_POST['id']);
    $date = trim($_POST['date']);
    $time = trim($_POST['time']);

    if (!empty($name) && !empty($id) && !empty($date) && !empty($time)) {
        // Verificar el número de reservas existentes para la fecha y hora seleccionadas
        $query = "SELECT COUNT(*) as count FROM reservas WHERE fecha='$date' AND hora='$time'";
        $result = mysqli_query($conex, $query);
        $row = mysqli_fetch_assoc($result);

        if ($row['count'] < 5) {
            if ($_POST['action'] === 'add') {
                $query = "INSERT INTO reservas (nombre, cedula, fecha, hora) VALUES ('$name', '$id', '$date', '$time')";
            } elseif ($_POST['action'] === 'update' && !empty($_POST['reservation_id'])) {
                $reservation_id = $_POST['reservation_id'];
                $query = "UPDATE reservas SET nombre='$name', cedula='$id', fecha='$date', hora='$time' WHERE id='$reservation_id'";
            }

            if (mysqli_query($conex, $query)) {
                $_SESSION['reservation_success'] = true; // Indicar que la reserva fue exitosa
                header('Location: reservations.php');
                exit;
            } else {
                echo "<h3 class='error'>Error al realizar la reserva: " . mysqli_error($conex) . "</h3>";
            }
        } else {
            echo "<h3 class='error'>No se pueden realizar más de 5 reservas para la misma fecha y hora.</h3>";
        }
    } else {
        echo "<h3 class='error'>Llena todos los campos</h3>";
    }
}

// Eliminar reservas
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $query = "DELETE FROM reservas WHERE id='$delete_id'";
    if (mysqli_query($conex, $query)) {
        header('Location: reservations.php');
        exit;
    } else {
        echo "<h3 class='error'>Error al eliminar la reserva: " . mysqli_error($conex) . "</h3>";
    }
}

// Recuperar todas las reservas agrupadas por fecha y hora
$reservations = [];
$query = "SELECT fecha, hora, COUNT(*) as count FROM reservas GROUP BY fecha, hora ORDER BY fecha, hora";
$result = mysqli_query($conex, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reservations[] = $row;
    }
} else {
    echo "<h3 class='error'>Error al recuperar las reservas: " . mysqli_error($conex) . "</h3>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'aktiv-grotesk', sans-serif;
            background-color: #121212; /* Fondo negro */
            color: #fff; /* Texto blanco */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-image: url('https://cache.marriott.com/is/image/marriotts7prod/ak-mcokc-swan-reserve-lobby-35739:Wide-Hor?wid=2880&fit=constrain');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            width: 100%;
            background-color: rgba(31, 31, 31, 0.9); /* Fondo gris oscuro */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logo img {
            width: 150px;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: #fcfef7;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #ffa500;
        }

        main {
            padding: 20px;
            flex: 1;
        }

        .opacity {
            background-color: rgba(0, 0, 0, 0.7); /* Color negro con opacidad */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .titlee {
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }

        .titleeR{
            color: rgba(255, 184, 190, 1);
            text-align: center;
            margin-bottom: 20px;
        }

        .reservation-form, .reservations-list {
            margin-bottom: 20px;
        }

        .reservation-form input, .reservation-form select, .reservation-form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .reservation-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #fff;
        }

        .reservation-form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .reservation-form button:hover {
            background-color: #45a049;
        }

        .reservations-list table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(120, 120, 120, 0.8);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .reservations-list th, .reservations-list td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .reservations-list th {
            background-color: #333;
            color: #fff;
        }

        .reservations-list tr:hover {
            background-color: rgba(89, 86, 86, 0.7);
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .form-container {
            background-color: rgba(120, 120, 120, 0.8); /* Fondo blanco con opacidad */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Popup Styles */
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.5s;
        }

        .popup-content {
            background-color: #1f1f1f;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .popup.visible {
            visibility: visible;
            opacity: 1;
        }

        .popup button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .popup button:hover {
            background-color: #45a049;
        }

    </style>
    <script>
        function formatID(input) {
            // Remover cualquier carácter que no sea un número
            let value = input.value.replace(/\D/g, '');
            // Limitar a 11 caracteres
            value = value.substring(0, 11);
            // Formatear la cédula
            input.value = value.replace(/(\d{3})(\d{7})(\d{1})/, '$1-$2-$3');
        }

        function showAlert(message) {
            alert(message);
        }

        // Mostrar popup si la reserva fue exitosa
        <?php if (isset($_SESSION['reservation_success']) && $_SESSION['reservation_success'] === true): ?>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('reservation-success-popup').classList.add('visible');
            });
            <?php unset($_SESSION['reservation_success']); // Limpiar la variable de sesión ?>
        <?php endif; ?>

        // Cerrar popup
        function closePopup() {
            document.getElementById('reservation-success-popup').classList.remove('visible');
        }

        // Deshabilitar fechas pasadas
        document.addEventListener('DOMContentLoaded', function() {
            var dateInput = document.getElementById('date');
            var today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        });
    </script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="https://images.squarespace-cdn.com/content/v1/668c8aac79420c43bc68b6d8/4bae42e1-ddb5-4532-97af-5f778e4d97f8/La_Deliciosa__4_-removebg-preview.png?format=1500w" alt="La Deliciosa Logo">
        </div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">Sobre Nosotros</a></li>
                <li><a href="menu.php">Menú</a></li>
                <li><a href="reservations.php">Reservas</a></li>
                <li><a href="billing.php">Facturación</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="opacity">
            <h1 class="titlee">Reservas</h1>
            <p class="titlee">Realice una reserva para disfrutar de nuestras pizzas.</p>
            <h2 class="titlee">Hacer una reserva</h2>
            <p class="titleeR">*No se aceptan más de 5 reservas para la misma fecha y hora.*</p>
        </div>
        <br/>
        <div class="form-container">
            <div class="reservation-form">
                <form method="post">
                    <input type="hidden" id="reservation_id" name="reservation_id">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" required>
                    
                    <label for="id">Cédula:</label>
                    <input type="text" id="id" name="id" oninput="formatID(this)" required maxlength="13">
                    
                    <label for="date">Fecha:</label>
                    <input type="date" id="date" name="date" required>
                    
                    <label for="time">Hora:</label>
                    <input type="time" id="time" name="time" required>
                    
                    <button type="submit" name="action" value="add">Reservar</button>
                    <button type="submit" name="action" value="update" style="display:none;">Actualizar</button>
                </form>
            </div>
        </div>
        <br/>
        <div class="reservations-list">
            <div class="opacity">
                <h2 class="titlee">Reservas existentes</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Cantidad de Reservas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reservation['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['hora']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['count']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Popup para confirmar reserva -->
    <div class="popup" id="reservation-success-popup">
        <div class="popup-content">
            <p>Reserva realizada correctamente.</p>
            <button onclick="closePopup()">Cerrar</button>
        </div>
    </div>

</body>
</html>
