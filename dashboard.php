<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema SADE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-slate-800 text-slate-100 flex flex-col justify-between hidden md:flex">
            <div>
                <div class="h-16 flex items-center justify-center bg-slate-950 font-bold text-lg tracking-wider border-b border-slate-700">
                    <i class='bx bxs-graduation mr-2 text-xl text-indigo-400'></i> SISTEMA SADE
                </div>
                
                <nav class="mt-6 px-4 space-y-1">
                    <a href="dashboard.php" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg bg-indigo-600 text-white transition-colors">
                        <i class='bx bxs-dashboard mr-3 text-lg'></i>
                        Dashboard
                    </a>
                    
                    <div class="pt-4 pb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        Gerenciamento (CRUDs)
                    </div>

                    <a href="alunos/index.php" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors group">
                        <i class='bx bxs-user-badge mr-3 text-lg group-hover:text-indigo-400'></i>
                        Alunos
                    </a>

                    <a href="funcionarios/index.php" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors group">
                        <i class='bx bxs-briefcase mr-3 text-lg group-hover:text-indigo-400'></i>
                        Funcionários
                    </a>

                    <a href="turmas/index.php" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors group">
                        <i class='bx bxs-group mr-3 text-lg group-hover:text-indigo-400'></i>
                        Turmas
                    </a>

                    <a href="usuarios/index.php" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors group">
                        <i class='bx bxs-user-account mr-3 text-lg group-hover:text-indigo-400'></i>
                        Usuários
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-slate-700">
                <a href="index.php" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg text-red-400 hover:bg-slate-700 hover:text-red-300 transition-colors">
                    <i class='bx bx-log-out mr-3 text-lg'></i>
                    Sair do Sistema
                </a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-y-auto">
            
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10">
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700 md:hidden block">
                        <i class='bx bx-menu text-2xl'></i>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-800">Painel de Controle</h1>
                </div>
                
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-medium text-gray-600">Administrador</span>
                    <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">
                        A
                    </div>
                </div>
            </header>

            <main class="p-6 max-w-7xl w-full mx-auto space-y-6">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Alunos</p>
                            <a href="alunos/index.php" class="text-xs text-indigo-600 hover:underline font-medium mt-2 inline-block">Gerenciar módulo →</a>
                        </div>
                        <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                            <i class='bx bxs-user-badge text-2xl'></i>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Funcionários</p>
                            <a href="funcionarios/index.php" class="text-xs text-emerald-600 hover:underline font-medium mt-2 inline-block">Gerenciar módulo →</a>
                        </div>
                        <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                            <i class='bx bxs-briefcase text-2xl'></i>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Turmas</p>
                            <a href="turmas/index.php" class="text-xs text-amber-600 hover:underline font-medium mt-2 inline-block">Gerenciar módulo →</a>
                        </div>
                        <div class="w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center text-amber-600">
                            <i class='bx bxs-group text-2xl'></i>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Usuários</p>
                            <a href="usuarios/index.php" class="text-xs text-rose-600 hover:underline font-medium mt-2 inline-block">Gerenciar módulo →</a>
                        </div>
                        <div class="w-12 h-12 bg-rose-50 rounded-lg flex items-center justify-center text-rose-600">
                            <i class='bx bxs-user-account text-2xl'></i>
                        </div>
                    </div>

                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Bem-vindo ao Sistema SADE</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Use a barra lateral para navegar sobre o Sistema de gerenciamento acadêmico. Aqui você pode acessar os módulos de Alunos, Funcionários, Turmas e Usuários para realizar operações de CRUD (Criar, Ler, Atualizar e Deletar). Mantenha seus dados organizados e atualizados para uma gestão eficiente!
                </div>

            </main>
        </div>
    </div>

</body>
</html>