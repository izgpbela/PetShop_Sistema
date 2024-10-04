<?php
include("./config.php");

// Checa se o botão de edição foi clicado
if (isset($_POST['edit_data'])) {
    // Pega os dados do formulário
    $id = $_POST['edit_id'];
    $nome = $_POST['edit_nome'];
    $telefone = $_POST['edit_telefone'];
    $endereco = $_POST['edit_endereco'];

    // Query para atualizar os dados do proprietário
    $sql = "UPDATE proprietarios SET nome='$nome', telefone='$telefone', endereco='$endereco' WHERE id = '$id'";
    $query = mysqli_query($db, $sql);

    // Verifica se a query foi executada com sucesso
    if ($query) {
        header('Location: ./index.php?update=sukses');
    } else {
        header('Location: ./index.php?update=gagal');
    }
} else {
    die("Acesso negado...");
}
?>
