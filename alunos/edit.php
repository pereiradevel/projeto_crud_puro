<?php
require_once '../verifica.php';
require '../conexao.php';

$mensagem = '';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM alunos WHERE id = :id");
$stmt->execute([':id' => $id]);
$aluno = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$aluno) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula = trim($_POST['matricula']);
    $nome_aluno = trim($_POST['nome_aluno']);
    $turma_id = trim($_POST['turma_id']);

    if (!empty($matricula) && !empty($nome_aluno) && !empty($turma_id)) {
        try {
            $stmt = $pdo->prepare("UPDATE alunos SET matricula = :matricula, nome_aluno = :nome_aluno, turma_id = :turma_id WHERE id = :id");
            $stmt->execute([
                ':matricula' => $matricula,
                ':nome_aluno' => $nome_aluno,
                ':turma_id' => $turma_id,
                ':id' => $id
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
    <title>Editar Aluno - SADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-slate-100 font-sans min-h-screen text-slate-800">

    <div class="max-w-2xl mx-auto px-4 py-10">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <i class='bx bx-edit-alt text-indigo-600'></i> Editar Aluno
            </h1>
            <p class="text-sm text-slate-500 mt-1">Modifique as informações do estudante abaixo.</p>
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
                    <label for="matricula" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Matrícula</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i class='bx bx-id-card text-xl'></i>
                        </span>
                        <input type="text" id="matricula" name="matricula" required 
                            value="<?php echo htmlspecialchars($aluno['matricula']); ?>"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-mono focus:outline-none focus:border-indigo-500 focus:bg-white transition-all text-sm text-slate-900">
                    </div>
                </div>

                <div>
                    <label for="nome_aluno" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nome Completo</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i class='bx bx-user text-xl'></i>
                        </span>
                        <input type="text" id="nome_aluno" name="nome_aluno" required 
                            value="<?php echo htmlspecialchars($aluno['nome_aluno']); ?>"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:bg-white transition-all text-sm text-slate-900">
                    </div>
                </div>

                <div>
                    <label for="turma_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">ID da Turma</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i class='bx bx-group text-xl'></i>
                        </span>
                        <input type="number" id="turma_id" name="turma_id" required 
                            value="<?php echo $turma['turma_id']; ?>"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:bg-white transition-all text-sm text-slate-900">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="index.php" class="w-full sm:w-auto text-center px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition-colors text-sm">
                        Cancelar
                    </a>
                    <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-md shadow-indigo-100 transition-all text-sm flex items-center justify-center gap-2">
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