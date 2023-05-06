<?php
require_once "../../connections/connection.php";
var_dump($_GET);
if (isset($_GET['id'])) {
    $id_generos = $_GET['id'];

    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);

    $query = "DELETE FROM generos WHERE id_generos = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "i", $id_generos);
        /* execute the prepared statement */
        if (!mysqli_stmt_execute($stmt)) {
            /* Como prevenir? */
            echo "Error:" . mysqli_stmt_error($stmt);
        } else {
            /* Cidade apagada */
            header("Location: ../../generos.php");
        }
    } else {
        echo ("Error description: " . mysqli_error($link));
    }
    /* close statement */
    mysqli_stmt_close($stmt);
    /* close connection */
    mysqli_close($link);
}


header("Location: ../../generos.php");
