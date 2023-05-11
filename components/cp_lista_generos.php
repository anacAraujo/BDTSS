<?php
require_once "./connections/connection.php";
?>

<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-3">
        <!-- Intro -->
        <?php include_once "./components/cp_intro_generos.php"; ?>

        <!-- Listar filmes -->
        <div class="row">

            <?php
            $link = new_db_connection();
            $stmt = mysqli_stmt_init($link);

            $query = "SELECT id_generos, tipo FROM generos
                      ORDER BY tipo";

            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $id_generos, $tipo);

                while (mysqli_stmt_fetch($stmt)) {
                    echo '<h3><a href="genero_filmes.php?id=' . $id_generos . '">' . $tipo . '</a>';

                    if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 1) {
                        echo ' <a href = "update_genero.php?id=' . $id_generos . '">Editar</a>';
                        echo ' <a href = "scripts/generos/sc_delete_genero.php?id=' . $id_generos . '">X</a>';
                    }

                    echo '</h3>';
                }

                mysqli_stmt_close($stmt);
            } else {
                echo mysqli_error($link);
            }

            mysqli_close($link);

            ?>
        </div>

        <!-- Inserir genero -->
        <?php

        if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "1") {
            if (isset($_GET['error']) && $_GET['error'] != "") {
                if ($_GET['error'] == "tooshort") {
                    echo "Tem que ter mais que três caracteres.";
                }
            }
            include_once "./components/cp_add_genero.php";
        }


        ?>

    </div>
</section>