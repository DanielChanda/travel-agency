<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "./components/_head.php" ?>
    <title>TRAVEL MANAGEMENT</title>
    <style>
        body {
            background-color: #f0f0f0;
        }
        nav#navBar {
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        nav#navBar .logo {
            font-weight: bold;
            font-size: 1.5em;
            color:rgb(148, 47, 17);
            letter-spacing: 2px;
            text-decoration: none;
        }
        nav#navBar .nav-links {
            list-style: none;
            display: flex;
            gap: 2rem;
            margin: 0;
            padding: 0;
        }
        nav#navBar .nav-links li a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        nav#navBar .nav-links li a.active,
        nav#navBar .nav-links li a:hover {
            color: #ff5722;
        }
        .profile-btns {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            margin-left: 1.5rem;
        }
        .profile-btns a {
            color: #333;
            font-size: 1.2em;
            text-decoration: none;
            transition: color 0.2s;
        }
        .profile-btns a:hover {
            color: #ff5722;
        }
        .register-btn {
            background: #ff5722;
            color: #fff !important;
            padding: 0.4em 1.2em;
            border-radius: 20px;
            font-weight: 500;
            transition: background 0.2s;
            margin-left: 1.5rem;
        }
        .register-btn:hover {
            background: #e64a19;
        }
        .fa-bars {
            font-size: 1.5em;
            margin-left: 1.5rem;
            cursor: pointer;
            color: #333;
        }
        .tranding > div,
        .stories .travellers-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .tranding > div:hover,
        .stories .travellers-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 8px 24px rgba(255,87,34,0.15);
        }
        .hero {
            position: relative;
            background-image: url('./img/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 100px 0;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
            background: linear-gradient(90deg, #ff5722, #ff9800, #27ae60);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientMove 3s linear infinite;
        }
        .hero h2 {
            margin-bottom: 20px;
            background: linear-gradient(90deg, #ff5722, #ff9800, #27ae60);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientMove 3s linear infinite;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }
        .hero::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(120deg, rgba(255,87,34,0.7) 0%, rgba(0,0,0,0.5) 100%);
            z-index: 2;
            
        }
        .hero > * {
            position: relative;
            z-index: 3;
        }

        .search-bar {
            margin-top: 20px;
        }

        .search-bar input[type="text"] {
            width: 300px;
            padding: 10px;
            border-radius: 5px;
            border: none;
        }

        .search-bar button {
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            background-color: #ff5722;
            color: white;
            cursor: pointer;
        }
        .search-bar button i {
            font-size: 1.2em;
        }
        .search-bar button:hover {
            background-color: #e64a19;
        }
        .sub-title {
            text-align: center;
            margin: 2rem 0;
            font-size: 2em;
            color: #333;
        }
        .cta {
            background: #ff5722;
            color: white;
            padding: 2rem;
            text-align: center;
            border-radius: 10px;
            margin: 2rem 0;
        }
        .cta-btn {
            display: inline-block;
            background: #27ae60;
            color: #fff;
            padding: 0.8em 2em;
            border-radius: 30px;
            font-size: 1.1em;
            margin-top: 1em;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(39,174,96,0.08);
            transition: background 0.2s, transform 0.2s;
        }
        .cta-btn:hover {
            background: #219150;
            transform: scale(1.05);
        }
        .tranding {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .tranding > div {
            flex: 1 1 200px;
            max-width: 220px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            text-align: center;
        }
        .tranding img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            display: block;
        }
        .tranding h3 {
            margin: 0.5em 0 1em 0;
            font-size: 1.1em;
            color: #333;
        }
        .container, .tranding > div, .stories .travellers-card, .cta {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s forwards;
        }
        .tranding > div { animation-delay: 0.2s; }
        .stories .travellers-card { animation-delay: 0.4s; }
        .cta { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: none;
            }
        }
        @media (max-width: 900px) {
            .tranding {
                gap: 12px;
            }
            .tranding > div {
                max-width: 45vw;
            }
        }
        @media (max-width: 600px) {
            .tranding {
                flex-direction: column;
                gap: 16px;
            }
            .tranding > div {
                max-width: 100%;
            }
            .tranding img {
                height: 180px;
            }
        }
        
    </style>
</head>

<body>
    <div class="header">
        <nav id="navBar">
            <a href="./index.php" class="logo"> TMS </a>
            <ul class="nav-links">
                <li><a href="./index.php" class="active">Popular Places</a></li>
                <li><a href="./listing.php">All packages</a></li>
            </ul>
            <?php include("./components/_navBtns.php") ?>
        </nav>
        <div class="container hero">
            <?php
                if(isset($_SESSION["username"])){
                    echo '<h2>Welcome '.$_SESSION["username"].'!</h2>';
                }
            ?>
            <h1>Travel Like Never Before</h1>
            <div class="search-bar">
                <form method="post" id="search_form">
                    <div class="location-input">
                        <label>Location</label>
                        <input required type="text" id="location" placeholder="Where are you going?">
                    </div>
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>
    </div>


    <!-- ---------exclusives------------ -->
    <div class="container">


        <!-- -------------------Trending Places------------- -->

        <h2 class="sub-title">Trending Places</h2>
        <div class="tranding">
            <div>
                <img src="img/2.jpg">
                <h3>siavonga</h3>
            </div>
            <div>
                <img src="img/3.jpg">
                <h3>livingstone</h3>
            </div>
            <div>
                <img src="img/4.jpg">
                <h3>lake kaliba</h3>
            </div>
            <div>
                <img src="img/5.jpg">
                <h3>Samfya Beach</h3>
            </div>
        </div>


        <!-- ---------------call to action----------- -->
        <div class="cta">
            <h3>Awesome Packages <br> For you and your friends/family.</h3>
            <p>Great combo with unbeatable prices <br> transport, accomodation & food all inclusive.</p>
            <a href="#" class="cta-btn">Book your first tour now!</a>
        </div>

        <!-- ==============Travellers Stories============== -->

        <h2 class="sub-title">Travellers Stories</h2>
        <div class="stories">
            <div class="travellers-card">
                <img src="img/devilspoolcam.jpg">
                <p><a href="https://www.zambiatourism.com/">Travelling in Zambia</a>
                </p>
            </div>
            <div class="travellers-card">
                <img src="img/VictoriaFalls.jpg">
                <p><a href="https://www.zambia.travel/victoriafalls.html">Victoria False</a></p>
            </div>
            <div class="travellers-card">
                <img src="img/Busanga.jpg">
                <p><a href="https://www.zambia.travel/kafuenp.html">Kafue National Park</a></p>
            </div>
        </div>
        <a href="https://www.mot.gov.zm/" class="Start-btn">Go to travel blog</a>
    </div>
    <!-- ===============footer================ -->
    <?php include "./components/_footer.php" ?>
    <?php include "./components/_js.php" ?>
    <script>
        $("#search_form").submit(e => {
            e.preventDefault();
            var loc = $("#location").val();
            var guest = $("#guest").val();
            window.location = `http://localhost/triptrip/listing.php?loc=${loc}&g=${guest}`;
        })
    </script>
</body>

</html>