<?php
require_once "./connections/connection.php";
?>

<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-3">

        <!-- Intro -->
        <?php include_once "./components/cp_intro_update.php" ?>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        //QUERY PARA IR BUSCAR O VALOR
        $query = "SELECT generos.tipo FROM generos WHERE generos.id_generos=?";

        //LIGA À BD
        $local_link = new_db_connection();

        //INICIA O STATEMENT
        $stmt = mysqli_stmt_init($local_link);

        //PREPARA A STATEMENT
        mysqli_stmt_prepare($stmt, $query);

        //BIND DOS PARÂMETROS
        mysqli_stmt_bind_param($stmt, 'i', $genero);

        //Executa o statement
        mysqli_stmt_execute($stmt);

        //VERIFICA SE EXISTEM RESULTADOS e guarda na variável
        mysqli_stmt_bind_result($stmt, $genero);

        //VAI BUSCAR OS DADOS
        mysqli_stmt_fetch($stmt);

        //var_dump($genero);
        ?>

        <div class="row">
            <form class="col-6" action="./scripts/generos/sc_update_genero.php?id=<?php echo $id; ?>" method="post" class="was-validated">
                <div class="mb-3 mt-3">
                    <label for="uname" class="form-label">Género:</label>
                    <input type="text" class="form-control" name="genero" value="<?= $genero ?>" placeholder="<?php echo $genero ?>" required>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <button type="submit" class="btn btn-primary">Editar</button>
            </form>
        </div>
    </div>

</section>