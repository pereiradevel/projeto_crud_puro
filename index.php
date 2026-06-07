<?php
session_start();
require_once 'conexao.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['usuario'])) {
    header('Location: dashboard.php');
    exit;
}

$erroLogin = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha LIMIT 1");
    $stmt->bindValue(':usuario', $user);
    $stmt->bindValue(':senha', $senha);
    $stmt->execute();
    $encontrado = $stmt->fetch();

    if ($encontrado) {
        $_SESSION['usuario'] = $encontrado['usuario'];
        $_SESSION['user_id'] = $encontrado['id'];
        header('Location: dashboard.php');
        exit;
    }

    $erroLogin = 'Usuário ou senha inválidos.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen font-sans">

    <?php if ($erroLogin): ?>
        <div class='fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-md text-sm z-50'>
            <?php echo htmlspecialchars($erroLogin); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md mx-4 transform transition-all duration-300 hover:shadow-2xl">
        
        <div class="text-center mb-8">
            <div class="bg-blue-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-200">
                <i class='bx bx-shield-quarter text-white text-3xl'></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Login - SADE</h1>
            <p class="text-sm text-slate-400 mt-1">Insira suas credenciais para acessar o sistema</p>
        </div>

        <form action="" method="POST" class="space-y-5">
            
            <div>
                <label for="usuario" class="block text-sm font-semibold text-slate-700 mb-1.5">Usuário</label>
                <div class="relative flex items-center">
                    <i class='bx bx-user text-xl text-slate-400 absolute left-4'></i>
                    <input type="text" name="usuario" id="usuario" placeholder="Digite seu usuário" required
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none transition-all focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 placeholder:text-slate-400">
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label for="senha" class="block text-sm font-semibold text-slate-700">Senha</label>
                    <a href="#" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition">Esqueceu a senha?</a>
                </div>
                <div class="relative flex items-center">
                    <i class='bx bx-lock-alt text-xl text-slate-400 absolute left-4'></i>
                    <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none transition-all focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 placeholder:text-slate-400">
                </div>
            </div>
            <a href="register.php" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition">Não possui uma conta?</a>
            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg shadow-blue-200 hover:shadow-none transition-all duration-200 transform active:scale-[0.98] mt-2 flex items-center justify-center gap-2">
                <span>Entrar no Sistema</span>
                <i class='bx bx-right-arrow-alt text-xl'></i>
            </button>
            
        </form>
    </div>

</body>
</html>