<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SADE</title>
    <script src="https://tailwindcss.com"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>
<body>
    <div class="container">
        <h1> Login - SADE</h1>
        <form action="" method="POST">
            <input type="text" name="usuario" id="usuario" placeholder="Usuário">
            <input type="password" name="senha" id="senha" placeholder="Senha">
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['usuario'];
    $senha = $_POST['senha'];
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha LIMIT 1");
    $stmt->bindValue(':usuario', $user);
    $stmt->bindValue(':senha', $senha);
    $stmt->execute();
    $encontrado = $stmt->fetch();

    if ($encontrado) {
        header("Location: dashboard.php");
        exit; 
    } else {
        echo "Usuário ou senha inválidos.";
    }
}
?>