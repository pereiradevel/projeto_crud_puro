<?php
require_once '../verifica.php';
require '../conexao.php';

    $stmt = $pdo->query("SELECT * FROM usuarios");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Usuários - SADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-slate-100 font-sans min-h-screen text-slate-800">

    <div class="max-w-6xl mx-auto px-4 py-10">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <i class='bx bx-group text-emerald-600'></i> Controlar Usuários
                </h1>
                <p class="text-sm text-slate-500 mt-1">Visualize, edite ou remova os usuários cadastrados no sistema.</p>
            </div>
            
            <div>
                <a href="create.php" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md shadow-emerald-100 transition-all transform active:scale-95">
                    <i class='bx bx-user-plus text-xl'></i>
                    <span>Novo Usuário</span>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Usuário</th>
                            <th class="px-6 py-4">E-mail</th>
                            <th class="px-6 py-4">Senha (Texto)</th>
                            <th class="px-6 py-4 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        <?php foreach ($usuarios as $usuario): ?>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-mono font-semibold text-slate-400">#<?php echo $usuario['id']; ?></td>
                            <td class="px-6 py-4 font-semibold text-slate-900"><?php echo $usuario['usuario']; ?></td>
                            <td class="px-6 py-4 text-slate-500"><?php echo $usuario['email']; ?></td>
                            <td class="px-6 py-4 font-mono text-xs text-slate-400"><?php echo $usuario['senha']; ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="edit.php?id=<?php echo $usuario['id']; ?>" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Editar Usuário">
                                        <i class='bx bx-edit-alt text-xl'></i>
                                    </a>
                                    <a href="delete.php?id=<?php echo $usuario['id']; ?>" onclick="return confirm('Deseja realmente excluir este usuário?')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Excluir Usuário">
                                        <i class='bx bx-trash text-xl'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            </div>

        <div class="mt-6 text-left">
            <a href="../dashboard.php" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-400 hover:text-slate-600 transition-colors">
                <i class='bx bx-arrow-back'></i> Voltar para o dashboard.
            </a>
        </div>

    </div>

</body>
</html>