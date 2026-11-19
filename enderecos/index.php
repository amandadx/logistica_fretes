<?php
require __DIR__ . '/../config/bootstrap.php';

// READ: lista todos os registros da tabela enderecos
$lista = db()->query('SELECT * FROM enderecos ORDER BY id DESC')->fetchAll();

$titulo = 'Endereços';
include __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="mb-0"><i class="bi bi-geo-alt"></i> Endereços</h2>
  <a href="<?= url('enderecos/form.php') ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Novo endereço</a>
</div>
<div class="card shadow-sm"><div class="card-body table-responsive">
<table class="table table-hover align-middle mb-0">
  <thead><tr><th>#</th><th>Identificação</th><th>Logradouro</th><th>Cidade</th><th>UF</th><th class="text-end">Ações</th></tr></thead>
  <tbody>
  <?php foreach ($lista as $r): ?>
    <tr><td><?= (int)$r['id'] ?></td>
      <td><?= e($r['apelido']) ?></td>
      <td><?= e($r['logradouro']) ?></td>
      <td><?= e($r['cidade']) ?></td>
      <td><?= e($r['uf']) ?></td>
      <td class="text-end text-nowrap">
        <a class="btn btn-sm btn-outline-primary" href="<?= url('enderecos/form.php?id=' . (int)$r['id']) ?>" title="Editar"><i class="bi bi-pencil"></i></a>
        <form method="post" action="<?= url('enderecos/excluir.php') ?>" class="d-inline" onsubmit="return confirm('Excluir este registro?')">
          <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
          <button class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></button>
        </form>
      </td></tr>
  <?php endforeach; if (!$lista): ?>
    <tr><td colspan="6" class="text-center text-muted py-4">Nenhum registro cadastrado.</td></tr>
  <?php endif; ?>
  </tbody>
</table></div></div>
<?php include __DIR__ . '/../includes/footer.php';
