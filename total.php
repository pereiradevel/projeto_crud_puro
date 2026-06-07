<?php

require 'conexao.php';
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM alunos");
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);


$totalAlunos = $resultado['total'];
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM funcionarios");
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
$totalFuncionarios = $resultado['total'];
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM turmas");
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
$totalTurmas = $resultado['total'];
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM usuarios");
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
$totalUsuarios = $resultado['total'];

?>