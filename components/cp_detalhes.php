<?php
// conexão à base de dados
include_once "connections/connection.php";
?>

<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: filmes.php');
}
// Verify the query string requirements
if (isset($_GET["id"])) {
    // Store values
    $id_filmes = (int) $_GET["id"];

    // We need the function!
    require_once("./connections/connection.php");

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
                                </h4>
                                <div class="card pb-2 mt-4 shadow rounded">
                                    <div class="card-body">
                                        <h4 class="text-uppercase text-primary m-0 mt-2">Sinopse</h4>
                                        <hr class="my-3 mx-auto" />
                                        <p class="tipo-filme mb-0"><?php echo $sinopse ?></p>
                                    </div>
                                </div>
                                <a class="d-block btn btn-primary mt-4" href="<?php echo $url_trailer ?>" target="_blank">Trailer</a>
                                <a class="d-block btn btn-outline-primary mt-4" href="<?php $url_imdb ?>" target="_blank">IMDb</a>
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