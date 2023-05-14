<?php
session_start();

if (isset($_POST["username"]) && ($_POST["username"] != "") && (isset($_SESSION["id"]))) {
    $username = $_POST["username"];
    $id = $_SESSION["id"];
    $_SESSION['login'] = $_POST["username"];

    // We need the function!
    require_once("../connections/connection.php");

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "UPDATE utilizadores
              SET login = ?, nome = ?
              WHERE id_utilizadores = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "ssi", $username, $username, $id);
        /* execute the prepared statement */
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error:" . mysqli_stmt_error($stmt);
        } else {
            /* Update done */
            header("Location: ../index.php");
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
