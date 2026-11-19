<?php
require __DIR__ . '/../config/bootstrap.php';

// CREATE / UPDATE (processamento): recebe o formulário de form.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('transportadores/index.php');

$pdo = db();
$id = (int)($_POST['id'] ?? 0);   // 0 = cadastro novo; outro número = edição
$nome = trim($_POST['nome'] ?? '');
$documento = trim($_POST['documento'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$placa = strtoupper(trim($_POST['placa'] ?? ''));

// Validação
if ($nome === '') {
    flash('danger', 'Preencha os campos obrigatórios: nome / razão social.');
    redirect('transportadores/form.php' . ($id ? '?id=' . $id : ''));
}

if ($id) {
    // UPDATE
    $pdo->prepare('UPDATE transportadores SET nome = ?, documento = ?, telefone = ?, placa = ? WHERE id = ?')
        ->execute([$nome, $documento, $telefone, $placa, $id]);
    flash('success', 'Transportador atualizado com sucesso.');
} else {
    // INSERT
    $pdo->prepare('INSERT INTO transportadores (nome, documento, telefone, placa) VALUES (?, ?, ?, ?)')
        ->execute([$nome, $documento, $telefone, $placa]);
    flash('success', 'Transportador cadastrado com sucesso.');
}
redirect('transportadores/index.php');
