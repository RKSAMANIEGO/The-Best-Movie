<?php
session_start();

if (!isset($_SESSION["contador"])) {
    $_SESSION["contador"] = 1;
}

if (isset($_POST["next"])) {
    if ($_SESSION["contador"] < 500)
        $_SESSION["contador"]++;
}

if (isset($_POST["back"])) {
    if ($_SESSION["contador"] > 1) {
        $_SESSION["contador"]--;
    }
}

$ch = curl_init("https://api.themoviedb.org/3/movie/popular?api_key=192e0b9821564f26f52949758ea3c473&language=es-MX&page=" . $_SESSION["contador"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$data = json_decode($response, true);
curl_close($ch);

$page = 1;

function handlerBack()
{
    global $page;
    $page++;
}


?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba</title>
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: black;
        color: white;
    }

    header {
        background-color: rgb(51, 51, 197);
        height: 10vh;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 40px;
    }

    label input {
        padding: 5px 10px;
        border-radius: 5px;
        border: none;
        margin-inline-end: 5px;
    }

    main {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px 40px;
    }

    .container-info {
        width: 800px;
        height: 200px;
        overflow: scroll;
    }

    .container-content {
        padding: 40px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-evenly;
        gap: 5px;

    }

    .container-movie {
        width: 200px;
        height: 400px;
    }

    .container-movie img {
        border-radius: 10px;
    }

    .container-movie h3 {
        padding: 10px 0;
    }

    .container-movie section {
        font-size: 0.7rem;
    }

    .container-button {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        background-color: rgb(51, 51, 197);
        height: 10vh;
        padding: 40px;
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    .container-button button {
        padding: 10px 40px;
        border: 1px solid rgb(255, 255, 255);
        border-radius: 10px;
        color: white;
        font-weight: bolder;
        background: linear-gradient(to right, transparent 50%, rgb(155, 4, 105)50%);
        background-position: left;
        background-size: 200%;
        transition: all 0.6s ease-in-out;
    }

    .container-button button:hover {
        background-position: right;
    }
</style>

<body>

    <header>

        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/2560px-PHP-logo.svg.png" alt="logo" width="100px">
        <h2> Pelis Rk Sam </h2>
        <label>
            <input type="text">
            <i class="fa fa-search" aria-hidden="true"></i>
        </label>

    </header>

    <main>
        <section class="container-content">
            <?php foreach ($data["results"] as $movie) : ?>

                <section class="container-movie">
                    <img src="<?= 'https://image.tmdb.org/t/p/w500' . $movie["poster_path"]  ?>" width="200px" alt="<?= $movie["title"] ?> ">
                    <h3> <?= $movie["title"] ?></h3>
                    <section>
                        <p> <?= date("d M Y", strtotime($movie["release_date"]));   ?></p>
                    </section>

                </section>

            <?php endforeach; ?>


        </section>
    </main>

    <footer>
        <form method="POST" class="container-button">
            <button type="submit" name="back">BACK</button>
            <button type="submit" name="next">NEXT</button>
        </form>
    </footer>


</body>

</html>