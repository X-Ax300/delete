<!-- about.php -->
<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #121212;
        /* Fondo negro */
        color: #fff;
        /* Texto blanco */
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .titlee {
        text-align: center;
        font-size: 36px;
        margin-bottom: 20px;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        width: 100%;
        background-color: #1f1f1f;
        /* Fondo gris oscuro */
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

    .about-section {
        background-image: url('https://st.depositphotos.com/1005920/2288/i/450/depositphotos_22888872-stock-photo-restaurant.jpg');
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        padding: 100px 20px;
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

    .about-section h1 {
        font-size: 48px;
        margin-bottom: 20px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
    }

    .about-section p {
        font-size: 24px;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.5;
        text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.5);
    }

    .about-content {
        background-color: #1f1f1f;
        padding: 50px 20px;
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

    .about-content h2 {
        font-size: 36px;
        margin-bottom: 40px;
        color: #ffa500;
    }

    .about-content p {
        font-size: 20px;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.5;
    }

    .mission-section {
        background-color: #121212;
        padding: 50px 20px;
        text-align: center;
    }

    .mission-section h2 {
        font-size: 36px;
        margin-bottom: 40px;
        color: #ffa500;
    }

    .mission-section p {
        font-size: 20px;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.5;
    }

    .vision-section {
        background-color: #363636;
        padding: 50px 20px;
        text-align: center;
    }
    .vision-section h2 {
        font-size: 36px;
        margin-bottom: 40px;
        color: #ffa500;
    }

    .vision-section p {
        font-size: 20px;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.5;
    }

    .team-section {
        background-color: #1f1f1f;
        padding: 50px 20px;
        text-align: center;
    }

    .team-section h2 {
        font-size: 36px;
        margin-bottom: 40px;
        color: #ffa500;
    }

    .team-gallery {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .team-item {
        background-color: #121212;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        width: 300px;
        text-align: left;
    }

    .team-item img {
        width: 300px;
        height: 300px;
        object-fit: cover;
    }

    .team-info {
        padding: 15px;
    }

    .team-info h3 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #ffa500;
    }

    .team-info p {
        font-size: 16px;
        margin-bottom: 10px;
        color: #ccc;
    }

    .team-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    @media (max-width: 991px) {
        .about-section h1 {
            font-size: 36px;
        }

        .about-section p {
            font-size: 18px;
        }

        .about-content h2 {
            font-size: 28px;
        }

        .mission-section h2 {
            font-size: 28px;
        }

        .team-section h2 {
            font-size: 28px;
        }

        .team-item {
            width: 100%;
        }
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
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">Sobre Nosotros</a></li>
                <li><a href="menu.php">Menú</a></li>
                <li><a href="reservations.php">Reservas</a></li>
                <li><a href="billing.php">Facturación</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <section class="about-section">
        <h1>Sobre Nosotros</h1>
        <p>Descubre la historia y la misión de nuestra pizzería.</p>
    </section>
    <section class="about-content">
        <h2 class="titlee">Nuestra Historia</h2>
        <p>La Deliciosa fue fundada en 2024 con el sueño de crear un lugar donde las personas pudieran disfrutar de
            pizzas artesanales hechas con los ingredientes más frescos y de la mejor calidad. Desde nuestros humildes
            comienzos, nos hemos expandido para servir a nuestra comunidad con pasión y dedicación.</p>
        <p>Nos enorgullecemos de ser un negocio familiar, donde cada pizza se hace con amor y atención al detalle.
            Nuestra receta secreta de masa, junto con nuestra salsa de tomate casera y una selección de ingredientes
            premium, nos ha permitido ganar una reputación como una de las mejores pizzerías de la ciudad.</p>
    </section>
    <section class="mission-section">
        <h2>Nuestra Misión</h2>
        <p>En La Deliciosa, nuestra misión es simple: crear una experiencia gastronómica inolvidable para cada cliente.
            Nos esforzamos por ofrecer no solo pizzas deliciosas, sino también un ambiente acogedor y un servicio
            excepcional. Cada miembro de nuestro equipo comparte la pasión por la excelencia culinaria y la satisfacción
            del cliente.</p>
        <p>Estamos comprometidos con la sostenibilidad y el apoyo a los agricultores locales. Utilizamos ingredientes
            frescos y orgánicos siempre que es posible, y nuestras pizzas están hechas a mano todos los días en nuestra
            cocina.</p>
    </section>
    <section class="vision-section">
            <h2>Nuestra Visión</h2>
            <p>En La Deliciosa, nuestra visión es clara: ser el referente principal en la gastronomía de pizzas
                artesanales. Queremos que cada visita sea una celebración de sabores únicos y experiencias memorables.
                Nos dedicamos a superar las expectativas de nuestros clientes con cada bocado.</p>
            <p>Nos comprometemos a innovar constantemente, respetando siempre nuestras raíces y tradiciones culinarias.
                Creemos en la importancia de la sostenibilidad y el apoyo a los agricultores locales, utilizando
                ingredientes frescos y orgánicos siempre que sea posible. Nuestras pizzas se elaboran a mano todos los
                días, garantizando calidad y autenticidad en cada porción.</p>
        </section>
    <section >
        <section class="team-section">
            <h2>Conoce a Nuestro Equipo</h2>
            <div class="team-gallery">
                <div class="team-item">
                    <img src="https://scontent.fhex2-1.fna.fbcdn.net/v/t39.30808-6/321994623_543979144072233_4796080618386613255_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=833d8c&_nc_eui2=AeE1KYgdpSELOIX9aJc8A8ym-ikCpKbetzf6KQKkpt63N4q0OqW_Wy382zG8896aLmP4fc4hwpKlgqVoKdHUKvQU&_nc_ohc=JGVCq6X0w9MQ7kNvgHGii1o&_nc_ht=scontent.fhex2-1.fna&oh=00_AYDT9LZ-d63m8MHPQnRKGKuTrwUu1gDru7BYeNlBGddMLA&oe=66A2EBA6"
                        alt="Fundador">
                    <div class="team-info">
                        <h3>Dianny Mateo</h3>
                        <p>Fundadora y Maestro Pizzero</p>
                    </div>
                </div>
                <div class="team-item">
                    <img src="images/Elayne.jpg" alt="Chef">
                    <div class="team-info">
                        <h3>Elayne Laguna</h3>
                        <p>Gerente Ejecutiva</p>
                    </div>
                </div>
                <div class="team-item">
                    <img src="images/Wiliany.jpg" alt="Gerente">
                    <div class="team-info">
                        <h3>Wiliany García</h3>
                        <p>Gerente General</p>
                    </div>
                </div>
                <div class="team-item">
                    <img src="images/Harol.jpg" alt="Gerente">
                    <div class="team-info">
                        <h3>Harol Reyes</h3>
                        <p>Chef General</p>
                    </div>
                </div>
                <div class="team-item">
                    <img src="images/Loren.jpg" alt="Gerente">
                    <div class="team-info">
                        <h3>Loren Santi</h3>
                        <p>Maestro Pizzero</p>
                    </div>
                </div>
                <div class="team-item">
                    <img src="https://cocinoyconvido.cl/cdn/shop/products/IMG-2365_1800x.jpg?v=1648206503" alt="Staff">
                    <div class="team-info">
                        <h3>Equipo de Cocina</h3>
                        <p>Nuestro dedicado equipo de cocina</p>
                    </div>
                </div>

            </div>
            </div>
        </section>
</body>

</html>