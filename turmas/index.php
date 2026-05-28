
<?php
require '../conexao.php';
   $stmt = $pdo->query("SELECT * FROM turmas");
   $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Turmas - SADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-slate-100 font-sans min-h-screen text-slate-800">

    <div class="max-w-6xl mx-auto px-4 py-10">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <i class='bx bx-slideshow text-emerald-600'></i> Controle de Turmas
                </h1>
                <p class="text-sm text-slate-500 mt-1">Gerencie as salas de aula e turnos ativos.</p>
            </div>
            <div>
                <a href="create.php" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md shadow-emerald-100 transition-all">
                    <i class='bx bx-plus text-xl'></i> Nova Turma
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Código</th>
                            <th class="px-6 py-4">Nome da Turma</th>
                            <th class="px-6 py-4">Turno</th>
                            <th class="px-6 py-4 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        <?php foreach ($turmas as $turma):?>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-mono font-semibold text-slate-400"><?php echo $turma['codigo_turma'];?></td>
                            <td class="px-6 py-4 font-semibold text-slate-900"><?php echo $turma['nome_turma'];?></td>
                            <td class="px-6 py-4 text-slate-500"><?php echo $turma['turno'];?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="edit.php?id=1" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"><i class='bx bx-edit-alt text-xl'></i></a>
                                    <a href="delete.php?id=1" onclick="return confirm('Deseja excluir esta turma?')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"><i class='bx bx-trash text-xl'></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            <a href="../dashboard.php" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-400 hover:text-slate-600 transition-colors">
                <i class='bx bx-arrow-back'></i> Voltar para o Dashboard
            </a>
        </div>
    </div>

</body>
</html>