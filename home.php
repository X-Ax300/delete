<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #121212; /* Fondo negro */
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
            background-color: #1f1f1f; /* Fondo gris oscuro */
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

        .menu-section {
            background-image: url('https://st.depositphotos.com/2288675/3169/i/450/depositphotos_31693711-stock-photo-restaurant-reserved-table-sign.jpg');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            padding: 100px 0;
            text-align: center;
            color: #fff;
            box-shadow: inset 0 0 100px rgba(0, 0, 0, 0.7);
            animation: slideIn 1s ease-in-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .menu-section h1 {
            font-size: 48px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        .menu-section p {
            font-size: 24px;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.5;
            text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.5);
        }

        .welcome-section {
            text-align: center;
            padding: 50px 20px;
            background-color: #1f1f1f; /* Fondo gris oscuro */
            animation: fadeIn 1.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .welcome-section h2 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #ffa500;
        }

        .welcome-section p {
            font-size: 20px;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.5;
        }

        .pizza-gallery-section {
            padding: 50px 20px;
            background-color: #121212; /* Fondo negro */
            text-align: center;
        }

        .pizza-gallery-section h2 {
            font-size: 36px;
            margin-bottom: 40px;
            color: #ffa500;
        }

        .pizza-gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .pizza-item {
            background-color: #1f1f1f;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            width: 300px;
            text-align: left;
        }

        .pizza-item img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #333;
        }

        .pizza-info {
            padding: 15px;
        }

        .pizza-info h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #ffa500;
        }

        .pizza-info p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #ccc;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            color: #fff;
        }

        .pizza-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 991px) {
            body {
                padding: 30px;
            }

            .menu-section h1 {
                font-size: 36px;
            }

            .menu-section p {
                font-size: 18px;

            }

            .welcome-section h2 {
                font-size: 28px;
            }

            .pizza-gallery-section h2 {
                font-size: 28px;
            }

            .pizza-item {
                width: 100%;
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
    <section class="menu-section">
        <h1>MENÚ</h1>
        <p>La misión es simple: servir platos deliciosos y asequibles que los invitados querrán volver a comer semana tras semana.</p>
    </section>
    <section class="welcome-section">
        <h2>Bienvenido a La Deliciosa</h2>
        <p>En La Deliciosa, ofrecemos una variedad de pizzas preparadas con los mejores ingredientes frescos. Nuestro objetivo es brindar una experiencia gastronómica excepcional que haga que nuestros clientes regresen por más.</p>
    </section>
    <section class="pizza-gallery-section">
        <h2>Nuestras Pizzas</h2>
        <div class="pizza-gallery">
            <div class="pizza-item">
                <img src="https://www.stefanofaita.com/wp-content/uploads/2022/04/pizzamargherita1-1200x900.jpg" alt="Pizza Margherita">
                <div class="pizza-info">
                    <h3>Pizza Margherita</h3>
                    <p>La clásica Pizza Margherita, hecha con salsa de tomate fresca, mozzarella y albahaca. Perfecta para los amantes de los sabores tradicionales.</p>
                    <p class="price">RD$499.99</p>
                </div>
            </div>
            <div class="pizza-item">
                <img src="https://www.simplyrecipes.com/thmb/KE6iMblr3R2Db6oE8HdyVsFSj2A=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/__opt__aboutcom__coeus__resources__content_migration__simply_recipes__uploads__2019__09__easy-pepperoni-pizza-lead-3-1024x682-583b275444104ef189d693a64df625da.jpg" alt="Pizza Pepperoni">
                <div class="pizza-info">
                    <h3>Pizza Pepperoni</h3>
                    <p>Deliciosa Pizza Pepperoni con generosas porciones de pepperoni y queso mozzarella, horneada a la perfección.</p>
                    <p class="price">RD$299.99</p>
                </div>
            </div>
            <div class="pizza-item">
                <img src="https://www.paulinacocina.net/wp-content/uploads/2023/11/como-hacer-pizza-hawaiana-Paulina-Cocina-Recetas.jpg" alt="Pizza Hawaiana">
                <div class="pizza-info">
                    <h3>Pizza Hawaiana</h3>
                    <p>Una combinación dulce y salada de piña fresca y jamón sobre una base de salsa de tomate y queso mozzarella.</p>
                    <p class="price">RD$249.99</p>
                </div>
            </div>
            <div class="pizza-item">
                <img src="https://www.institucionalcolombia.com/wp-content/uploads/2023/01/Pizza_vegetariana.jpg" alt="Pizza Vegetariana">
                <div class="pizza-info">
                    <h3>Pizza Vegetariana</h3>
                    <p>Nuestra Pizza Vegetariana está hecha con los ingredientes más frescos, incluyendo pimientos, cebollas, champiñones y tomates cherry.</p>
                    <p class="price">RD$399.99</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
