<?php
include("./config.php");

if (isset($_POST['deletedata'])) {
    // pegue o id da string de consulta
    $id = $_POST['delete_id'];

    // consulta hapus
    $sql = "DELETE FROM petshop WHERE id = '$id'";
    $query = mysqli_query($db, $sql);

    // a consulta foi excluída com sucesso?
    if ($query) {
        header('Location: ./index.php?hapus=sukses');
    } else
        die('Location: ./index.php?hapus=gagal');
} else
    die("o acesso é proibido...");
