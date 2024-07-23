<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

// Inicializar carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Función para agregar producto al carrito
function addToCart($product, $price) {
    $_SESSION['cart'][] = [
        'name' => $product,
        'price' => $price
    ];
}

// Manejar solicitudes de agregar al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product']) && isset($_POST['price'])) {
        addToCart($_POST['product'], $_POST['price']);
        $_SESSION['product_added'] = true; // Indicar que se agregó un producto
        header('Location: menu.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú</title>
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
            background: url('https://th.bing.com/th/id/OIP.Eo--SbCP_SETgkjBdN1a_AHaE8?rs=1&pid=ImgDetMain') no-repeat center center fixed;
            background-size: cover;
            flex: 1;
        }

        .titlee {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }

        .menu-section {
            background: rgba(120, 120, 120, 0.8);
            padding: 20px;
            margin-bottom: 20px;
            color: black;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .menu-item {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            background-color: #1f1f1f;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .menu-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .menu-item img {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            margin-right: 20px;
        }

        .menu-item-title {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 5px;
            color: #ffa500;
        }

        .menu-item-description {
            font-style: italic;
            margin-bottom: 5px;
            color: #ccc;
        }

        .menu-item-price-top {
            color: #999;
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        .menu-item-link {
            display: inline-block;
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .menu-item-link:hover {
            background-color: #45a049;
        }

        h2 {
            color: #ffa500;
            margin-bottom: 10px;
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

            .menu-item {
                width: 100%;
            }
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
        <h1 class="titlee">Menú</h1>
        <p class="titlee">Explore nuestros deliciosos platos.</p>

        <!-- Sección de Pizzas Clásicas -->
        <div class="menu-section">
            <h2 class="titleee">Pizzas Clásicas</h2>
            <div class="menu-item">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Eq_it-na_pizza-margherita_sep2005_sml.jpg" alt="Margarita">
                <div>
                    <div class="menu-item-title">Margherita</div>
                    <div class="menu-item-description">Salsa de tomate, mozzarella, albahaca fresca</div>
                    <div class="menu-item-price-top">Precio: RD$499.99</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Margherita">
                        <input type="hidden" name="price" value="499.99">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://2trendies.com/hero/2023/04/pizzapepperoni.jpg?width=1200" alt="Pepperoni">
                <div>
                    <div class="menu-item-title">Pepperoni</div>
                    <div class="menu-item-description">Salsa de tomate, mozzarella, pepperoni</div>
                    <div class="menu-item-price-top">Precio: RD$299.99</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Pepperoni">
                        <input type="hidden" name="price" value="299.99">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://www.comedera.com/wp-content/uploads/2022/04/Pizza-cuatro-quesos-shutterstock_1514858234.jpg" alt="Cuatro Quesos">
                <div>
                    <div class="menu-item-title">Cuatro Quesos</div>
                    <div class="menu-item-description">Salsa de tomate, mozzarella, gorgonzola, parmesano, queso de cabra</div>
                    <div class="menu-item-price-top">Precio: RD$349.99</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Cuatro Quesos">
                        <input type="hidden" name="price" value="349.99">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://www.hogarmania.com/archivos/202401/pizza-hawaiana-1280x720x80xX.jpg" alt="Hawaiana">
                <div>
                    <div class="menu-item-title">Hawaiana</div>
                    <div class="menu-item-description">Salsa de tomate, mozzarella, jamón, piña</div>
                    <div class="menu-item-price-top">Precio: RD$249.99</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Hawaiana">
                        <input type="hidden" name="price" value="249.99">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://i.ytimg.com/vi/6jNMinJKE40/maxresdefault.jpg" alt="Vegetariana">
                <div>
                    <div class="menu-item-title">Vegetariana</div>
                    <div class="menu-item-description">Salsa de tomate, mozzarella, pimientos, champiñones, cebolla, aceitunas, espinacas</div>
                    <div class="menu-item-price-top">Precio: RD$399.99</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Vegetariana">
                        <input type="hidden" name="price" value="399.99">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sección de Pizzas Especiales -->
        <div class="menu-section">
            <h2 class="titleee">Pizzas Especiales</h2>
            <div class="menu-item">
                <img src="https://mandolina.co/wp-content/uploads/2023/07/pizza-mexciana.png" alt="Mexicana">
                <div>
                    <div class="menu-item-title">Mexicana</div>
                    <div class="menu-item-description">Salsa de tomate, mozzarella, chorizo, jalapeños, pimientos, cebolla, maíz</div>
                    <div class="menu-item-price-top">Precio: RD$599.99</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Mexicana">
                        <input type="hidden" name="price" value="599.99">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://www.comedera.com/wp-content/uploads/2022/04/pizza-barbacoa.jpg" alt="Barbacoa">
                <div>
                    <div class="menu-item-title">Barbacoa</div>
                    <div class="menu-item-description">Salsa barbacoa, mozzarella, pollo, cebolla, pimientos</div>
                    <div class="menu-item-price-top">Precio: RD$549.99</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Barbacoa">
                        <input type="hidden" name="price" value="549.99">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://4.bp.blogspot.com/-Z2yh7Rt-ukU/WmpcSrkZyvI/AAAAAAAAQ1A/4LhieUqYb18hEhGgk7AO0HKOK4DjUhBBwCK4BGAYYCw/s1600/pizza%2Bmarinera%2B1.jpg" alt="Marinera">
                <div>
                    <div class="menu-item-title">Marinera</div>
                    <div class="menu-item-description">Salsa de tomate, mozzarella, camarones, calamares, mejillones</div>
                    <div class="menu-item-price-top">Precio: RD$499.99</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Marinera">
                        <input type="hidden" name="price" value="499.99">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://www.silviocicchi.com/pizzachef/wp-content/uploads/2015/02/c31.jpg" alt="Caprese">
                <div>
                    <div class="menu-item-title">Caprese</div>
                    <div class="menu-item-description">Salsa de tomate, mozzarella fresca, tomate, albahaca, aceite de oliva</div>
                    <div class="menu-item-price-top">Precio: RD$500.00</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Caprese">
                        <input type="hidden" name="price" value="500.00">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://www.goodnes.com/sites/g/files/jgfbjl321/files/srh_recipes/9a526581da940cf7ef4c0b201110d862.jpg" alt="Prosciutto y Rúcula">
                <div>
                    <div class="menu-item-title">Prosciutto y Rúcula</div>
                    <div class="menu-item-description">Salsa de tomate, mozzarella, prosciutto, rúcula, parmesano</div>
                    <div class="menu-item-price-top">Precio: RD$459.99</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Prosciutto y Rúcula">
                        <input type="hidden" name="price" value="459.99">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQn-5z8bMx2QAsgulSWY20hLs9tJTTlRJPgqQ&s" alt="Mediterránea">
                <div>
                    <div class="menu-item-title">Mediterránea</div>
                    <div class="menu-item-description">Mozzarella, tomate cherry, espinacas frescas, aceitunas negras, salsa de tomate</div>
                    <div class="menu-item-price-top">Precio: RD$600.00</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Mediterránea">
                        <input type="hidden" name="price" value="600.00">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sección de Bebidas -->
        <div class="menu-section">
            <h2 class="titleee">Bebidas: Refrescos</h2>
            <br/>
            <div class="menu-item">
                <img src="https://gestion.pe/resizer/0TjPqLSdP-c9YwLyFaC2nuUtIps=/580x330/smart/filters:format(jpeg):quality(75)/cloudfront-us-east-1.images.arcpublishing.com/elcomercio/O5QO5KL3MVHGBFNHG3X6BA6XYI.jpg" alt="Coca Cola">
                <div>
                    <div class="menu-item-title">Coca-Cola</div>
                    <div class="menu-item-price-top">Precio: RD$75</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Coca-Cola">
                        <input type="hidden" name="price" value="75">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://chilpa.mx/wp-content/uploads/2021/10/cocacola_light.jpg" alt="Coca Cola Light">
                <div>
                    <div class="menu-item-title">Coca Cola Light</div>
                    <div class="menu-item-price-top">Precio: RD$80</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Coca Cola Light">
                        <input type="hidden" name="price" value="80">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQBnLEqFEu6jaNy0rblxmurYEcFh7LglCnPFw&s" alt="Sprite">
                <div>
                    <div class="menu-item-title">Sprite</div>
                    <div class="menu-item-price-top">Precio: RD$80</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Sprite">
                        <input type="hidden" name="price" value="80">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://okdiario.com/img/2022/05/01/coca-cola-pepsi.jpeg" alt="Pepsi">
                <div>
                    <div class="menu-item-title">Pepsi</div>
                    <div class="menu-item-price-top">Precio: RD$85</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Pepsi">
                        <input type="hidden" name="price" value="85">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>

            <h2 class="titleee">Bebidas: Jugos Naturales</h2>
            <br/>
            <div class="menu-item">
                <img src="https://media-cdn.tripadvisor.com/media/photo-s/14/31/ee/89/zumo-de-naranja-natural.jpg" alt="Jugo de Naranja">
                <div>
                    <div class="menu-item-title">Jugo de Naranja</div>
                    <div class="menu-item-price-top">Precio: RD$130</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Jugo de Naranja">
                        <input type="hidden" name="price" value="130">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://img.freepik.com/fotos-premium/jugo-mango-toques-fruta-mango-restaurante-fondo-estudio-jardin_741910-6930.jpg" alt="Jugo de Mango">
                <div>
                    <div class="menu-item-title">Jugo de Mango</div>
                    <div class="menu-item-price-top">Precio: RD$145</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Jugo de Mango">
                        <input type="hidden" name="price" value="145">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://img.freepik.com/fotos-premium/jugo-pina-toques-fruta-pina-restaurante-fondo-estudio-jardin_741910-8025.jpg" alt="Jugo de Piña">
                <div>
                    <div class="menu-item-title">Jugo de Piña</div>
                    <div class="menu-item-price-top">Precio: RD$110</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Jugo de Piña">
                        <input type="hidden" name="price" value="110">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://media-cdn.tripadvisor.com/media/photo-s/14/b7/ae/4b/jugos-naturales.jpg" alt="Jugo de Fresa">
                <div>
                    <div class="menu-item-title">Jugo de Fresa</div>
                    <div class="menu-item-price-top">Precio: RD$160</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Jugo de Fresa">
                        <input type="hidden" name="price" value="160">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://imagenes.eltiempo.com/files/image_1200_600/uploads/2023/05/04/64543fc52f095.jpeg" alt="Jugo de Melón">
                <div>
                    <div class="menu-item-title">Jugo de Melón</div>
                    <div class="menu-item-price-top">Precio: RD$110</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Jugo de Melón">
                        <input type="hidden" name="price" value="110">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://www.recetas-guatemala.com/base/stock/Recipe/151-image/151-image_web.jpg" alt="Jugo de Tamarindo">
                <div>
                    <div class="menu-item-title">Jugo de Tamarindo</div>
                    <div class="menu-item-price-top"> Precio: RD$110</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Jugo de Tamarindo">
                        <input type="hidden" name="price" value="110">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>

            <h2 class="titleee">Bebidas: Aguas frescas</h2>
            <br/>
            <div class="menu-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTmb_fn_aQL8F_NxLAPZ9hqJaLHg1zVvHHipw&s" alt="Horchata">
                <div>
                    <div class="menu-item-title">Horchata</div>
                    <div class="menu-item-price-top">Precio: RD$100</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Horchata">
                        <input type="hidden" name="price" value="100">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://media-cdn.tripadvisor.com/media/photo-s/1c/3d/6e/45/deliciosa-agua-sabor.jpg" alt="Jamaica">
                <div>
                    <div class="menu-item-title">Jamaica</div>
                    <div class="menu-item-price-top">Precio: RD$95</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Jamaica">
                        <input type="hidden" name="price" value="95">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://t0.gstatic.com/licensed-image?q=tbn:ANd9GcQsq3XWKnbNQ_oum_7plCiKI9SbjorAK9AgBrctCOkpIy3R-Q8g252SV55EHpebETl1" alt="Tamarindo">
                <div>
                    <div class="menu-item-title">Hibiscus tea</div>
                    <div class="menu-item-price-top">Precio: RD$85</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Tamarindo">
                        <input type="hidden" name="price" value="85">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://cdn.aarp.net/content/dam/aarpe/es/home/cocina/recetas/info-2014/fotos-jugos-frutas-vegetales-rose-colon/_jcr_content/root/container_main/container_body_main/list_container_body1/container_body_cf/body_one_cf_listicle_four/cfimage.coreimg.50.932.jpeg/content/dam/aarp/food/recipes/2023/05/1140-green-juice-and-lime-esp.jpg" alt="Limonada">
                <div>
                    <div class="menu-item-title">Limón</div>
                    <div class="menu-item-price-top">Precio: RD$80</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Limón">
                        <input type="hidden" name="price" value="80">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>

            <h2 class="titleee">Bebidas: Cervezas</h2>
            <br/>
            <div class="menu-item">
                <img src="https://eldiariony.com/wp-content/uploads/sites/2/2022/07/Cerveza-Corona-shutterstock_1950046264.jpg?w=2600" alt="Corona">
                <div>
                    <div class="menu-item-title">Corona</div>
                    <div class="menu-item-price-top">Precio: RD$150</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Corona">
                        <input type="hidden" name="price" value="150">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://yao.com.do/wp-content/uploads/2020/03/modelo-varias.jpg" alt="Modelo Especial">
                <div>
                    <div class="menu-item-title">Modelo Especial</div>
                    <div class="menu-item-price-top">Precio: RD$170</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Modelo Especial">
                        <input type="hidden" name="price" value="170">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://yao.com.do/wp-content/uploads/2020/03/Presidente-Normal-Light.jpg" alt="Presidente">
                <div>
                    <div class="menu-item-title">Presidente</div>
                    <div class="menu-item-price-top">Precio: RD$180</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Presidente">
                        <input type="hidden" name="price" value="180">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ7jLNO8nvuTyBORv0cVes5DtztRI3jyeQDHQ&s" alt="Negra Modelo">
                <div>
                    <div class="menu-item-title">Negra Modelo</div>
                    <div class="menu-item-price-top">Precio: RD$200</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Negra Modelo">
                        <input type="hidden" name="price" value="200">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>

            <h2 class="titleee">Bebidas: Vinos Copas</h2>
            <br/>
            <div class="menu-item">
                <img src="https://img.freepik.com/fotos-premium/copas-vino-tinto-mesa-antigua-bodega-cerveza_908985-21473.jpg" alt="Vino Tinto">
                <div>
                    <div class="menu-item-title">Vino Tinto</div>
                    <div class="menu-item-price-top">Precio: RD$285</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Vino Tinto">
                        <input type="hidden" name="price" value="285">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQchly1B0QayqO3VKfwizVo6bMpwc9tOzjBNg&s" alt="Vino Blanco">
                <div>
                    <div class="menu-item-title">Vino Blanco</div>
                    <div class="menu-item-price-top">Precio: RD$285</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Vino Blanco">
                        <input type="hidden" name="price" value="285">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://assets.gomarket.com.do/rails/active_storage/representations/proxy/eyJfcmFpbHMiOnsibWVzc2FnZSI6IkJBaHBBMzIwQ3c9PSIsImV4cCI6bnVsbCwicHVyIjoiYmxvYl9pZCJ9fQ==--0fb5e765db1675e449b89f1ec032163f1fd495f3/eyJfcmFpbHMiOnsibWVzc2FnZSI6IkJBaDdDam9MWm05eWJXRjBTU0lKYW5CbFp3WTZCa1ZVT2d0eVpYTnBlbVZKSWc0eE1EQXdlREV3TURBR093WlVPZ3RsZUhSbGJuUkFCem9NWjNKaGRtbDBlVWtpQzBObGJuUmxjZ1k3QmxRNkNXTnliM0JKSWhJeE1EQXdlREV3TURBck1Dc3dCanNHVkE9PSIsImV4cCI6bnVsbCwicHVyIjoidmFyaWF0aW9uIn19--71a44c79d823a1905470f5208969c6cab1cf38a3/64c6a810-3454-4323-96a2-b3b4e51f2617" alt="Vino Rosado">
                <div>
                    <div class="menu-item-title">Vino Rosado</div>
                    <div class="menu-item-price-top">Precio: RD$285</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Vino Rosado">
                        <input type="hidden" name="price" value="285">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>

            <h2 class="titleee">Bebidas: Café y Té</h2>
            <br/>
            <div class="menu-item">
                <img src="https://chilpa.mx/wp-content/uploads/2021/10/cafe_americano.jpg" alt="Café Americano">
                <div>
                    <div class="menu-item-title">Café Americano</div>
                    <div class="menu-item-price-top">Precio: RD$110</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Café Americano">
                        <input type="hidden" name="price" value="110">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c8/Cappuccino_at_Sightglass_Coffee.jpg/1200px-Cappuccino_at_Sightglass_Coffee.jpg" alt="Cappuccino">
                <div>
                    <div class="menu-item-title">Cappuccino</div>
                    <div class="menu-item-price-top">Precio: RD$170</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Cappuccino">
                        <input type="hidden" name="price" value="170">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://www.tasteofhome.com/wp-content/uploads/2023/03/TOH-espresso-GettyImages-1291298315-JVcrop.jpg" alt="Espresso">
                <div>
                    <div class="menu-item-title">Espresso</div>
                    <div class="menu-item-price-top">Precio: RD$140</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Espresso">
                        <input type="hidden" name="price" value="140">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://alkanatur.com/modules/ph_simpleblog/covers/64.jpg" alt="Té Negro">
                <div>
                    <div class="menu-item-title">Té Negro</div>
                    <div class="menu-item-price-top">Precio: RD$95</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Té Negro">
                        <input type="hidden" name="price" value="95">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://static.tuasaude.com/media/article/yp/dt/beneficios-del-te-verde_17350_l.jpg" alt="Té Verde">
                <div>
                    <div class="menu-item-title">Té Verde</div>
                    <div class="menu-item-price-top">Precio: RD$95</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Té Verde">
                        <input type="hidden" name="price" value="95">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>

            <h2 class="titleee">Bebidas: Sin Alcohol</h2>
            <br/>
            <div class="menu-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0JHs0GLgv12GTU-aOBg2AO5It1HlkFMHVkQ&s" alt="Agua Mineral">
                <div>
                    <div class="menu-item-title">Agua Mineral</div>
                    <div class="menu-item-price-top">Precio: RD$85</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Agua Mineral">
                        <input type="hidden" name="price" value="85">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://cdn2.telediario.mx/uploads/media/2022/03/15/el-agua-natural-no-se.jpg" alt="Agua Natural">
                <div>
                    <div class="menu-item-title">Agua Natural</div>
                    <div class="menu-item-price-top">Precio: RD$55</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Agua Natural">
                        <input type="hidden" name="price" value="55">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://media-cdn.tripadvisor.com/media/photo-s/16/4e/4d/9c/soda-italiana.jpg" alt="Soda Italiana">
                <div>
                    <div class="menu-item-title">Soda Italiana</div>
                    <div class="menu-item-price-top">Precio: RD$140</div>
                    <form method="post" action="">
                        <input type="hidden" name="product" value="Soda Italiana">
                        <input type="hidden" name="price" value="140">
                        <button type="submit" class="menu-item-link">Solicitar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Popup para confirmar producto agregado -->
    <div class="popup" id="product-added-popup">
        <div class="popup-content">
            <p>Producto agregado satisfactoriamente.</p>
            <button onclick="closePopup()">Cerrar</button>
        </div>
    </div>

    <script>
        // Mostrar popup si el producto fue agregado
        <?php if (isset($_SESSION['product_added']) && $_SESSION['product_added'] === true): ?>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('product-added-popup').classList.add('visible');
            });
            <?php unset($_SESSION['product_added']); // Limpiar la variable de sesión ?>
        <?php endif; ?>

        // Cerrar popup
        function closePopup() {
            document.getElementById('product-added-popup').classList.remove('visible');
        }
    </script>
</body>
</html>