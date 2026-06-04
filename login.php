<?php
session_start();
require_once 'db.php';

// Se já estiver logado, redireciona diretamente para o Dashboard
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$erro = '';

// Processamento de Login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $erro = 'Por favor, informe seu e-mail e sua senha.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $usuario = $stmt->fetch();

            // Verifica se o usuário existe e valida a senha criptografada
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];
                
                header("Location: index.php");
                exit;
            } else {
                $erro = 'E-mail ou senha incorretos.';
            }
        } catch (PDOException $e) {
            $erro = 'Erro interno do servidor: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Escolar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
        
        <div class="p-8 bg-gradient-to-r from-blue-600 to-indigo-700 text-center text-white">
            <h1 class="text-2xl font-bold">Painel de Acesso</h1>
            <p class="text-blue-100 mt-2 text-sm">Entre com suas credenciais</p>
        </div>

        <div class="p-8">
            <!-- Alerta de Erro -->
            <?php if (!empty($erro)): ?>
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg text-sm">
                    <strong>Erro:</strong> <?= htmlspecialchars($erro) ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1" for="email">E-mail</label>
                    <input type="email" id="email" name="email" required 
                           class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                           placeholder="exemplo@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="text-sm font-semibold text-slate-700" for="senha">Senha</label>
                    </div>
                    <input type="password" id="senha" name="senha" required 
                           class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                           placeholder="Insira sua senha secreta">
                </div>

                <button type="submit" 
                        class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-200">
                    Entrar
                </button>
            </form>

            <div class="mt-8 text-center border-t border-slate-100 pt-6">
                <p class="text-sm text-slate-600">
                    Não tem uma conta cadastrada? 
                    <a href="register.php" class="text-blue-600 hover:underline font-semibold ml-1">Criar nova conta</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>