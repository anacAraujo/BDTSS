<?php
// conexão à base de dados
include_once "connections/connection.php";

// Verify the query string requirements
if (isset($_GET["id"])) {
    // Store values
    $id_filmes = (int) $_GET["id"];

    // Create a new DB connection
    $link = new_db_connection();

    // Create a prepared statement
    $stmt = mysqli_stmt_init($link);

    // Define the query
    $query = "SELECT titulo, ano, sinopse, capa, url_imdb, url_trailer, tipo 
    FROM filmes 
    INNER JOIN generos 
    ON generos.id_generos = filmes.ref_generos WHERE id_filmes = ?";

    // Prepare the statement
    if (mysqli_stmt_prepare($stmt, $query)) {
        // Bind values to parameters
        mysqli_stmt_bind_param($stmt, 'i', $id_filmes);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $titulo, $ano, $sinopse, $capa, $url_imdb, $url_trailer, $tipo);

            // Fetch values
            if (mysqli_stmt_fetch($stmt)) {
?>
                <section class="sec-filmes pb-5" id="detalhe-filme">
                    <div class="container px-lg-5 pt-3">
                        <a class="btn btn-info" href="filmes.php">Voltar</a>
                        <h1 class="pt-5 pb-3"><?php echo $titulo ?></h1>
                        <div class="row d-flex flex-row justify-content-between">
                            <div class="col detalhes">
                                <img class="img-fluid mb-3" src=<?php echo "imgs/capas/" . $capa; ?> />
                            </div>
                            <div class="col detalhes">
                                <h4 class="text-primary">
                                    <span class="text-black-50"><?php echo $ano ?></span> | <?php echo $tipo ?>

                                    <?php
                                    if (isset($_SESSION['id'])) {
                                        $query_2 = "SELECT ref_utilizadores, ref_filmes FROM filmes_favoritos WHERE  ref_utilizadores = ? AND ref_filmes = ?";
                                        $stmt_2 = mysqli_stmt_init($link);
                                        $user = $_SESSION['id'];

                                        // Execute the prepared statement 
                                        if (mysqli_stmt_prepare($stmt_2, $query_2)) {
                                            // Bind result variables
                                            mysqli_stmt_bind_param($stmt_2, "ii", $user, $id_filmes);
                                            mysqli_stmt_execute($stmt_2);

                                            mysqli_stmt_store_result($stmt_2);

                                            // Verifica se não há favoritos
                                            if (mysqli_stmt_num_rows($stmt_2) == 0) {
                                                // Adiciona Favorito
                                                echo '<a href="scripts/favoritos/sc_add_favorito.php?id=' . $id_filmes . '"><b><i class="fa-sharp fa-regular fa-heart  mx-2"></i></b></a>';
                                            } else {
                                                // Remove Favorito
                                                echo '<a href="scripts/favoritos/sc_delete_favorito.php?id=' . $id_filmes . '"><b><i class="fa-sharp fa-solid fa-heart  mx-2"></i></b></a>';
                                            }
                                        }
                                    }
                                    if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "1") {
                                        echo '<a href="edit_filme.php?id=' . $id_filmes . '"><b><i class="fa-solid fa-pen-to-square mx-2"></i></b></a>';
                                        echo '<a href="scripts/filmes/sc_delete_filme.php?id=' . $id_filmes . '"><b><i class="fa-solid fa-trash-can mx-2"></i></b></a>';
                                    }
                                    if (isset($_SESSION['id'])) {
                                        $stmt_3 = mysqli_stmt_init($link);

                                        $user = $_SESSION['id'];

                                        // Define the query
                                        $query_3 = "SELECT votacao
                                                    FROM filmes_votacao
                                                    INNER JOIN utilizadores
                                                    ON utilizadores.id_utilizadores = filmes_votacao.ref_utilizadores
                                                    INNER JOIN filmes
                                                    ON filmes.id_filmes = filmes_votacao.ref_filmes
                                                    WHERE id_utilizadores = ? AND id_filmes = ?";

                                        // Prepare the statement
                                        if (mysqli_stmt_prepare($stmt_3, $query_3)) {

                                            mysqli_stmt_bind_param($stmt_3, 'ii', $_user, $id_filmes);

                                            // Execute the prepared statement
                                            if (mysqli_stmt_execute($stmt_3)) {
                                                // Bind result variables
                                                mysqli_stmt_bind_result($stmt_3, $votacao);

                                                mysqli_stmt_store_result($stmt_3);

                                                if (mysqli_stmt_num_rows($stmt_3) == 0) {
                                    ?>
                                                    <form class="col-6" action="./scripts/filmes/sc_votacao_filme.php?id=<?php echo $id_filmes; ?>" method="post">
                                                        <div class="mb-3 mt-3"><label for="uname" class="form-label">Avalie o filme:</label><input type="number" class="form-control" id="votacao" value="" name="votacao" min="1" max="10" step="1" value="">
                                                            <div class="valid-feedback">Valid.</div>
                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Inserir</button>
                                                    </form>
                                                <?php
                                                } else {
                                                ?>
                                                    <p class="tipo-filme mb-0"><?php echo $votacao ?></p>
                                    <?php
                                                }
                                            } else {
                                                // Execute error
                                                echo "Error: " . mysqli_stmt_error($stmt_3);
                                            }
                                        } else {
                                            // Errors related with the query
                                            echo "Error: " . mysqli_error($link);
                                        }
                                        // Close statement
                                        mysqli_stmt_close($stmt_3);
                                    }
                                    ?>
                                </h4>

                                <div class="card pb-2 mt-4 shadow rounded">
                                    <div class="card-body">
                                        <h4 class="text-uppercase text-primary m-0 mt-2">Sinopse</h4>
                                        <hr class="my-3 mx-auto" />
                                        <p class="tipo-filme mb-0"><?php echo $sinopse ?></p>

                                    </div>
                                </div>
                                <a class="d-block btn btn-primary mt-4" href="<?php echo $url_trailer ?>" target="_blank">Trailer</a>
                                <a class="d-block btn btn-outline-primary mt-4" href="<?php echo $url_imdb ?>" target="_blank">IMDb</a>

                                <h4 class="text-uppercase text-primary mt-5">Comentários</h4>
                                <div class="card pb-2 mt-4 shadow rounded">

                                    <?php
                                    $query_4 = "SELECT comentario, nome, comentarios.data_insercao 
                                            FROM comentarios
                                            INNER JOIN utilizadores
                                            ON ref_utilizadores = id_utilizadores
                                            WHERE ref_filmes = ?";

                                    $stmt_4 = mysqli_stmt_init($link);

                                    // Execute the prepared statement 
                                    if (mysqli_stmt_prepare($stmt_4, $query_4)) {
                                        // Bind result variables
                                        mysqli_stmt_bind_param($stmt_4, "i", $id_filmes);
                                        mysqli_stmt_execute($stmt_4);

                                        mysqli_stmt_store_result($stmt_4);

                                        // Bind result variables
                                        mysqli_stmt_bind_result($stmt_4, $comentario, $nome, $hora);

                                        // Verifica se não há comentarios
                                        if (mysqli_stmt_num_rows($stmt_4) == 0) {
                                    ?>
                                            <div class="card-body">
                                                <h4 class="text-uppercase text-primary m-0 mt-2">Comentários</h4>
                                                <hr class="my-3 mx-auto" />
                                                <p class="tipo-filme mb-0">Ainda sem comentários. Sê o primeiro!</p>
                                            </div>
                                            <?php

                                        } else {
                                            // Fetch values
                                            while (mysqli_stmt_fetch($stmt_4)) {
                                            ?>
                                                <div class="card-body">
                                                    <h4 class="text-uppercase text-primary m-0 mt-2"><?php echo $nome ?></h4>
                                                    <p class="tipo-filme mb-0"><?php echo $comentario ?></p>
                                                    <p class="tipo-filme mb-0"><?php echo $hora ?></p>
                                                </div>
                                    <?php
                                            }
                                        }
                                    }
                                    mysqli_stmt_close($stmt_4);
                                    ?>

                                </div>
                                <?php
                                if (isset($_SESSION['id'])) {
                                ?>
                                    <form action="./scripts/filmes/sc_comentar_filme.php?id=<?php echo $id_filmes; ?>" method="post">
                                        <div class="mb-3 mt-3"><label for="uname" class="form-label">Comentar:</label><textarea class="form-control" id="comentario" value="" name="comentario" rows="1"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Adicionar comentário</button>
                                    </form>
                                <?php
                                }

                                ?>
                            </div>
                        </div>
                    </div>
                </section>

            <?php
            } else {
            ?>
                <div class="alert-warningp-4">O filme que procura não existe!</div><a class="btn btn-info mt-4" href="filmes.php">Voltar</a>
<?php
            }
        } else {
            // Execute error
            echo "Error: " . mysqli_stmt_error($stmt);
        }
    } else {
        // Errors related with the query
        echo "Error: " . mysqli_error($link);
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
}

?>