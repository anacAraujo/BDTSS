<?php
session_start();
if (isset($_POST["nome_cidade"]) && ($_POST["nome_cidade"] != "") && (isset($_SESSION["id_cidades"]))) {
    $nome_cidade = $_POST["nome_cidade"];
    $id = $_SESSION["id_cidades"];
    unset($_SESSION['id_cidades']);

    // We need the function!
    require_once("connections/connection.php");

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "UPDATE cidades
              SET nome_cidade = ?
              WHERE id_cidades = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "si", $nome_cidade, $id);
        /* execute the prepared statement */
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error:" . mysqli_stmt_error($stmt);
        } else {
            /* Update done */
            header("Location: cidades_list.php");
        }
    } else {
        echo ("Error description: " . mysqli_error($link));
    }
    /* close statement */
    mysqli_stmt_close($stmt);
    /* close connection */
    mysqli_close($link);
}
