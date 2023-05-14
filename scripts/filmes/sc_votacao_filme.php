<?php
session_start();
//var_dump($_POST);

if (isset($_POST["votacao"]) && ($_POST["votacao"] != "") && isset($_GET['id'])) {

    $votacao = $_POST["votacao"];
    $id_user = $_SESSION['id'];
    $id_filme = $_GET['id'];

    // We need the function!
    require_once("../../connections/connection.php");

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "INSERT INTO filmes_votacao (ref_utilizadores, ref_filmes, votacao) VALUES (?,?,?)";

    if (mysqli_stmt_prepare($stmt, $query)) {
        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "iii", $id_user, $id_filme, $votacao);
        /* execute the prepared statement */
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error:" . mysqli_stmt_error($stmt);
        } else {
            /* Insert done */
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
