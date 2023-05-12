<?php
session_start();
var_dump($_GET['id']);
var_dump($_POST['comentario']);
if (isset($_POST['comentario']) && isset($_GET['id']) && isset($_SESSION['id'])) {
    $comentario = $_POST['comentario'];
    $id_filme = $_GET['id'];
    $user = $_SESSION['id'];

    // We need the function!
    require_once("../../connections/connection.php");

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "INSERT INTO comentarios (comentario, ref_filmes, ref_utilizadores) VALUES (?,?,?)";

    if (mysqli_stmt_prepare($stmt, $query)) {
        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "sii", $comentario, $id_filme, $user);
        /* execute the prepared statement */
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error:" . mysqli_stmt_error($stmt);
        } else {
            /* Insert done */
            header("Location: ../../filme_detail.php?id=$id_filme");
        }
    } else {
        echo ("Error description: " . mysqli_error($link));
    }
    /* close statement */
    mysqli_stmt_close($stmt);
    /* close connection */
    mysqli_close($link);
}
