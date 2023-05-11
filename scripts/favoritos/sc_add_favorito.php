<?php
session_start();

if (isset($_GET['id']) && isset($_SESSION['id'])) {
    $id_filme = $_GET['id'];
    $user = $_SESSION['id'];

    // We need the function!
    require_once("../../connections/connection.php");

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "INSERT INTO filmes_favoritos (ref_utilizadores, ref_filmes) VALUES (?,?)";

    if (mysqli_stmt_prepare($stmt, $query)) {

        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "ii", $user, $id_filme);
        /* execute the prepared statement */
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error:" . mysqli_stmt_error($stmt);
        } else {
            /* Insert done */
            header("Location: ../../filmes.php");
        }
    } else {
        echo ("Error description: " . mysqli_error($link));
    }
    /* close statement */
    mysqli_stmt_close($stmt);
    /* close connection */
    mysqli_close($link);
}
