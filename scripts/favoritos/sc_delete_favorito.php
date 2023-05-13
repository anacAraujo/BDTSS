<?php
session_start();
require_once "../../connections/connection.php";

if (isset($_GET['id']) && isset($_SESSION['id'])) {
    $id_filme = $_GET['id'];
    $user = $_SESSION['id'];

    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);

    $query = "DELETE FROM filmes_favoritos WHERE ref_utilizadores = ? AND ref_filmes = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "ii", $user, $id_filme);
        /* execute the prepared statement */
        if (!mysqli_stmt_execute($stmt)) {
            /* Como prevenir? */
            echo "Error:" . mysqli_stmt_error($stmt);
        } else {
            /* Favorito apagado */
            header("Location: ../../filme_detail.php?id=$id_filme.php");
        }
    } else {
        echo ("Error description: " . mysqli_error($link));
    }
    /* close statement */
    mysqli_stmt_close($stmt);
    /* close connection */
    mysqli_close($link);
}


// header("Location: ../../filme_detail.php.php");
