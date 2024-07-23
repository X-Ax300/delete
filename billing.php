<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Eliminar producto del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'])) {
    $index = $_POST['remove_item'];
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-indexar el array
    }
}

function calculateTotal($cart) {
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'];
    }
    return $total;
}

function calculateITBIS($total) {
    return $total * 0.18;
}

$total = calculateTotal($_SESSION['cart']);
$itbis = calculateITBIS($total);
$grandTotal = $total + $itbis;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['remove_item'])) {
    if (isset($_POST['payment_method'])) {
        $message = $_POST['payment_method'] === 'card' ? "Pago con tarjeta realizado satisfactoriamente." : "Pago en efectivo realizado satisfactoriamente.";
        $_SESSION['payment_success'] = $message;
        if (isset($_POST['generate_invoice']) && $_POST['generate_invoice'] === 'yes') {
            $_SESSION['invoice'] = [
                'items' => $_SESSION['cart'],
                'total' => $total,
                'itbis' => $itbis,
                'grand_total' => $grandTotal
            ];
        }
        $_SESSION['cart'] = [];
        header('Location: billing.php');
        exit;
    }
}

// Limpiar la factura después de mostrarla
$invoice = null;
if (isset($_SESSION['invoice'])) {
    $invoice = $_SESSION['invoice'];
    unset($_SESSION['invoice']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturación</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #121212;
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            width: 100%;
            background-color: #1f1f1f;
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

        .titlee {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }

        .bill-section {
            background: rgba(120, 120, 120, 0.8);
            padding: 20px;
            margin-bottom: 20px;
            color: black;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .bill-item {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #1f1f1f;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .bill-item-title {
            font-weight: bold;
            font-size: 1.2em;
            color: #ffa500;
        }

        .bill-item-price {
            color: #ccc;
            font-size: 1.1em;
        }

        .remove-button {
            background-color: #ff4444;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .remove-button:hover {
            background-color: #ff0000;
        }

        .bill-summary {
            background-color: #1f1f1f;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: right;
        }

        .bill-summary-item {
            color: #ccc;
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        .bill-summary-total {
            color: #ffa500;
            font-size: 1.3em;
            font-weight: bold;
        }

        .print-button,
        .payment-button {
            display: inline-block;
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            cursor: pointer;
            border: none;
        }

        .print-button:hover,
        .payment-button:hover {
            background-color: #45a049;
        }

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
            z-index: 1000;
        }

        .popup.visible {
            visibility: visible;
            opacity: 1;
        }

        .popup-content {
            background-color: rgba(31, 31, 31, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            color: white;
            max-width: 500px;
            width: 90%;
            animation: fadeIn 0.5s ease-in-out;
        }

        .popup-content img {
            width: 150px;
            margin-bottom: 20px;
        }

        .popup-content h2 {
            color: #ffa500;
            margin-bottom: 20px;
        }

        .input-container {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .input-container input {
            width: 100%;
            padding: 15px 20px;
            padding-left: 45px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background-color: #fff;
            color: #333;
        }

        .input-container i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #666;
        }

        .radio-container {
            text-align: left;
            padding-left: 10px;
            margin-bottom: 20px;
            color: #fff;
        }

        .radio-container input {
            width: auto;
            margin-right: 10px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

        .payment-button1,
        .close-button1 {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100px;
            font-size: 16px;
        }

        .payment-button1:hover,
        .close-button1:hover {
            background-color: #45a049;
        }

        .close-button1 {
            background-color: #ff4444;
        }

        .close-button1:hover {
            background-color: #ff0000;
        }

        .radio-button {
            width: 20px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
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
        <h1 class="titlee">Facturación</h1>
        <p class="titlee">Gestione la facturación de sus pedidos.</p>

        <div class="bill-section">
            <h2 class="titleee">Pedidos</h2>
            <?php if (isset($_SESSION['payment_success'])): ?>
                <div class="popup visible" id="payment-success-popup">
                    <div class="popup-content">
                        <p><?php echo htmlspecialchars($_SESSION['payment_success']); unset($_SESSION['payment_success']); ?></p>
                        <button onclick="closePopup()">Cerrar</button>
                    </div>
                </div>
            <?php endif; ?>
            <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                <div class="bill-item">
                    <div class="bill-item-title"><?php echo htmlspecialchars($item['name']); ?></div>
                    <div class="bill-item-price">RD$<?php echo number_format($item['price'], 2); ?></div>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="remove_item" value="<?php echo $index; ?>">
                        <button type="submit" class="remove-button">Eliminar</button>
                    </form>
                </div>
            <?php endforeach; ?>
            <div class="bill-summary">
                <div class="bill-summary-item">Subtotal: RD$<?php echo number_format($total, 2); ?></div>
                <div class="bill-summary-item">ITBIS (18%): RD$<?php echo number_format($itbis, 2); ?></div>
                <div class="bill-summary-total">Total: RD$<?php echo number_format($grandTotal, 2); ?></div>
            </div>
            <button class="payment-button" onclick="showPaymentOptions()" <?php echo empty($_SESSION['cart']) ? 'disabled style="background-color: grey; cursor: not-allowed;"' : ''; ?>>Pagar</button>
        </div>

        <!-- Sección para mostrar la factura si está disponible -->
        <?php if ($invoice): ?>
        <div class="bill-section">
            <h2 class="titleee">Factura Detalles</h2>
            <?php foreach ($invoice['items'] as $item): ?>
            <div class="bill-item">
                <div class="bill-item-title"><?php echo htmlspecialchars($item['name']); ?></div>
                <div class="bill-item-price">RD$<?php echo number_format($item['price'], 2); ?></div>
            </div>
            <?php endforeach; ?>
            <div class="bill-summary">
                <div class="bill-summary-item">Subtotal: RD$<?php echo number_format($invoice['total'], 2); ?></div>
                <div class="bill-summary-item">ITBIS (18%): RD$<?php echo number_format($invoice['itbis'], 2); ?></div>
                <div class="bill-summary-total">Total: RD$<?php echo number_format($invoice['grand_total'], 2); ?></div>
            </div>
            <a href="javascript:window.print()" class="print-button">Imprimir Factura</a>
        </div>
        <?php endif; ?>
    </main>

    <div class="popup" id="payment-popup">
        <div class="popup-content">
            <h2>Elija el método de pago</h2>
            <button class="payment-button1" onclick="showCardForm()">Tarjeta</button>
            <button class="payment-button1" onclick="showCashForm()">Efectivo</button>
            <button class="close-button1" onclick="closePopup()">Cerrar</button>
        </div>
    </div>

    <div class="popup" id="card-form-popup">
        <div class="popup-content">
            <div class="logo">
                <img src="https://images.squarespace-cdn.com/content/v1/668c8aac79420c43bc68b6d8/4bae42e1-ddb5-4532-97af-5f778e4d97f8/La_Deliciosa__4_-removebg-preview.png?format=1500w" alt="La Deliciosa Logo">
            </div>
            <h2>Pago con Tarjeta</h2>
            <br/>
            <form method="post" action="">
                <input type="hidden" name="payment_method" value="card">
                <div class="input-container">
                    <input type="text" name="card_number" id="card_number" placeholder="Número de Tarjeta" maxlength="19" required>
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <br/>
                <div class="input-container">
                    <input type="text" name="card_holder" placeholder="Nombre del Titular" required>
                    <i class="fa-solid fa-user"></i>
                </div>
                <br/>
                <div class="input-container">
                    <input type="text" name="expiry_date" id="expiry_date" placeholder="Fecha de Expiración (MM/AA)" maxlength="5" required>
                    <i class="fa-solid fa-calendar"></i>
                </div>
                <br/>
                <div class="input-container">
                    <input type="text" name="cvv" placeholder="CVV" maxlength="3" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
                <br/>
                <div class="radio-container">
                    <label>¿Desea una factura?</label>
                    <div class="radio-option">
                        <label for="yes">Sí</label>
                        <input class="radio-button" type="radio" id="yes" name="generate_invoice" value="yes" checked>
                    </div>
                    <div class="radio-option">
                        <label for="no">No</label>
                        <input class="radio-button" type="radio" id="no" name="generate_invoice" value="no">
                    </div>
                </div>
                <br/>
                <div class="button-container">
                    <button type="submit" class="payment-button1">Pagar</button>
                    <button type="button" class="close-button1" onclick="closePopup()">Cerrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="popup" id="cash-form-popup">
        <div class="popup-content">
            <h2>Pago en Efectivo</h2>
            <form method="post" action="">
                <input type="hidden" name="payment_method" value="cash">
                <div class="radio-container">
                    <label>¿Desea una factura?</label>
                    <div class="radio-option">
                        <label for="yes">Sí</label>
                        <input class="radio-button" type="radio" id="yes" name="generate_invoice" value="yes" checked>
                    </div>
                    <div class="radio-option">
                        <label for="no">No</label>
                        <input class="radio-button" type="radio" id="no" name="generate_invoice" value="no">
                    </div>
                </div>
                <div class="button-container">
                    <button type="submit" class="payment-button1">Pagar</button>
                    <button type="button" class="close-button1" onclick="closePopup()">Cerrar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showPaymentOptions() {
            document.getElementById('payment-popup').classList.add('visible');
        }

        function showCardForm() {
            document.getElementById('payment-popup').classList.remove('visible');
            document.getElementById('card-form-popup').classList.add('visible');
        }

        function showCashForm() {
            document.getElementById('payment-popup').classList.remove('visible');
            document.getElementById('cash-form-popup').classList.add('visible');
        }

        function closePopup() {
            document.getElementById('payment-popup').classList.remove('visible');
            document.getElementById('card-form-popup').classList.remove('visible');
            document.getElementById('cash-form-popup').classList.remove('visible');
            const paymentSuccessPopup = document.getElementById('payment-success-popup');
            if (paymentSuccessPopup) {
                paymentSuccessPopup.classList.remove('visible');
            }
        }

        // Formato de la tarjeta con guiones
        document.getElementById('card_number').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '').substring(0, 16);
            let formattedValue = value.replace(/(.{4})/g, '$1 ').trim();
            e.target.value = formattedValue;
        });

        // Formato de la fecha de expiración
        document.getElementById('expiry_date').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '').substring(0, 4);
            if (value.length >= 3) {
                e.target.value = value.substring(0, 2) + '/' + value.substring(2);
            } else {
                e.target.value = value;
            }
        });
    </script>
</body>
</html>
