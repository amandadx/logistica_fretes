<?php
require __DIR__ . '/../config/bootstrap.php';

// CREATE (tela): formulário de novo frete
$pdo = db();
$enderecos = $pdo->query('SELECT * FROM enderecos ORDER BY apelido')->fetchAll();
$transps   = $pdo->query('SELECT * FROM transportadores ORDER BY nome')->fetchAll();
$produtos  = $pdo->query('SELECT * FROM produtos ORDER BY nome')->fetchAll();

// Monta as <option> de um <select>
function opcoes(array $rows, string $campo, ?callable $extra = null): string {
    $h = '<option value="">Selecione…</option>';
    foreach ($rows as $r) $h .= '<option value="' . (int)$r['id'] . '">' . e($r[$campo]) . ($extra ? ' — ' . e($extra($r)) : '') . '</option>';
    return $h;
}

$titulo = 'Novo frete';
include __DIR__ . '/../includes/header.php';
?>
<h2 class="mb-3"><i class="bi bi-plus-circle"></i> Novo frete</h2>
<?php if (!$enderecos || !$transps || !$produtos): ?>
  <div class="alert alert-warning">Antes de gerar um frete, cadastre ao menos
    <a href="<?= url('produtos/form.php') ?>">um produto</a>, <a href="<?= url('enderecos/form.php') ?>">dois endereços</a>
    e <a href="<?= url('transportadores/form.php') ?>">um transportador</a>.</div>
<?php else: ?>
<form method="post" action="<?= url('fretes/salvar.php') ?>">
  <div class="card shadow-sm mb-4"><div class="card-header fw-semibold">Dados do frete</div><div class="card-body row g-3">
    <div class="col-md-3"><label class="form-label">Data *</label>
      <input type="date" name="data_frete" class="form-control" value="<?= date('Y-m-d') ?>" required></div>
    <div class="col-md-5"><label class="form-label">Origem *</label>
      <select name="origem_id" class="form-select" required><?= opcoes($enderecos, 'apelido', fn($r) => $r['cidade'] . '/' . $r['uf']) ?></select></div>
    <div class="col-md-4"><label class="form-label">Destino *</label>
      <select name="destino_id" class="form-select" required><?= opcoes($enderecos, 'apelido', fn($r) => $r['cidade'] . '/' . $r['uf']) ?></select></div>
    <div class="col-md-5"><label class="form-label">Transportador *</label>
      <select name="transportador_id" class="form-select" required><?= opcoes($transps, 'nome') ?></select></div>
    <div class="col-md-3"><label class="form-label">Valor do frete (R$)</label>
      <input type="number" step="0.01" min="0" name="valor_frete" class="form-control" value="0"></div>
    <div class="col-md-4"><label class="form-label">Observação</label>
      <input type="text" name="observacao" class="form-control"></div>
  </div></div>

  <div class="card shadow-sm mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span class="fw-semibold">Produtos transportados</span>
      <button type="button" id="btn-add" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-lg"></i> Adicionar produto</button>
    </div>
    <div class="card-body" id="itens"></div>   <!-- o JavaScript (assets/js/app.js) preenche aqui -->
  </div>
  <button class="btn btn-primary"><i class="bi bi-check2"></i> Gerar frete</button>
  <a href="<?= url('fretes/index.php') ?>" class="btn btn-outline-secondary">Cancelar</a>
</form>

<!-- Modelo clonado pelo JavaScript para cada novo produto -->
<template id="modelo-item">
  <div class="row g-2 mb-2 item-linha">
    <div class="col-8 col-md-9"><select name="produto_id[]" class="form-select" required>
      <?= opcoes($produtos, 'nome', fn($r) => number_format($r['peso'], 2, ',', '.') . ' kg') ?></select></div>
    <div class="col-3 col-md-2"><input type="number" name="quantidade[]" class="form-control" min="1" value="1" required></div>
    <div class="col-1"><button type="button" class="btn btn-outline-danger btn-remover" title="Remover"><i class="bi bi-x-lg"></i></button></div>
  </div>
</template>
<?php endif;
include __DIR__ . '/../includes/footer.php';
