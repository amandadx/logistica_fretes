<?php
require __DIR__ . '/../config/bootstrap.php';

// CREATE / UPDATE (processamento): recebe o formulário de form.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('produtos/index.php');

$pdo = db();
$id = (int)($_POST['id'] ?? 0);   // 0 = cadastro novo; outro número = edição
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$peso = (float)str_replace(',', '.', $_POST['peso'] ?? '0');
$valor = (float)str_replace(',', '.', $_POST['valor'] ?? '0');

// Validação
if ($nome === '') {
    flash('danger', 'Preencha os campos obrigatórios: nome.');
    redirect('produtos/form.php' . ($id ? '?id=' . $id : ''));
}

if ($id) {
    // UPDATE
    $pdo->prepare('UPDATE produtos SET nome = ?, descricao = ?, peso = ?, valor = ? WHERE id = ?')
        ->execute([$nome, $descricao, $peso, $valor, $id]);
    flash('success', 'Produto atualizado com sucesso.');
} else {
    // INSERT
    $pdo->prepare('INSERT INTO produtos (nome, descricao, peso, valor) VALUES (?, ?, ?, ?)')
        ->execute([$nome, $descricao, $peso, $valor]);
    flash('success', 'Produto cadastrado com sucesso.');
}
redirect('produtos/index.php');
