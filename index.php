<?php
session_start();
require_once 'db.php';

// Proteção da página: se não estiver logado, redireciona para a tela de login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Logout do Usuário
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Inicializações de controle de visualização
// Abas disponíveis: usuarios, turmas, alunos, funcionarios
$tab_ativa = $_GET['tab'] ?? 'usuarios';
if (!in_array($tab_ativa, ['usuarios', 'turmas', 'alunos', 'funcionarios'])) {
    $tab_ativa = 'usuarios';
}

$action = $_GET['action'] ?? 'list'; // list, add, edit, delete
$edit_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

$mensagem_sucesso = '';
$mensagem_erro = '';

// ==========================================
// CONTROLADOR - PROCESSAMENTO DOS CRUDs (POST)
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // CRUD: USUÁRIOS
    if ($tab_ativa === 'usuarios') {
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        
        if (isset($_POST['add'])) {
            // Criar Usuário
            if (empty($nome) || empty($email) || empty($senha)) {
                $mensagem_erro = "Preencha todos os campos.";
            } else {
                try {
                    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
                    $stmt->execute([$nome, $email, $senha_hash]);
                    $mensagem_sucesso = "Usuário cadastrado com sucesso!";
                    $action = 'list';
                } catch (PDOException $e) {
                    $mensagem_erro = "E-mail já cadastrado ou erro no servidor: " . $e->getMessage();
                }
            }
        } elseif (isset($_POST['edit']) && $edit_id) {
            // Editar Usuário
            if (empty($nome) || empty($email)) {
                $mensagem_erro = "Nome e e-mail são obrigatórios.";
            } else {
                try {
                    if (!empty($senha)) {
                        // Altera a senha caso tenha sido informada
                        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                        $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?");
                        $stmt->execute([$nome, $email, $senha_hash, $edit_id]);
                    } else {
                        // Mantém a senha atual
                        $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
                        $stmt->execute([$nome, $email, $edit_id]);
                    }
                    $mensagem_sucesso = "Usuário atualizado com sucesso!";
                    $action = 'list';
                } catch (PDOException $e) {
                    $mensagem_erro = "Erro ao atualizar usuário: " . $e->getMessage();
                }
            }
        }
    }

    // CRUD: TURMAS
    if ($tab_ativa === 'turmas') {
        $nome = trim($_POST['nome'] ?? '');
        $sala = trim($_POST['sala'] ?? '');
        $periodo = trim($_POST['periodo'] ?? '');

        if (isset($_POST['add'])) {
            if (empty($nome) || empty($sala) || empty($periodo)) {
                $mensagem_erro = "Todos os campos da turma são obrigatórios.";
            } else {
                try {
                    $stmt = $pdo->prepare("INSERT INTO turmas (nome, sala, periodo) VALUES (?, ?, ?)");
                    $stmt->execute([$nome, $sala, $periodo]);
                    $mensagem_sucesso = "Turma criada com sucesso!";
                    $action = 'list';
                } catch (PDOException $e) {
                    $mensagem_erro = "Erro ao criar turma: " . $e->getMessage();
                }
            }
        } elseif (isset($_POST['edit']) && $edit_id) {
            if (empty($nome) || empty($sala) || empty($periodo)) {
                $mensagem_erro = "Todos os campos da turma são obrigatórios.";
            } else {
                try {
                    $stmt = $pdo->prepare("UPDATE turmas SET nome = ?, sala = ?, periodo = ? WHERE id = ?");
                    $stmt->execute([$nome, $sala, $periodo, $edit_id]);
                    $mensagem_sucesso = "Turma atualizada com sucesso!";
                    $action = 'list';
                } catch (PDOException $e) {
                    $mensagem_erro = "Erro ao atualizar turma: " . $e->getMessage();
                }
            }
        }
    }

    // CRUD: ALUNOS
    if ($tab_ativa === 'alunos') {
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $data_nascimento = trim($_POST['data_nascimento'] ?? '');
        $turma_id = !empty($_POST['turma_id']) ? (int)$_POST['turma_id'] : null;

        if (isset($_POST['add'])) {
            if (empty($nome) || empty($email) || empty($data_nascimento)) {
                $mensagem_erro = "Campos obrigatórios: Nome, E-mail e Data de Nascimento.";
            } else {
                try {
                    $stmt = $pdo->prepare("INSERT INTO alunos (nome, email, data_nascimento, turma_id) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$nome, $email, $data_nascimento, $turma_id]);
                    $mensagem_sucesso = "Aluno cadastrado com sucesso!";
                    $action = 'list';
                } catch (PDOException $e) {
                    $mensagem_erro = "E-mail de aluno já existe ou erro no sistema: " . $e->getMessage();
                }
            }
        } elseif (isset($_POST['edit']) && $edit_id) {
            if (empty($nome) || empty($email) || empty($data_nascimento)) {
                $mensagem_erro = "Campos obrigatórios: Nome, E-mail e Data de Nascimento.";
            } else {
                try {
                    $stmt = $pdo->prepare("UPDATE alunos SET nome = ?, email = ?, data_nascimento = ?, turma_id = ? WHERE id = ?");
                    $stmt->execute([$nome, $email, $data_nascimento, $turma_id, $edit_id]);
                    $mensagem_sucesso = "Aluno atualizado com sucesso!";
                    $action = 'list';
                } catch (PDOException $e) {
                    $mensagem_erro = "Erro ao atualizar aluno: " . $e->getMessage();
                }
            }
        }
    }

    // CRUD: FUNCIONÁRIOS
    if ($tab_ativa === 'funcionarios') {
        $nome = trim($_POST['nome'] ?? '');
        $cargo = trim($_POST['cargo'] ?? '');
        $salario = trim($_POST['salario'] ?? '');
        $data_admissao = trim($_POST['data_admissao'] ?? '');

        if (isset($_POST['add'])) {
            if (empty($nome) || empty($cargo) || empty($salario) || empty($data_admissao)) {
                $mensagem_erro = "Todos os campos do funcionário são obrigatórios.";
            } else {
                try {
                    $stmt = $pdo->prepare("INSERT INTO funcionarios (nome, cargo, salario, data_admissao) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$nome, $cargo, $salario, $data_admissao]);
                    $mensagem_sucesso = "Funcionário cadastrado com sucesso!";
                    $action = 'list';
                } catch (PDOException $e) {
                    $mensagem_erro = "Erro ao cadastrar funcionário: " . $e->getMessage();
                }
            }
        } elseif (isset($_POST['edit']) && $edit_id) {
            if (empty($nome) || empty($cargo) || empty($salario) || empty($data_admissao)) {
                $mensagem_erro = "Todos os campos do funcionário são obrigatórios.";
            } else {
                try {
                    $stmt = $pdo->prepare("UPDATE funcionarios SET nome = ?, cargo = ?, salario = ?, data_admissao = ? WHERE id = ?");
                    $stmt->execute([$nome, $cargo, $salario, $data_admissao, $edit_id]);
                    $mensagem_sucesso = "Funcionário atualizado com sucesso!";
                    $action = 'list';
                } catch (PDOException $e) {
                    $mensagem_erro = "Erro ao atualizar funcionário: " . $e->getMessage();
                }
            }
        }
    }
}

// ==========================================
// PROCESSAMENTO DE EXCLUSÃO (GET)
// ==========================================
if ($action === 'delete' && $edit_id) {
    try {
        if ($tab_ativa === 'usuarios') {
            // Proteção para o usuário não se auto-deletar
            if ($edit_id === (int)$_SESSION['usuario_id']) {
                $mensagem_erro = "Você não pode excluir sua própria conta enquanto estiver logado.";
            } else {
                $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
                $stmt->execute([$edit_id]);
                $mensagem_sucesso = "Usuário excluído com sucesso!";
            }
        } elseif ($tab_ativa === 'turmas') {
            $stmt = $pdo->prepare("DELETE FROM turmas WHERE id = ?");
            $stmt->execute([$edit_id]);
            $mensagem_sucesso = "Turma excluída com sucesso!";
        } elseif ($tab_ativa === 'alunos') {
            $stmt = $pdo->prepare("DELETE FROM alunos WHERE id = ?");
            $stmt->execute([$edit_id]);
            $mensagem_sucesso = "Aluno excluído com sucesso!";
        } elseif ($tab_ativa === 'funcionarios') {
            $stmt = $pdo->prepare("DELETE FROM funcionarios WHERE id = ?");
            $stmt->execute([$edit_id]);
            $mensagem_sucesso = "Funcionário excluído com sucesso!";
        }
        $action = 'list';
    } catch (PDOException $e) {
        $mensagem_erro = "Não foi possível excluir este registro. Ele pode estar sendo utilizado em outra tabela (Integridade Referencial).";
        $action = 'list';
    }
}

// ==========================================
// LEITURA DE DADOS (SELECT)
// ==========================================
$dados = [];
$registro_edicao = null;

try {
    if ($tab_ativa === 'usuarios') {
        $dados = $pdo->query("SELECT id, nome, email, criado_em FROM usuarios ORDER BY id DESC")->fetchAll();
        if ($action === 'edit' && $edit_id) {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$edit_id]);
            $registro_edicao = $stmt->fetch();
        }
    } elseif ($tab_ativa === 'turmas') {
        $dados = $pdo->query("SELECT * FROM turmas ORDER BY id DESC")->fetchAll();
        if ($action === 'edit' && $edit_id) {
            $stmt = $pdo->prepare("SELECT * FROM turmas WHERE id = ?");
            $stmt->execute([$edit_id]);
            $registro_edicao = $stmt->fetch();
        }
    } elseif ($tab_ativa === 'alunos') {
        // Junção SQL Real para exibir o nome da turma ao listar os alunos
        $dados = $pdo->query("SELECT a.*, t.nome as turma_nome FROM alunos a LEFT JOIN turmas t ON a.turma_id = t.id ORDER BY a.id DESC")->fetchAll();
        // Busca turmas disponíveis para preencher a seleção dinâmica de turmas
        $turmas_disponiveis = $pdo->query("SELECT id, nome FROM turmas ORDER BY nome ASC")->fetchAll();
        if ($action === 'edit' && $edit_id) {
            $stmt = $pdo->prepare("SELECT * FROM alunos WHERE id = ?");
            $stmt->execute([$edit_id]);
            $registro_edicao = $stmt->fetch();
        }
    } elseif ($tab_ativa === 'funcionarios') {
        $dados = $pdo->query("SELECT * FROM funcionarios ORDER BY id DESC")->fetchAll();
        if ($action === 'edit' && $edit_id) {
            $stmt = $pdo->prepare("SELECT * FROM funcionarios WHERE id = ?");
            $stmt->execute([$edit_id]);
            $registro_edicao = $stmt->fetch();
        }
    }

    // Dados de estatísticas gerais do Painel
    $total_usuarios = $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
    $total_turmas = $pdo->query("SELECT COUNT(*) FROM turmas")->fetchColumn();
    $total_alunos = $pdo->query("SELECT COUNT(*) FROM alunos")->fetchColumn();
    $total_funcionarios = $pdo->query("SELECT COUNT(*) FROM funcionarios")->fetchColumn();

} catch (PDOException $e) {
    $mensagem_erro = "Falha de banco de dados: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Gerenciador Acadêmico</title>
    <!-- Utilização do Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 font-sans flex flex-col">

    <!-- CABEÇALHO DO SISTEMA -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logotipo do Sistema -->
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-black text-xl">
                        S
                    </div>
                    <div>
                        <span class="text-lg font-bold text-slate-900 block leading-tight">Painel Administrativo</span>
                        <span class="text-xs text-slate-500">Gestão Educacional Integrada</span>
                    </div>
                </div>

                <!-- Detalhes do Usuário e Logout -->
                <div class="flex items-center space-x-4">
                    <div class="hidden md:block text-right">
                        <span class="text-sm font-semibold text-slate-700 block"><?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>
                        <span class="text-xs text-slate-400 block"><?= htmlspecialchars($_SESSION['usuario_email']) ?></span>
                    </div>
                    <a href="index.php?action=logout" 
                       class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold rounded-lg text-sm transition">
                        Sair do Painel
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- CARDS DE MÉTRICAS RÁPIDAS -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg font-bold text-xl">U</div>
                <div>
                    <span class="text-sm text-slate-500 block">Usuários</span>
                    <span class="text-2xl font-bold text-slate-900"><?= $total_usuarios ?></span>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg font-bold text-xl">T</div>
                <div>
                    <span class="text-sm text-slate-500 block">Turmas</span>
                    <span class="text-2xl font-bold text-slate-900"><?= $total_turmas ?></span>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg font-bold text-xl">A</div>
                <div>
                    <span class="text-sm text-slate-500 block">Alunos</span>
                    <span class="text-2xl font-bold text-slate-900"><?= $total_alunos ?></span>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-lg font-bold text-xl">F</div>
                <div>
                    <span class="text-sm text-slate-500 block">Funcionários</span>
                    <span class="text-2xl font-bold text-slate-900"><?= $total_funcionarios ?></span>
                </div>
            </div>
        </div>

        <!-- MENSAGENS DE NOTIFICAÇÃO -->
        <?php if (!empty($mensagem_sucesso)): ?>
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm">
                <strong>Sucesso:</strong> <?= htmlspecialchars($mensagem_sucesso) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($mensagem_erro)): ?>
            <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-800 rounded-r-lg shadow-sm">
                <strong>Atenção:</strong> <?= htmlspecialchars($mensagem_erro) ?>
            </div>
        <?php endif; ?>

        <!-- ABAS DE NAVEGAÇÃO DOS 4 CRUDS -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="flex border-b border-slate-200 overflow-x-auto">
                <a href="index.php?tab=usuarios" 
                   class="flex-1 min-w-[120px] text-center px-6 py-4 font-semibold text-sm transition border-b-2 hover:bg-slate-50 <?= $tab_ativa === 'usuarios' ? 'border-blue-600 text-blue-600 bg-blue-50/10' : 'border-transparent text-slate-500' ?>">
                    Administradores
                </a>
                <a href="index.php?tab=turmas" 
                   class="flex-1 min-w-[120px] text-center px-6 py-4 font-semibold text-sm transition border-b-2 hover:bg-slate-50 <?= $tab_ativa === 'turmas' ? 'border-blue-600 text-blue-600 bg-blue-50/10' : 'border-transparent text-slate-500' ?>">
                    Turmas
                </a>
                <a href="index.php?tab=alunos" 
                   class="flex-1 min-w-[120px] text-center px-6 py-4 font-semibold text-sm transition border-b-2 hover:bg-slate-50 <?= $tab_ativa === 'alunos' ? 'border-blue-600 text-blue-600 bg-blue-50/10' : 'border-transparent text-slate-500' ?>">
                    Alunos
                </a>
                <a href="index.php?tab=funcionarios" 
                   class="flex-1 min-w-[120px] text-center px-6 py-4 font-semibold text-sm transition border-b-2 hover:bg-slate-50 <?= $tab_ativa === 'funcionarios' ? 'border-blue-600 text-blue-600 bg-blue-50/10' : 'border-transparent text-slate-500' ?>">
                    Funcionários
                </a>
            </div>

            <div class="p-6">
                
                <!-- ÁREA DE CONTROLE: TELA LISTAR OU FORMULÁRIO -->
                <?php if ($action === 'list'): ?>
                    
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-slate-800 capitalize">
                            Lista de <?= $tab_ativa ?>
                        </h2>
                        <a href="index.php?tab=<?= $tab_ativa ?>&action=add" 
                           class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm text-sm transition">
                            + Novo Registro
                        </a>
                    </div>

                    <!-- TABELAS DE EXIBIÇÃO -->
                    <div class="overflow-x-auto rounded-lg border border-slate-100">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-600 text-xs font-semibold uppercase border-b border-slate-200">
                                    <?php if ($tab_ativa === 'usuarios'): ?>
                                        <th class="px-6 py-4">ID</th>
                                        <th class="px-6 py-4">Nome</th>
                                        <th class="px-6 py-4">E-mail</th>
                                        <th class="px-6 py-4">Ações</th>
                                    <?php elseif ($tab_ativa === 'turmas'): ?>
                                        <th class="px-6 py-4">ID</th>
                                        <th class="px-6 py-4">Nome da Turma</th>
                                        <th class="px-6 py-4">Sala</th>
                                        <th class="px-6 py-4">Período</th>
                                        <th class="px-6 py-4">Ações</th>
                                    <?php elseif ($tab_ativa === 'alunos'): ?>
                                        <th class="px-6 py-4">ID</th>
                                        <th class="px-6 py-4">Nome Completo</th>
                                        <th class="px-6 py-4">E-mail</th>
                                        <th class="px-6 py-4">Data Nasc.</th>
                                        <th class="px-6 py-4">Turma Vinculada</th>
                                        <th class="px-6 py-4">Ações</th>
                                    <?php elseif ($tab_ativa === 'funcionarios'): ?>
                                        <th class="px-6 py-4">ID</th>
                                        <th class="px-6 py-4">Nome</th>
                                        <th class="px-6 py-4">Cargo</th>
                                        <th class="px-6 py-4">Salário</th>
                                        <th class="px-6 py-4">Admissão</th>
                                        <th class="px-6 py-4">Ações</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                <?php if (empty($dados)): ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-slate-400 italic">
                                            Nenhum registro encontrado nesta seção.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($dados as $linha): ?>
                                        <tr class="hover:bg-slate-50/50 transition">
                                            <?php if ($tab_ativa === 'usuarios'): ?>
                                                <td class="px-6 py-4 font-semibold text-slate-500">#<?= $linha['id'] ?></td>
                                                <td class="px-6 py-4 font-semibold text-slate-800"><?= htmlspecialchars($linha['nome']) ?></td>
                                                <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($linha['email']) ?></td>
                                            <?php elseif ($tab_ativa === 'turmas'): ?>
                                                <td class="px-6 py-4 font-semibold text-slate-500">#<?= $linha['id'] ?></td>
                                                <td class="px-6 py-4 font-semibold text-slate-800"><?= htmlspecialchars($linha['nome']) ?></td>
                                                <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($linha['sala']) ?></td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-700">
                                                        <?= htmlspecialchars($linha['periodo']) ?>
                                                    </span>
                                                </td>
                                            <?php elseif ($tab_ativa === 'alunos'): ?>
                                                <td class="px-6 py-4 font-semibold text-slate-500">#<?= $linha['id'] ?></td>
                                                <td class="px-6 py-4 font-semibold text-slate-800"><?= htmlspecialchars($linha['nome']) ?></td>
                                                <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($linha['email']) ?></td>
                                                <td class="px-6 py-4 text-slate-500"><?= date('d/m/Y', strtotime($linha['data_nascimento'])) ?></td>
                                                <td class="px-6 py-4">
                                                    <?php if ($linha['turma_nome']): ?>
                                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-50 text-blue-700">
                                                            <?= htmlspecialchars($linha['turma_nome']) ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-50 text-rose-600">
                                                            Sem Turma
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                            <?php elseif ($tab_ativa === 'funcionarios'): ?>
                                                <td class="px-6 py-4 font-semibold text-slate-500">#<?= $linha['id'] ?></td>
                                                <td class="px-6 py-4 font-semibold text-slate-800"><?= htmlspecialchars($linha['nome']) ?></td>
                                                <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($linha['cargo']) ?></td>
                                                <td class="px-6 py-4 font-semibold text-slate-700">R$ <?= number_format($linha['salario'], 2, ',', '.') ?></td>
                                                <td class="px-6 py-4 text-slate-500"><?= date('d/m/Y', strtotime($linha['data_admissao'])) ?></td>
                                            <?php endif; ?>
                                            
                                            <!-- Ações Rápidas -->
                                            <td class="px-6 py-4 flex items-center space-x-2">
                                                <a href="index.php?tab=<?= $tab_ativa ?>&action=edit&id=<?= $linha['id'] ?>" 
                                                   class="text-blue-600 hover:text-blue-800 font-semibold text-xs border border-blue-200 hover:border-blue-300 px-2.5 py-1.5 rounded bg-white transition">
                                                    Editar
                                                </a>
                                                <a href="index.php?tab=<?= $tab_ativa ?>&action=delete&id=<?= $linha['id'] ?>" 
                                                   onclick="return confirm('Tem certeza de que deseja deletar este registro de <?= $tab_ativa ?>?');" 
                                                   class="text-rose-600 hover:text-rose-800 font-semibold text-xs border border-rose-200 hover:border-rose-300 px-2.5 py-1.5 rounded bg-white transition">
                                                    Excluir
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                <?php else: ?>
                    
                    <!-- FORMULÁRIO DE ADIÇÃO OU EDIÇÃO -->
                    <div class="max-w-2xl mx-auto bg-slate-50 border border-slate-200 p-8 rounded-xl shadow-sm">
                        
                        <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-200">
                            <h3 class="text-lg font-bold text-slate-800">
                                <?= $action === 'edit' ? 'Editar Registro em ' : 'Novo Registro em ' ?> <span class="capitalize"><?= $tab_ativa ?></span>
                            </h3>
                            <a href="index.php?tab=<?= $tab_ativa ?>&action=list" class="text-sm text-slate-500 hover:text-slate-700 font-semibold">
                                &larr; Voltar para Lista
                            </a>
                        </div>

                        <form action="index.php?tab=<?= $tab_ativa ?>&action=<?= $action ?><?= $edit_id ? '&id='.$edit_id : '' ?>" method="POST" class="space-y-5">
                            
                            <!-- FORM DE USUÁRIOS -->
                            <?php if ($tab_ativa === 'usuarios'): ?>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nome Completo</label>
                                    <input type="text" name="nome" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           value="<?= htmlspecialchars($registro_edicao['nome'] ?? '') ?>">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Endereço de E-mail</label>
                                    <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           value="<?= htmlspecialchars($registro_edicao['email'] ?? '') ?>">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                                        Senha <?= $action === 'edit' ? '(Deixe em branco para não alterar)' : '' ?>
                                    </label>
                                    <input type="password" name="senha" <?= $action === 'add' ? 'required' : '' ?> class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                            <!-- FORM DE TURMAS -->
                            <?php elseif ($tab_ativa === 'turmas'): ?>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nome da Turma</label>
                                    <input type="text" name="nome" required placeholder="Ex: Informática 1A" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           value="<?= htmlspecialchars($registro_edicao['nome'] ?? '') ?>">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Sala</label>
                                    <input type="text" name="sala" required placeholder="Ex: Laboratório II" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           value="<?= htmlspecialchars($registro_edicao['sala'] ?? '') ?>">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Período</label>
                                    <select name="periodo" required class="w-full px-4 py-2 border rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Selecione...</option>
                                        <option value="Manhã" <?= (isset($registro_edicao['periodo']) && $registro_edicao['periodo'] === 'Manhã') ? 'selected' : '' ?>>Manhã</option>
                                        <option value="Tarde" <?= (isset($registro_edicao['periodo']) && $registro_edicao['periodo'] === 'Tarde') ? 'selected' : '' ?>>Tarde</option>
                                        <option value="Noite" <?= (isset($registro_edicao['periodo']) && $registro_edicao['periodo'] === 'Noite') ? 'selected' : '' ?>>Noite</option>
                                    </select>
                                </div>

                            <!-- FORM DE ALUNOS -->
                            <?php elseif ($tab_ativa === 'alunos'): ?>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nome Completo</label>
                                    <input type="text" name="nome" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           value="<?= htmlspecialchars($registro_edicao['nome'] ?? '') ?>">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">E-mail para Contato</label>
                                    <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           value="<?= htmlspecialchars($registro_edicao['email'] ?? '') ?>">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Data de Nascimento</label>
                                    <input type="date" name="data_nascimento" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           value="<?= htmlspecialchars($registro_edicao['data_nascimento'] ?? '') ?>">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Vincular a uma Turma</label>
                                    <select name="turma_id" class="w-full px-4 py-2 border rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Sem turma vinculada</option>
                                        <?php foreach ($turmas_disponiveis as $turma): ?>
                                            <option value="<?= $turma['id'] ?>" <?= (isset($registro_edicao['turma_id']) && $registro_edicao['turma_id'] == $turma['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($turma['nome']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            <!-- FORM DE FUNCIONÁRIOS -->
                            <?php elseif ($tab_ativa === 'funcionarios'): ?>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nome Completo</label>
                                    <input type="text" name="nome" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           value="<?= htmlspecialchars($registro_edicao['nome'] ?? '') ?>">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Cargo / Função</label>
                                    <input type="text" name="cargo" required placeholder="Ex: Professor de Biologia" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           value="<?= htmlspecialchars($registro_edicao['cargo'] ?? '') ?>">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Salário Mensal (R$)</label>
                                    <input type="number" step="0.01" name="salario" required placeholder="Ex: 3500.00" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           value="<?= htmlspecialchars($registro_edicao['salario'] ?? '') ?>">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Data de Admissão</label>
                                    <input type="date" name="data_admissao" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           value="<?= htmlspecialchars($registro_edicao['data_admissao'] ?? '') ?>">
                                </div>
                            <?php endif; ?>

                            <div class="flex items-center space-x-3 pt-4 border-t border-slate-200">
                                <button type="submit" name="<?= $action ?>" 
                                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm text-sm transition">
                                    <?= $action === 'edit' ? 'Salvar Alterações' : 'Cadastrar Registro' ?>
                                </button>
                                <a href="index.php?tab=<?= $tab_ativa ?>&action=list" 
                                   class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold rounded-lg text-sm transition">
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-200 py-6 mt-12 text-center text-sm text-slate-500">
        <p>&copy; <?= date('Y') ?> Gerenciador Administrativo Escolar.</p>
        <p class="text-xs text-slate-400 mt-1">Desenvolvido por Icaro Pereira, estudante de Informatica 2, Orientador Professor Renan, para fins de estudo e prática de CRUD em PHP com PDO.</p>

</body>
</html>