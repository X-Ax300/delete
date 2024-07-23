<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'aktiv-grotesk', sans-serif;
            background: url('https://c8.alamy.com/comp/2PE0FX5/menu-restaurant-cafe-template-design-food-flyer-2PE0FX5.jpg') no-repeat center center fixed;
            background-size: cover;
            color: black;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        header {
            width: 100%;
            background-color: rgba(31, 31, 31, 1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
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

        main {
            padding: 20px;
            flex: 1;
        }

        form {
            background-color: rgba(31, 31, 31, 1);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7);
            max-width: 400px;
            width: 100%;
            margin: 20px;
            animation: fadeIn 1s ease-in-out;
            position: relative;
            top:200px;
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

        .imagelogin img {
            display: none;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="https://images.squarespace-cdn.com/content/v1/668c8aac79420c43bc68b6d8/4bae42e1-ddb5-4532-97af-5f778e4d97f8/La_Deliciosa__4_-removebg-preview.png?format=1500w"
                alt="La Deliciosa Logo">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Iniciar sesión</a></li>
                <li><a href="register.php">Registrarse</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form method="post" action="includes/login.php" autocomplete="off">
            <div class="input-group">
                <h2>Iniciar Sesión</h2>
                <div class="input-container">
                    <input type="email" name="email" placeholder="Correo" required>
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="input-container">
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
                <input name="login" type="submit" class="btn" value="Iniciar Sesión">
            </div>
        </form>
    </main>
</body>

</html>