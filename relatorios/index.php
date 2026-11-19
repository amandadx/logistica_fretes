<?php
require __DIR__ . '/../config/bootstrap.php';
require __DIR__ . '/../fretes/consultas.php';

// Tela do relatório: fretes de um dia
$dia = $_GET['dia'] ?? date('Y-m-d');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dia)) $dia = date('Y-m-d');
$fretes = fretesComDados('WHERE f.data_frete = ?', [$dia]);
$total  = array_sum(array_column($fretes, 'valor_frete'));

$titulo = 'Relatório';
include __DIR__ . '/../includes/header.php';
?>
<h2 class="mb-3"><i class="bi bi-file-earmark-bar-graph"></i> Relatório de fretes por dia</h2>
<form method="get" class="row g-2 align-items-end mb-4 no-print">
  <div class="col-auto"><label class="form-label">Dia</label><input type="date" name="dia" value="<?= e($dia) ?>" class="form-control"></div>
  <div class="col-auto"><button class="btn btn-primary"><i class="bi bi-search"></i> Consultar</button></div>
  <?php if ($fretes): ?>
  <div class="col-auto"><a class="btn btn-success" href="<?= url('relatorios/baixar.php?dia=' . e($dia)) ?>"><i class="bi bi-download"></i> Baixar CSV</a></div>
  <div class="col-auto"><button type="button" class="btn btn-outline-secondary" onclick="window.print()"><i class="bi bi-printer"></i> Imprimir</button></div>
  <?php endif; ?>
</form>
<div class="card shadow-sm"><div class="card-header fw-semibold">Fretes de <?= e(dataBR($dia)) ?></div>
<div class="card-body table-responsive">
<table class="table align-middle mb-0"><thead><tr><th>#</th><th>Origem → Destino</th><th>Transportador</th><th>Itens</th><th>Valor</th></tr></thead><tbody>
<?php foreach ($fretes as $f): ?>
  <tr><td><a href="<?= url('fretes/ver.php?id=' . (int)$f['id']) ?>"><?= (int)$f['id'] ?></a></td>
    <td><?= e($f['origem']) ?> → <?= e($f['destino']) ?></td><td><?= e($f['transportador']) ?></td>
    <td><?= (int)$f['itens'] ?></td><td><?= e(money($f['valor_frete'])) ?></td></tr>
<?php endforeach; if (!$fretes): ?>
  <tr><td colspan="5" class="text-center text-muted py-4">Nenhum frete nesta data.</td></tr>
<?php else: ?>
  <tr class="fw-bold"><td colspan="4" class="text-end">Total</td><td><?= e(money($total)) ?></td></tr>
<?php endif; ?>
</tbody></table></div></div>
<?php include __DIR__ . '/../includes/footer.php';
