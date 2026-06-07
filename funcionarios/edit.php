<?php
require '../conexao.php';

$mensagem = '';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM funcionarios WHERE id = :id");
$stmt->execute([':id' => $id]);
$funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$funcionario) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_id = trim($_POST['id']);
    $nome = trim($_POST['nome']);
    $cargo = trim($_POST['cargo']);

    if (!empty($novo_id) && !empty($nome) && !empty($cargo)) {
        try {
            $stmt = $pdo->prepare("UPDATE funcionarios SET id = :novo_id, nome = :nome, cargo = :cargo WHERE id = :id_antigo");
            $stmt->execute([
                ':novo_id' => $novo_id,
                ':nome' => $nome,
                ':cargo' => $cargo,
                ':id_antigo' => $id
            ]);

            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            $mensagem = "Erro ao atualizar: " . $e->getMessage();
        }
    } else {
        $mensagem = "Por favor, preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionário - SADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-slate-100 font-sans min-h-screen text-slate-800">

    <div class="max-w-2xl mx-auto px-4 py-10">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <i class='bx bx-edit-alt text-amber-600'></i> Editar Funcionário
            </h1>
            <p class="text-sm text-slate-500 mt-1">Modifique as informações do funcionário abaixo.</p>
        </div>

        <?php if (!empty($mensagem)): ?>
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm flex items-center gap-2 shadow-sm">
                <i class='bx bx-error-circle text-xl'></i>
                <span><?php echo htmlspecialchars($mensagem); ?></span>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden p-6 sm:p-8">
            <form action="edit.php?id=<?php echo htmlspecialchars($id); ?>" method="POST" class="space-y-6">
                
                <div>
                    <label for="id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Identificação / ID</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i class='bx bx-hash text-xl'></i>
                        </span>
                        <input type="text" id="id" name="id" required 
                            value="<?php echo htmlspecialchars($funcionario['id']); ?>"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-mono focus:outline-none focus:border-amber-500 focus:bg-white transition-all text-sm text-slate-900">
                    </div>
                </div>

                <div>
                    <label for="nome" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nome Completo</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i class='bx bx-user text-xl'></i>
                        </span>
                        <input type="text" id="nome" name="nome" required 
                            value="<?php echo htmlspecialchars($funcionario['nome']); ?>"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-amber-500 focus:bg-white transition-all text-sm text-slate-900">
                    </div>
                </div>

                <div>
                    <label for="cargo" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cargo / Função</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i class='bx bx-briefcase text-xl'></i>
                        </span>
                        <input type="text" id="cargo" name="cargo" required 
                            value="<?php echo htmlspecialchars($funcionario['cargo']); ?>"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-amber-500 focus:bg-white transition-all text-sm text-slate-900">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="index.php" class="w-full sm:w-auto text-center px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition-colors text-sm">
                        Cancelar
                    </a>
                    <button type="submit" class="w-full sm:w-auto bg-amber-600 hover:bg-amber-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-md shadow-amber-100 transition-all text-sm flex items-center justify-center gap-2">
                        <i class='bx bx-save text-xl'></i> Salvar Alterações
                    </button>
                </div>

            </form>
        </div>

        <div class="mt-6">
            <a href="index.php" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-400 hover:text-slate-600 transition-colors">
                <i class='bx bx-arrow-back'></i> Voltar para a lista
            </a>
        </div>
        
    </div>

</body>
</html>