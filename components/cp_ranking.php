<?php
// conexão à base de dados
include_once "connections/connection.php";
?>

<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-3">
        <!-- Intro -->
        <div class="row">
            <div class="col-2">
                <a class="btn btn-info my-3" href="index.php">Voltar</a>
            </div>
            <h1>TOP 3</h1>

            <div class="col-8">
                <p class="text-black-60 text-left pb-4">A lista dos melhores filmes segundo os nossos utilizadores.</p>
            </div>
            <!-- Listar filmes -->
            <div class="row">
                <?php
                // Create a new DB connection
                $link = new_db_connection();

                // Create a prepared statement
                $stmt = mysqli_stmt_init($link);

                // Define the query
                $query = "SELECT id_filmes, titulo, capa , tipo, AVG(votacao) 
                    FROM filmes 
                    INNER JOIN generos 
                    ON generos.id_generos = filmes.ref_generos 
                    INNER JOIN filmes_votacao
                    ON filmes_votacao.ref_filmes = filmes.id_filmes
                    GROUP BY id_filmes
                    ORDER BY AVG(votacao) DESC LIMIT 3 ";

                // Prepare the statement
                if (mysqli_stmt_prepare($stmt, $query)) {

                    // Execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $id, $titulo, $capa, $genero, $votacao);

                        // Fetch values
                        while (mysqli_stmt_fetch($stmt)) {
                ?>
                            <div class="col-md-4 mb-md-0 pb-5">
                                <div class="card pb-2 h-100 shadow rounded">
                                    <div class="capas-preview" style="background-image: url(<?php echo "imgs/capas/" . $capa; ?>)"></div>
                                    <div class="card-body text-center">
                                        <h4 class="text-uppercase m-0 mt-2"><?php echo "<h2>$titulo</h2>"; ?></h4>
                                        <hr class="my-3 mx-auto" />
                                        <div class="tipo-filme mb-0 small text-black-50"><?php echo "<p>$genero</p>"; ?></div>
                                        <div class="tipo-filme mb-0 small text-black-50">Votação:<?php echo "<p>$votacao</p>"; ?></div>
                                        <a href="filme_detail.php?id=<?php echo $id; ?>" class="mt-2 btn btn-outline-primary"><b><i class="fas fa-plus text-primary"></i></b></a>
                                    </div>
                                </div>
                            </div>
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
                ?>
            </div>
        </div>
</section>