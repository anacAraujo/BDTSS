<?php
session_start();
//var_dump($_POST);

if (isset($_POST["titulo"]) && ($_POST["titulo"] != "") && isset($_POST["sinopse"]) && ($_POST["sinopse"] != "") && isset($_POST["ano"]) && ($_POST["ano"] != "") && isset($_POST["genero"]) && ($_POST["genero"] != "") && isset($_POST["url_imdb"]) && isset($_POST["url_trailer"])) {
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

    //var_dump($capa);

    // We need the function!
    require_once("../../connections/connection.php");

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "INSERT INTO filmes (titulo, sinopse, capa, ano, ref_generos, url_imdb, url_trailer, ref_utilizadores) VALUES (?,?,?,?,?,?,?,?)";

    if (mysqli_stmt_prepare($stmt, $query)) {
        /* Bind paramenters */
        mysqli_stmt_bind_param($stmt, "sssiissi", $titulo, $sinopse, $capa, $ano, $genero, $url_imdb, $url_trailer, $id_user);
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
