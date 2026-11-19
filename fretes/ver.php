<?php
require __DIR__ . '/../config/bootstrap.php';
require __DIR__ . '/consultas.php';

// READ (um frete): dados do frete e seus produtos
$id = (int)($_GET['id'] ?? 0);
$lista = fretesComDados('WHERE f.id = ?', [$id]);
if (!$lista) { flash('danger', 'Frete não encontrado.'); redirect('fretes/index.php'); }
$f = $lista[0];

$st = db()->prepare('SELECT p.nome, p.peso, p.valor, fp.quantidade FROM frete_produtos fp
                     JOIN produtos p ON p.id = fp.produto_id WHERE fp.frete_id = ?');
$st->execute([$id]);
$itens = $st->fetchAll();
$pesoTotal  = array_sum(array_map(fn($i) => $i['peso'] * $i['quantidade'], $itens));
$valorTotal = array_sum(array_map(fn($i) => $i['valor'] * $i['quantidade'], $itens));

$titulo = "Frete #$id";
include __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="mb-0">Frete #<?= $id ?></h2>
  <div class="no-print"><button onclick="window.print()" class="btn btn-outline-secondary"><i class="bi bi-printer"></i> Imprimir</button>
    <a href="<?= url('fretes/index.php') ?>" class="btn btn-primary">Voltar</a></div>
</div>
<div class="card shadow-sm mb-4"><div class="card-body row g-3">
  <div class="col-md-3"><div class="text-muted small">Data</div><?= e(dataBR($f['data_frete'])) ?></div>
  <div class="col-md-3"><div class="text-muted small">Transportador</div><?= e($f['transportador']) ?></div>
  <div class="col-md-3"><div class="text-muted small">Origem</div><?= e($f['origem']) ?> (<?= e($f['origem_cidade']) ?>/<?= e($f['origem_uf']) ?>)</div>
  <div class="col-md-3"><div class="text-muted small">Destino</div><?= e($f['destino']) ?> (<?= e($f['destino_cidade']) ?>/<?= e($f['destino_uf']) ?>)</div>
  <div class="col-md-3"><div class="text-muted small">Valor do frete</div><?= e(money($f['valor_frete'])) ?></div>
  <div class="col-md-9"><div class="text-muted small">Observação</div><?= e($f['observacao'] ?: '—') ?></div>
</div></div>
<div class="card shadow-sm"><div class="card-header fw-semibold">Produtos</div><div class="card-body table-responsive">
<table class="table mb-0"><thead><tr><th>Produto</th><th>Qtd.</th><th>Peso unit.</th><th>Valor unit.</th><th>Subtotal</th></tr></thead><tbody>
<?php foreach ($itens as $i): ?>
  <tr><td><?= e($i['nome']) ?></td><td><?= (int)$i['quantidade'] ?></td><td><?= number_format($i['peso'], 2, ',', '.') ?> kg</td>
    <td><?= e(money($i['valor'])) ?></td><td><?= e(money($i['valor'] * $i['quantidade'])) ?></td></tr>
<?php endforeach; ?>
</tbody><tfoot><tr class="fw-bold"><td colspan="2">Totais</td><td><?= number_format($pesoTotal, 2, ',', '.') ?> kg</td><td></td><td><?= e(money($valorTotal)) ?></td></tr></tfoot></table>
</div></div>
<?php include __DIR__ . '/../includes/footer.php';
