<?php
require '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO turmas (codigo_turma, nome_turma, turno) VALUES (:codigo_turma, :nome_turma, :turno)");
    $stmt->execute([
        ':codigo_turma' => $_POST['codigo_turma'],
        ':nome_turma'   => $_POST['nome_turma'],
        ':turno'        => $_POST['turno']
    ]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Turma - SADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 p-10">

    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl p-8">
        <h1 class="text-2xl font-bold mb-6 text-slate-900">Nova Turma</h1>
        
        <form action="create.php" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-semibold mb-2">Código da Turma</label>
                <input type="text" name="codigo_turma" class="w-full px-4 py-2 rounded-xl border font-mono">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Nome da Turma</label>
                <input type="text" name="nome_turma" class="w-full px-4 py-2 rounded-xl border">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Turno</label>
                <select name="turno" class="w-full px-4 py-2 rounded-xl border bg-white">
                    <option value="Manhã">Manhã</option>
                    <option value="Tarde">Tarde</option>
                    <option value="Noite">Noite</option>
                    <option value="Integral">Integral</option>
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="index.php" class="px-5 py-2 rounded-xl border text-sm">Cancelar</a>
                <button type="submit" class="bg-emerald-600 text-white px-5 py-2 rounded-xl text-sm font-semibold">Salvar</button>
            </div>
        </form>
    </div>

</body>
</html>