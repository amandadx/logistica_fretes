<?php
require __DIR__ . '/config/bootstrap.php';
$titulo = 'Início';
$pdo = db();
$cards = [
  ['Produtos', 'produtos', 'produtos/index.php', 'bi-box-seam'],
  ['Endereços', 'enderecos', 'enderecos/index.php', 'bi-geo-alt'],
  ['Transportadores', 'transportadores', 'transportadores/index.php', 'bi-person-badge'],
  ['Fretes', 'fretes', 'fretes/index.php', 'bi-truck'],
];
include __DIR__ . '/includes/header.php';
?>
<h2 class="mb-1">Painel</h2>
<p class="text-muted">Cadastre produtos, endereços e transportadores e depois gere seus fretes.</p>
<div class="row g-3 mb-4">
<?php foreach ($cards as [$nome, $tab, $link, $icone]): ?>
  <div class="col-6 col-lg-3"><a href="<?= url($link) ?>" class="text-decoration-none">
    <div class="card shadow-sm stat-card h-100"><div class="card-body">
      <i class="bi <?= $icone ?> fs-3 text-secondary"></i>
      <div class="display-6"><?= (int)$pdo->query("SELECT COUNT(*) FROM $tab")->fetchColumn() ?></div>
      <div class="text-muted"><?= $nome ?></div></div></div></a></div>
<?php endforeach; ?>
</div>
<div class="card shadow-sm"><div class="card-body">
  <h5>Como usar</h5>
  <ol class="mb-3">
    <li>Cadastre ao menos um <a href="<?= url('produtos/form.php') ?>">produto</a>, dois <a href="<?= url('enderecos/form.php') ?>">endereços</a> (origem e destino) e um <a href="<?= url('transportadores/form.php') ?>">transportador</a>.</li>
    <li>Em <a href="<?= url('fretes/index.php') ?>">Fretes</a>, clique em “Novo frete” e adicione quantos produtos quiser a um mesmo transportador.</li>
    <li>Em <a href="<?= url('relatorios/index.php') ?>">Relatório</a>, escolha o dia e baixe o arquivo CSV.</li>
  </ol>
  <a href="<?= url('fretes/novo.php') ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Novo frete</a>
</div></div>
<?php include __DIR__ . '/includes/footer.php';
