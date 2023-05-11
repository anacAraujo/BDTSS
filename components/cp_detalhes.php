<?php
// conexão à base de dados
include_once "connections/connection.php";
?>

<?php

// Verify the query string requirements
if (isset($_GET["id"])) {
    // Store values
    $id_filmes = (int) $_GET["id"];


    // Create a new DB connection
    $link = new_db_connection();

    // Create a prepared statement
    $stmt = mysqli_stmt_init($link);

    // Define the query
    $query = "SELECT titulo, ano, sinopse, capa, url_imdb, url_trailer, tipo FROM filmes INNER JOIN generos ON generos.id_generos = filmes.ref_generos WHERE id_filmes = ?";

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