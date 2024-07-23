<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-image: url('https://themonopolitan.com/assets/2021/07/subito/img1.jpg'); /* Imagen de fondo */
            background-size: cover;
            background-position: center;
        }

        header {
            width: 100%;
            background-color: rgba(31, 31, 31, 0.9); /* Fondo gris oscuro */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1px;
            position: fixed;
            top: 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
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

        form {
            background-color: rgba(31, 31, 31, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            margin: 20px;
            animation: fadeIn 1s ease-in-out;
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

        .input-group {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .input-group h2 {
            margin-bottom: 20px;
            color: #ffa500;
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

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        a {
            color: #ffa500;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
            cursor: pointer;
        }

        a:hover {
            text-decoration: underline;
        }

        .imageregister img {
            display: none; /* Ocultar la imagen duplicada */
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
            z-index: 1001;
        }

        .popup-content {
            background-color: #1f1f1f;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 90%;
            overflow-y: auto;
            max-height: 80%;
        }

        .popup.visible {
            visibility: visible;
            opacity: 1;
        }

        .popup img {
            width: 150px;
            margin-bottom: 20px;
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
</head>
<body>
    <header>
        <div class="logo">
            <img src="https://images.squarespace-cdn.com/content/v1/668c8aac79420c43bc68b6d8/4bae42e1-ddb5-4532-97af-5f778e4d97f8/La_Deliciosa__4_-removebg-preview.png?format=1500w" alt="La Deliciosa Logo">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Iniciar sesión</a></li>
                <li><a href="register.php">Registrarse</a></li>
            </ul>
        </nav>
    </header>
    <form class="formregister" method="post" action="includes/send.php" autocomplete="off">
        <div class="input-group">
            <h2>Registrarse</h2>
            <div class="input-container">
                <input type="text" name="name" placeholder="Nombre" required>
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-container">
                <input type="password" name="password" placeholder="Contraseña" required>
                <i class="fa-solid fa-lock"></i>
            </div>
            <div class="input-container">
                <input type="email" name="email" placeholder="Correo" required>
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="input-container">
                <input type="tel" name="phone" placeholder="Teléfono" required>
                <i class="fa-solid fa-phone"></i>
            </div>
            <a href="#" id="terms-link">Términos y Condiciones</a>
            <input name="send" type="submit" class="btn" value="Registrarse">
        </div>
    </form>

    <!-- Popup para Términos y Condiciones -->
    <div class="popup" id="terms-popup">
        <div class="popup-content">
            <img src="https://images.squarespace-cdn.com/content/v1/668c8aac79420c43bc68b6d8/4bae42e1-ddb5-4532-97af-5f778e4d97f8/La_Deliciosa__4_-removebg-preview.png?format=1500w" alt="La Deliciosa Logo">
            <h2>Términos y Condiciones</h2>
            <br/>
            <div class="terms-text">
                <p><b>1. Uso de la Plataforma</b></p>
                <br/>
                <p>El uso de esta plataforma es responsabilidad exclusiva de los usuarios. Nos reservamos el derecho de modificar o discontinuar cualquier aspecto del servicio en cualquier momento.</p>
                <br/>
                <p><b>2. Privacidad</b></p>
                <br/>
                <p>Nos comprometemos a proteger la privacidad de los datos de nuestros usuarios. Consulte nuestra Política de Privacidad para más detalles sobre cómo manejamos su información personal.</p>
                <br/>
                <p><b>3. Derechos de Autor</b></p>
                <br/>
                <p>Todos los contenidos y materiales disponibles en esta plataforma están protegidos por derechos de autor. Los usuarios deben asegurarse de no infringir estos derechos al utilizar, reproducir o distribuir cualquier contenido.</p>
                <br/>
                <p><b>4. Uso de Cookies</b></p>
                <br/>
                <p>Esta plataforma utiliza cookies para mejorar la experiencia del usuario. Al utilizar nuestra plataforma, usted acepta el uso de cookies de acuerdo con nuestra Política de Cookies.</p>
                <br/>
                <p><b>5. Derechos de Propiedad Intelectual</b></p>
                <br/>
                <p>Todos los derechos de propiedad intelectual relacionados con el contenido y los servicios proporcionados en esta plataforma son propiedad de sus respectivos titulares y están protegidos por las leyes aplicables.</p>
                <br/>
                <p><b>6. Protección de Datos</b></p>
                <br/>
                <p>Nos tomamos muy en serio la protección de sus datos personales. Por favor, revise nuestra Política de Protección de Datos para entender cómo protegemos y utilizamos su información.</p>
                <br/>
                <p><b>7. Reclamaciones por Infracción</b></p>
                <br/>
                <p>Si considera que cualquier contenido en nuestra plataforma infringe sus derechos de autor, por favor contáctenos inmediatamente para que podamos investigar y tomar las medidas adecuadas.</p>
            </div>
            <br/>
            <button onclick="closePopup()">Aceptar</button>
        </div>
    </div>

    <script>
        document.getElementById('terms-link').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('terms-popup').classList.add('visible');
        });

        function closePopup() {
            document.getElementById('terms-popup').classList.remove('visible');
        }
    </script>
</body>
</html>
