<?php
// conexão à base de dados
include_once "connections/connection.php";
?>

<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-3">
        <!-- Intro -->
        <?php include_once "./components/add_filme/cp_intro_add_filme.php"; ?>

        <!-- Formulário -->
        <div class="row">
            <?php
            $link = new_db_connection();
            $stmt = mysqli_stmt_init($link);

            $query = "SELECT id_generos, tipo 
                        FROM generos";
            ?>
            <form class="col-6" action="./scripts/filmes/sc_add_filme.php" method="post" class="was-validated">
                <div class="mb-3 mt-3"><label for="uname" class="form-label">Título:*</label><input type="text" class="form-control" id="titulo" value="" name="titulo" required>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="mb-3 mt-3"><label for="uname" class="form-label">Sinopse:*</label><textarea class="form-control" id="sinopse" value="" name="sinopse" rows="5" required></textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="mb-3 mt-3"><label for="uname" class="form-label">Ano:*</label><input type="number" class="form-control" id="ano" value="" name="ano" min="1900" max="2099" step="1" value="2023" required>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="mb-3 mt-3"><label for="uname" class="form-label">Género:</label><select class="form-select" id="genero" name="genero" required>
                        <option value=''> Escolha uma opção </option>
                        <?php
                        if (mysqli_stmt_prepare($stmt, $query)) {
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $id_generos, $tipo);
                            while (mysqli_stmt_fetch($stmt)) {
                                echo "<option value='$id_generos'> $tipo </option>";
                            }
                            mysqli_stmt_close($stmt);
                        } else {
                            echo mysqli_error($link);
                        }
                        mysqli_close($link);
                        ?>
                    </select>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="mb-3 mt-3"><label for="uname" class="form-label">URL IMDB:</label><input type="url" class="form-control" id="url_imdb" value="" name="url_imdb">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="mb-3 mt-3"><label for="uname" class="form-label">URL Trailer:</label><input type="url" class="form-control" id="url_trailer" value="" name="url_trailer">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <a class="btn btn-info my-3" href="index.php">Cancelar</a>
                <button type="submit" class="btn btn-primary">Inserir</button>
            </form>
        </div>
    </div>
</section>