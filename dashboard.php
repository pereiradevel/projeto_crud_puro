<?php
require_once 'verifica.php';
require 'total.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema SADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-slate-900 text-slate-100 flex flex-col justify-between hidden md:flex">
            <div>
                <div class="h-16 flex items-center justify-center bg-slate-950 font-bold text-lg tracking-wider border-b border-slate-800">
                    <i class='bx bxs-graduation mr-2 text-xl text-indigo-400'></i> SISTEMA SADE
                </div>
                
                <nav class="mt-6 px-4 space-y-1">
                    <a href="dashboard.php" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl bg-indigo-600 text-white shadow-md shadow-indigo-900/20 transition-colors">
                        <i class='bx bxs-dashboard mr-3 text-lg'></i>
                        Dashboard
                    </a>
                    
                    <div class="pt-6 pb-2 text-xs font-bold text-slate-500 uppercase tracking-wider pl-4">
                        Gerenciamento (CRUDs)
                    </div>

                    <a href="alunos/index.php" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-colors group">
                        <i class='bx bxs-user-badge mr-3 text-lg group-hover:text-indigo-400'></i>
                        Alunos
                    </a>

                    <a href="funcionarios/index.php" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-colors group">
                        <i class='bx bxs-briefcase mr-3 text-lg group-hover:text-emerald-400'></i>
                        Funcionários
                    </a>

                    <a href="turmas/index.php" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-colors group">
                        <i class='bx bxs-group mr-3 text-lg group-hover:text-amber-400'></i>
                        Turmas
                    </a>

                    <a href="usuarios/index.php" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-colors group">
                        <i class='bx bxs-user-account mr-3 text-lg group-hover:text-rose-400'></i>
                        Usuários
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-slate-800">
                <a href="logout.php" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl text-slate-400 hover:bg-red-950/40 hover:text-red-400 transition-colors">
                    <i class='bx bx-log-out mr-3 text-lg'></i>
                    Sair do Sistema
                </a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-y-auto">
            
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 z-10">
                <div class="flex items-center space-x-4">
                    <button class="text-slate-500 hover:text-slate-700 md:hidden block">
                        <i class='bx bx-menu text-2xl'></i>
                    </button>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">Painel de Controle</h1>
                </div>
                
                <div class="flex items-center space-x-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-slate-900"><?php echo 'Olá, ' . $_SESSION['usuario']; ?></p>
                        <p class="text-xs text-slate-400">Gestão Geral</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold shadow-md shadow-indigo-100">
                        A
                    </div>
                </div>
            </header>

            <main class="p-8 max-w-7xl w-full mx-auto space-y-8">
                
                <div class="bg-gradient-to-r from-slate-900 to-indigo-950 rounded-2xl shadow-xl border border-slate-800 p-8 text-white relative overflow-hidden">
                    <div class="relative z-10 max-w-2xl">
                        <h2 class="text-2xl font-bold mb-2">Bem-vindo ao Sistema SADE</h2>
                        <p class="text-indigo-200/80 text-sm leading-relaxed">
                            Use a barra lateral para navegar sobre o Sistema de gerenciamento acadêmico. Aqui você pode acessar os módulos de Alunos, Funcionários, Turmas e Usuários para realizar operações de CRUD completo. Mantenha seus dados organizados de forma eficiente!
                        </p>
                    </div>
                    <i class='bx bxs-graduation class absolute right-6 bottom-[-20px] text-[150px] text-white/5 pointer-events-none hidden lg:block'></i>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between hover:shadow-md transition-shadow">
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Alunos</p>
                            <p class="text-2xl font-bold text-slate-900 font-mono"><?php echo $totalAlunos; ?></p>
                            <a href="alunos/index.php" class="text-xs text-indigo-600 hover:text-indigo-700 font-semibold inline-flex items-center gap-0.5">Gerenciar modulo <i class='bx bx-right-arrow-alt'></i></a>
                        </div>
                        <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 shadow-inner">
                            <i class='bx bxs-user-badge text-2xl'></i>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between hover:shadow-md transition-shadow">
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Funcionários</p>
                            <p class="text-2xl font-bold text-slate-900 font-mono"><?php echo $totalFuncionarios; ?></p>
                            <a href="funcionarios/index.php" class="text-xs text-emerald-600 hover:text-emerald-700 font-semibold inline-flex items-center gap-0.5">Gerenciar modulo <i class='bx bx-right-arrow-alt'></i></a>
                        </div>
                        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 shadow-inner">
                            <i class='bx bxs-briefcase text-2xl'></i>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between hover:shadow-md transition-shadow">
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Turmas</p>
                            <p class="text-2xl font-bold text-slate-900 font-mono"><?php echo $totalTurmas; ?></p>
                            <a href="turmas/index.php" class="text-xs text-amber-600 hover:text-amber-700 font-semibold inline-flex items-center gap-0.5">Gerenciar modulo <i class='bx bx-right-arrow-alt'></i></a>
                        </div>
                        <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600 shadow-inner">
                            <i class='bx bxs-group text-2xl'></i>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between hover:shadow-md transition-shadow">
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Usuários</p>
                            <p class="text-2xl font-bold text-slate-900 font-mono"><?php echo $totalUsuarios; ?></p>
                            <a href="usuarios/index.php" class="text-xs text-rose-600 hover:text-rose-700 font-semibold inline-flex items-center gap-0.5">Gerenciar modulo <i class='bx bx-right-arrow-alt'></i></a>
                        </div>
                        <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600 shadow-inner">
                            <i class='bx bxs-user-account text-2xl'></i>
                        </div>
                    </div>

                </div>

                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider pl-1">Ações de Atalho Rápido</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="alunos/create.php" class="p-4 bg-white border border-slate-200 rounded-xl flex items-center gap-3 hover:border-indigo-500 hover:bg-indigo-50/20 transition-all group">
                            <span class="p-2 rounded-lg bg-slate-50 border border-slate-100 text-slate-500 group-hover:bg-indigo-50 group-hover:text-indigo-600 group-hover:border-indigo-100 transition-colors"><i class='bx bx-plus text-lg'></i></span>
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-indigo-950">Matricular Aluno</span>
                        </a>
                        <a href="funcionarios/create.php" class="p-4 bg-white border border-slate-200 rounded-xl flex items-center gap-3 hover:border-emerald-500 hover:bg-emerald-50/20 transition-all group">
                            <span class="p-2 rounded-lg bg-slate-50 border border-slate-100 text-slate-500 group-hover:bg-emerald-50 group-hover:text-emerald-600 group-hover:border-emerald-100 transition-colors"><i class='bx bx-plus text-lg'></i></span>
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-emerald-950">Novo Funcionário</span>
                        </a>
                        <a href="turmas/create.php" class="p-4 bg-white border border-slate-200 rounded-xl flex items-center gap-3 hover:border-amber-500 hover:bg-amber-50/20 transition-all group">
                            <span class="p-2 rounded-lg bg-slate-50 border border-slate-100 text-slate-500 group-hover:bg-amber-50 group-hover:text-amber-600 group-hover:border-amber-100 transition-colors"><i class='bx bx-plus text-lg'></i></span>
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-amber-950">Cadastrar Turma</span>
                        </a>
                        <a href="usuarios/create.php" class="p-4 bg-white border border-slate-200 rounded-xl flex items-center gap-3 hover:border-rose-500 hover:bg-rose-50/20 transition-all group">
                            <span class="p-2 rounded-lg bg-slate-50 border border-slate-100 text-slate-500 group-hover:bg-rose-50 group-hover:text-rose-600 group-hover:border-rose-100 transition-colors"><i class='bx bx-plus text-lg'></i></span>
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-rose-950">Novo Usuário</span>
                        </a>
                    </div>
                </div>

            </main>
        </div>
    </div>

</body>
</html>