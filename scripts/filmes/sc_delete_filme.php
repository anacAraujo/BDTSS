<?php
require_once "../../connections/connection.php";
var_dump($_GET);
if (isset($_GET['id'])) {
    $id_filme = $_GET['id'];

    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);

    $query = "DELETE FROM filmes WHERE id_filmes = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {

        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "i", $id_filme);
        /* execute the prepared statement */
        if (!mysqli_stmt_execute($stmt)) {
            /* Como prevenir? */
            echo "Error:" . mysqli_stmt_error($stmt);
        } else {
            /* Filme apagado */
            header("Location: ../../filmes.php");
        }
    } else {
        echo ("Error description: " . mysqli_error($link));
    }
    /* close statement */
    mysqli_stmt_close($stmt);
}
/* close connection */
mysqli_close($link);
