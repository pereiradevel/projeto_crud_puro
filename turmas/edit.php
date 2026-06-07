<?php
require_once '../verifica.php';
require '../conexao.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM turmas WHERE id = :id");
$stmt->execute([':id' => $id]);
$turma = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE turmas SET codigo_turma = :codigo_turma, nome_turma = :nome_turma, turno = :turno WHERE id = :id");
    $stmt->execute([
        ':codigo_turma' => $_POST['codigo_turma'],
        ':nome_turma'   => $_POST['nome_turma'],
        ':turno'        => $_POST['turno'],
        ':id'           => $id
    ]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Turma - SADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 p-10">

    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl p-8">
        <h1 class="text-2xl font-bold mb-6 text-slate-900">Editar Turma</h1>
        
        <form action="edit.php?id=<?php echo $id; ?>" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-semibold mb-2">Código da Turma</label>
                <input type="text" name="codigo_turma" value="<?php echo $turma['codigo_turma']; ?>" class="w-full px-4 py-2 rounded-xl border font-mono">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Nome da Turma</label>
                <input type="text" name="nome_turma" value="<?php echo $turma['nome_turma']; ?>" class="w-full px-4 py-2 rounded-xl border">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Turno</label>
                <select name="turno" class="w-full px-4 py-2 rounded-xl border bg-white">
                    <option value="Manhã" <?php echo $turma['turno'] === 'Manhã' ? 'selected' : ''; ?>>Manhã</option>
                    <option value="Tarde" <?php echo $turma['turno'] === 'Tarde' ? 'selected' : ''; ?>>Tarde</option>
                    <option value="Noite" <?php echo $turma['turno'] === 'Noite' ? 'selected' : ''; ?>>Noite</option>
                    <option value="Integral" <?php echo $turma['turno'] === 'Integral' ? 'selected' : ''; ?>>Integral</option>
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="index.php" class="px-5 py-2 rounded-xl border text-sm">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-xl text-sm font-semibold">Atualizar</button>
            </div>
        </form>
    </div>

</body>
</html>