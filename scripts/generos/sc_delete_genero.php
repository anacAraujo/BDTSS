<?php
require_once "../../connections/connection.php";

if (isset($_GET['id'])) {
    $id_generos = $_GET['id'];

    $link = new_db_connection();

    $stmt2 = mysqli_stmt_init($link);
    $query2 = "SELECT id_filmes FROM filmes WHERE ref_generos = ?";

    if (mysqli_stmt_prepare($stmt2, $query2)) {

        mysqli_stmt_bind_param($stmt2, 'i', $id_generos);

        if (mysqli_stmt_execute($stmt2)) {
            mysqli_stmt_bind_result($stmt2, $id);

            mysqli_stmt_store_result($stmt2);

            if (mysqli_stmt_num_rows($stmt2) > 0) {
                header("Location: ../../generos.php?error=erro2");
                mysqli_stmt_close($stmt2);
            } else {
                mysqli_stmt_close($stmt2);
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
            }
            /* close connection */
            mysqli_close($link);
        }
    }
}
