<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro SADE</title>
    <script src="https://tailwindcss.com"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>
<body>
    <div class="container">
        <h1> Registro - SADE</h1>
        <form action="" method="POST">
            <input type="text" name="usuario" id="usuario" placeholder="Usuário">
            <input type="text" name="email" id="email" placeholder="E-mail">
            <input type="password" name="senha" id="senha" placeholder="Senha">
            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>

<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST');
    $user = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $stmt = $pdo->prepare("INSERT INTO usuarios (usuario , email , senha) VALUES (:usuario , :email , :senha)");

    $stmt->bindValue(":usuario" , $user);
    $stmt->bindValue(":email" , $email);
    $stmt->bindValue(":senha" , $senha);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    }
    else {
        echo 'Erro na criação da conta!';
    }
?>