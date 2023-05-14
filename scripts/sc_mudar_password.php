<?php
session_start();

if (isset($_POST["password_atual"]) && ($_POST["password_atual"] != "") && isset($_POST["password_nova"]) && ($_POST["password_nova"] != "") && (isset($_SESSION["id"]))) {
    $password_atual = $_POST["password_atual"];
    $password_nova = password_hash($_POST["password_nova"], PASSWORD_DEFAULT);
    $id = $_SESSION["id"];

    // We need the function!
    require_once("../connections/connection.php");

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "SELECT password_hash 
                FROM utilizadores
                WHERE id_utilizadores LIKE ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_bind_result($stmt, $password_hash);

            if (mysqli_stmt_fetch($stmt)) {
                if (password_verify($password_atual, $password_hash)) {
                    //Alterar password
                    var_dump(password_verify($password_atual, $password_hash));
                    /* close statement */
                    mysqli_stmt_close($stmt);
                    /* create a prepared statement */
                    $stmt2 = mysqli_stmt_init($link);

                    $query2 = "UPDATE utilizadores
                                SET password_hash = ?
                                WHERE id_utilizadores = ?";

                    if (mysqli_stmt_prepare($stmt2, $query2)) {
                        /* Bind paramenters */
                        mysqli_stmt_bind_param($stmt2, "si", $password_nova, $id);

                        /* execute the prepared statement */
                        if (!mysqli_stmt_execute($stmt2)) {
                            echo "Error:" . mysqli_stmt_error($stmt2);
                        } else {
                            /* Update done */
                            header("Location: ../index.php");
                        }
                    } else {
                        echo ("Error description: " . mysqli_error($link));
                    }
                    /* close statement */
                    mysqli_stmt_close($stmt2);
                    // Feedback de sucesso
                    header("Location: ../index.php");
                } else {
?>
                    <div class="row">
                        <h4>Credenciais incorretas</h4>
                        <div class="col-8">
                            <a href="../logout.php"><button type="submit" class="btn btn-primary">Voltar a tantar</button></a>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="row">
                    <h4>Credenciais incorretas</h4>
                    <div class="col-8">
                        <a href="../logout.php"><button type="submit" class="btn btn-primary">Voltar a tantar</button></a>
                    </div>
                </div>
<?php
            }
        } else {
            // Acção de erro
            echo "Error:" . mysqli_stmt_error($stmt);
        }
    } else {
        echo ("Error description: " . mysqli_error($link));
    }
    /* close statement */
    mysqli_stmt_close($stmt);

    /* close connection */
    mysqli_close($link);
} else
    echo "erro no POST";
