<?php
session_start();
var_dump($_GET);
var_dump($_POST);
if (isset($_POST["titulo"]) && isset($_POST["sinopse"]) && isset($_POST["ano"]) && isset($_POST["genero"]) && isset($_POST["url_imdb"]) && isset($_POST["url_trailer"]) && (isset($_GET["id"]))) {
    $imdb = "";
    if ($_POST["url_imdb"] == "") {
        $imdb = null;
    } else {
        $imdb = $_POST["url_imdb"];
    }

    $trailer = "";
    if ($_POST["url_trailer"] == "") {
        $trailer = null;
    } else {
        $trailer = $_POST["url_trailer"];
    }

    $titulo = $_POST["titulo"];
    $sinopse = $_POST["sinopse"];
    $capa = "default.png";
    $ano = $_POST["ano"];
    $genero = $_POST["genero"];
    $url_imdb = $imdb;
    $url_trailer = $trailer;
    $id_user = $_SESSION['id'];
    $id_filme = ($_GET["id"]);

    // We need the function!
    require_once("../../connections/connection.php");

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "UPDATE filmes
              SET titulo = ?, ano = ?, sinopse = ?, capa = ?, url_imdb = ?, url_trailer = ?, ref_generos = ?, ref_utilizadores = ?
              WHERE id_filmes = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "sissssiii", $titulo, $ano, $sinopse, $capa, $url_imdb, $url_trailer, $genero, $id_user, $id_filme);
        /* execute the prepared statement */
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error:" . mysqli_stmt_error($stmt);
        } else {
            /* Update done */
            header("Location: ../../filmes.php");
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
