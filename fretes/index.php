<?php
require __DIR__ . '/../config/bootstrap.php';
require __DIR__ . '/consultas.php';

// READ: lista todos os fretes
$fretes = fretesComDados();

$titulo = 'Fretes';
include __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="mb-0"><i class="bi bi-truck"></i> Fretes</h2>
  <a href="<?= url('fretes/novo.php') ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Novo frete</a>
</div>
<div class="card shadow-sm"><div class="card-body table-responsive">
<table class="table table-hover align-middle mb-0">
  <thead><tr><th>#</th><th>Data</th><th>Origem → Destino</th><th>Transportador</th><th>Itens</th><th>Valor</th><th class="text-end">Ações</th></tr></thead>
  <tbody>
  <?php foreach ($fretes as $f): ?>
    <tr><td><?= (int)$f['id'] ?></td><td><?= e(dataBR($f['data_frete'])) ?></td>
      <td><?= e($f['origem']) ?> (<?= e($f['origem_cidade']) ?>/<?= e($f['origem_uf']) ?>) → <?= e($f['destino']) ?> (<?= e($f['destino_cidade']) ?>/<?= e($f['destino_uf']) ?>)</td>
      <td><?= e($f['transportador']) ?></td><td><?= (int)$f['itens'] ?></td><td><?= e(money($f['valor_frete'])) ?></td>
      <td class="text-end text-nowrap">
        <a class="btn btn-sm btn-outline-primary" href="<?= url('fretes/ver.php?id=' . (int)$f['id']) ?>" title="Ver"><i class="bi bi-eye"></i></a>
        <form method="post" action="<?= url('fretes/excluir.php') ?>" class="d-inline" onsubmit="return confirm('Excluir este frete?')">
          <input type="hidden" name="id" value="<?= (int)$f['id'] ?>">
          <button class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></button></form></td></tr>
  <?php endforeach; if (!$fretes): ?>
    <tr><td colspan="7" class="text-center text-muted py-4">Nenhum frete gerado ainda.</td></tr>
  <?php endif; ?>
  </tbody></table></div></div>
<?php include __DIR__ . '/../includes/footer.php';
