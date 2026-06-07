<?php
require_once '../verifica.php';
require '../conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Erro ao excluir o usuário.";
    }
} else {
    echo "ID do usuário não fornecido.";
}