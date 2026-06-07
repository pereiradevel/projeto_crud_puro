<?php
require_once '../verifica.php';
require '../conexao.php';

$mensagem = '';
$tipo_mensagem = '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($id) && isset($_POST['id'])) {
    $id = $_POST['id'];
}

if (empty($id)) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (!empty($usuario) && !empty($email) && !empty($senha)) {
        $stmt = $pdo->prepare("UPDATE usuarios SET usuario = :usuario, email = :email, senha = :senha WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':usuario', $usuario);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha);

        if ($stmt->execute()) {
            $mensagem = "Usuário atualizado com sucesso!";
            $tipo_mensagem = "sucesso";
        } else {
            $mensagem = "Erro ao atualizar o usuário.";
            $tipo_mensagem = "erro";
        }
    } else {
        $mensagem = "Preencha todos os campos.";
        $tipo_mensagem = "erro";
    }
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$dados_usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dados_usuario) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário - SADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-slate-100 font-sans min-h-screen text-slate-800 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">

    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl border border-slate-200">
        
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                <i class='bx bx-edit-alt text-3xl'></i>
            </div>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Editar Usuário</h2>
            <p class="text-sm text-slate-500 mt-2">Modifique os dados do usuário abaixo.</p>
        </div>

        <?php if (!empty($mensagem)): ?>
            <div class="p-4 rounded-xl text-sm font-medium flex items-center gap-2 <?php echo $tipo_mensagem === 'sucesso' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200'; ?>">
                <i class='bx <?php echo $tipo_mensagem === 'sucesso' ? 'bx-check-circle text-xl' : 'bx-error-circle text-xl'; ?>'></i>
                <span><?php echo $mensagem; ?></span>
            </div>
        <?php endif; ?>

        <form class="mt-6 space-y-5" action="edit.php" method="POST">
            
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <div>
                <label for="usuario" class="block text-sm font-semibold text-slate-700 mb-1.5">Nome de Usuário</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class='bx bx-user text-xl'></i>
                    </span>
                    <input id="usuario" name="usuario" type="text" required class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all" value="<?php echo htmlspecialchars($dados_usuario['usuario']); ?>">
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">E-mail</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class='bx bx-envelope text-xl'></i>
                    </span>
                    <input id="email" name="email" type="email" required class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all" value="<?php echo htmlspecialchars($dados_usuario['email']); ?>">
                </div>
            </div>

            <div>
                <label for="senha" class="block text-sm font-semibold text-slate-700 mb-1.5">Senha</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class='bx bx-lock-alt text-xl'></i>
                    </span>
                    <input id="senha" name="senha" type="text" required class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all" value="<?php echo htmlspecialchars($dados_usuario['senha']); ?>">
                </div>
            </div>

            <div class="pt-2 flex flex-col gap-3">
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl shadow-md shadow-blue-100 transition-all transform active:scale-[0.98]">
                    <i class='bx bx-save text-xl'></i>
                    <span>Atualizar Dados</span>
                </button>
                
                <a href="index.php" class="w-full inline-flex items-center justify-center gap-1.5 text-sm font-semibold text-slate-400 hover:text-slate-600 py-2 transition-colors">
                    <i class='bx bx-arrow-back'></i> Cancelar e Voltar
                </a>
            </div>

        </form>
    </div>

</body>
</html>