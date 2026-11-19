<?php
require __DIR__ . '/../config/bootstrap.php';

// CREATE (processamento): grava o frete e seus produtos (1 transportador : N produtos)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('fretes/index.php');

$pdo     = db();
$origem  = (int)($_POST['origem_id'] ?? 0);
$destino = (int)($_POST['destino_id'] ?? 0);
$transp  = (int)($_POST['transportador_id'] ?? 0);
$data    = $_POST['data_frete'] ?? '';
$valor   = (float)str_replace(',', '.', $_POST['valor_frete'] ?? '0');
$obs     = trim($_POST['observacao'] ?? '');
$prods   = array_map('intval', $_POST['produto_id'] ?? []);
$qtds    = array_map('intval', $_POST['quantidade'] ?? []);

// Validação
$erro = null;
if (!$origem || !$destino || !$transp || !$data) $erro = 'Preencha todos os campos obrigatórios.';
elseif ($origem === $destino) $erro = 'Origem e destino devem ser endereços diferentes.';
elseif (!array_filter($prods)) $erro = 'Adicione pelo menos um produto ao frete.';
if ($erro) { flash('danger', $erro); redirect('fretes/novo.php'); }

// Grava tudo ou nada (transação)
$pdo->beginTransaction();
$pdo->prepare('INSERT INTO fretes (data_frete, origem_id, destino_id, transportador_id, valor_frete, observacao)
               VALUES (?, ?, ?, ?, ?, ?)')
    ->execute([$data, $origem, $destino, $transp, $valor, $obs]);
$freteId = (int)$pdo->lastInsertId();

$ins = $pdo->prepare('INSERT INTO frete_produtos (frete_id, produto_id, quantidade) VALUES (?, ?, ?)');
foreach ($prods as $i => $produtoId) {
    if ($produtoId) $ins->execute([$freteId, $produtoId, max(1, $qtds[$i] ?? 1)]);
}
$pdo->commit();

flash('success', "Frete #$freteId gerado com sucesso.");
redirect('fretes/ver.php?id=' . $freteId);
