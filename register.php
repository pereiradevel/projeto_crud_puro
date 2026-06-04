<?php
session_start();
require_once 'db.php';

// Se já estiver logado, redireciona diretamente para o Dashboard
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$erro = '';
$sucesso = '';

// Processamento do Formulário de Registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Formato de e-mail inválido.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve conter no mínimo 6 caracteres.';
    } elseif ($senha !== $confirmar_senha) {
        $erro = 'As senhas informadas não coincidem.';
    } else {
        try {
            // Verifica se o e-mail já existe
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $erro = 'Este e-mail já está cadastrado em nossa base.';
            } else {
                // Criptografa a senha de maneira altamente segura
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                
                // Insere o novo usuário
                $stmt_insert = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
                $stmt_insert->execute([$nome, $email, $senha_hash]);
                
                $sucesso = 'Cadastro realizado com sucesso! Redirecionando para o login...';
                // Define um redirecionamento automático simples via cabeçalho HTTP de recarregamento
                header("refresh:2;url=login.php");
            }
        } catch (PDOException $e) {
            $erro = 'Erro ao processar o cadastro: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Sistema Escolar</title>
    <!-- Utilização do Tailwind CSS via CDN para estilização visual premium -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
        
        <div class="p-8 bg-gradient-to-r from-blue-600 to-indigo-700 text-center text-white">
            <h1 class="text-2xl font-bold">Criar Nova Conta</h1>
            <p class="text-blue-100 mt-2 text-sm">Registre-se no sistema</p>
        </div>

        <div class="p-8">
            <!-- Alertas de Sucesso ou Erro -->
            <?php if (!empty($erro)): ?>
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg text-sm">
                    <strong>Atenção:</strong> <?= htmlspecialchars($erro) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($sucesso)): ?>
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-lg text-sm">
                    <strong>Sucesso:</strong> <?= htmlspecialchars($sucesso) ?>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1" for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" required 
                           class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                           placeholder="Ex: João da Silva" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1" for="email">Endereço de E-mail</label>
                    <input type="email" id="email" name="email" required 
                           class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                           placeholder="exemplo@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1" for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required 
                           class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                           placeholder="No mínimo 6 caracteres">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1" for="confirmar_senha">Confirmar Senha</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" required 
                           class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                           placeholder="Confirme a sua senha">
                </div>

                <button type="submit" 
                        class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-200">
                    Cadastrar e Entrar
                </button>
            </form>

            <div class="mt-8 text-center border-t border-slate-100 pt-6">
                <p class="text-sm text-slate-600">
                    Já possui uma conta? 
                    <a href="login.php" class="text-blue-600 hover:underline font-semibold ml-1">Fazer Login</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>