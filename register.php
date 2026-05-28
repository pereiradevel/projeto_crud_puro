<?php
require_once 'conexao.php';

$mensagem = "";

// Verifica se o formulário de registro foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Insere os dados diretamente na tabela oficial de usuários
    $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, email, senha) VALUES (:usuario, :email, :senha)");
    $stmt->bindValue(":usuario", $user);
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":senha", $senha);
    
    if ($stmt->execute()) {
        // Alerta visual de sucesso e redireciona imediatamente para o login index.php
        echo "<script>alert('Conta criada com sucesso!'); window.location.href='index.php';</script>";
        exit;
    } else {
        $mensagem = "<div class='fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-md text-sm z-50'>Erro ao cadastrar no banco de dados.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta SADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen font-sans">

    <?php echo $mensagem; ?>

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md mx-4">
        
        <div class="text-center mb-8">
            <div class="bg-emerald-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class='bx bx-user-plus text-white text-3xl'></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Criar Conta - SADE</h1>
            <p class="text-sm text-slate-400 mt-1">Preencha os dados para se cadastrar</p>
        </div>

        <form action="" method="POST" class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Usuário</label>
                <div class="relative flex items-center">
                    <i class='bx bx-user text-xl text-slate-400 absolute left-4'></i>
                    <input type="text" name="usuario" placeholder="Escolha um usuário" required
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-emerald-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">E-mail</label>
                <div class="relative flex items-center">
                    <i class='bx bx-envelope text-xl text-slate-400 absolute left-4'></i>
                    <input type="email" name="email" placeholder="seu@email.com" required
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-emerald-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Senha</label>
                <div class="relative flex items-center">
                    <i class='bx bx-lock-alt text-xl text-slate-400 absolute left-4'></i>
                    <input type="password" name="senha" placeholder="Crie uma senha" required
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-emerald-500">
                </div>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
                <span>Cadastrar</span>
                <i class='bx bx-check text-xl'></i>
            </button>
            
            <div class="text-center mt-4">
                <a href="index.php" class="text-xs font-semibold text-slate-400 hover:text-slate-600">Já tem conta? Voltar para o Login</a>
            </div>
        </form>
    </div>
</body>
</html>