<?php
session_start();
if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
    $path = "logout.php";
} else {
    $login = "Entrar";
    $path = "login.php";
}
?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="index.php">Top Indian Movies</a>

        <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="generos.php">Géneros</a></li>
                <li class="nav-item"><a class="nav-link" href="filmes.php">Filmes</a></li>
                <?php
                if (isset($_SESSION['login'])) {
                ?>
                    <li class="nav-item"><a class="nav-link" href="favoritos.php">Favoritos</a></li>
                <?php
                }
                if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 1) {
                ?>
                    <li class="nav-item"><a class="nav-link" href="add_filme.php">Inserir filme</a></li>
                <?php
                }
                ?>

                <li class="nav-item"><a class="nav-link" href=<?= $path ?>><i class="fa-regular fa-user"></i>
                        <?php echo $login ?>
                    </a></li>
            </ul>
        </div>
    </div>
</nav>