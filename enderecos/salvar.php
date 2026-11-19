<?php
require __DIR__ . '/../config/bootstrap.php';

// CREATE / UPDATE (processamento): recebe o formulário de form.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('enderecos/index.php');

$pdo = db();
$id = (int)($_POST['id'] ?? 0);   // 0 = cadastro novo; outro número = edição
$apelido = trim($_POST['apelido'] ?? '');
$logradouro = trim($_POST['logradouro'] ?? '');
$numero = trim($_POST['numero'] ?? '');
$bairro = trim($_POST['bairro'] ?? '');
$cidade = trim($_POST['cidade'] ?? '');
$uf = strtoupper(trim($_POST['uf'] ?? ''));
$cep = trim($_POST['cep'] ?? '');

// Validação
if ($apelido === '' || $logradouro === '' || $cidade === '' || $uf === '') {
    flash('danger', 'Preencha os campos obrigatórios: identificação, logradouro, cidade, uf.');
    redirect('enderecos/form.php' . ($id ? '?id=' . $id : ''));
}

if ($id) {
    // UPDATE
    $pdo->prepare('UPDATE enderecos SET apelido = ?, logradouro = ?, numero = ?, bairro = ?, cidade = ?, uf = ?, cep = ? WHERE id = ?')
        ->execute([$apelido, $logradouro, $numero, $bairro, $cidade, $uf, $cep, $id]);
    flash('success', 'Endereço atualizado com sucesso.');
} else {
    // INSERT
    $pdo->prepare('INSERT INTO enderecos (apelido, logradouro, numero, bairro, cidade, uf, cep) VALUES (?, ?, ?, ?, ?, ?, ?)')
        ->execute([$apelido, $logradouro, $numero, $bairro, $cidade, $uf, $cep]);
    flash('success', 'Endereço cadastrado com sucesso.');
}
redirect('enderecos/index.php');
