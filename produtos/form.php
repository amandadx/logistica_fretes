<?php
require __DIR__ . '/../config/bootstrap.php';

// CREATE / UPDATE (tela): se vier ?id= carrega o registro para EDITAR; sem id, é um cadastro novo
$edit = null;
if (!empty($_GET['id'])) {
    $st = db()->prepare('SELECT * FROM produtos WHERE id = ?');
    $st->execute([(int)$_GET['id']]);
    $edit = $st->fetch() ?: null;
}

$titulo = $edit ? 'Editar produto' : 'Novo produto';
include __DIR__ . '/../includes/header.php';
?>
<h2 class="mb-3"><i class="bi bi-box-seam"></i> <?= e($titulo) ?></h2>
<div class="card shadow-sm" style="max-width: 640px"><div class="card-body">
  <form method="post" action="<?= url('produtos/salvar.php') ?>" autocomplete="off">
    <input type="hidden" name="id" value="<?= e($edit['id'] ?? '') ?>">
    <div class="mb-3"><label class="form-label">Nome *</label>
      <input class="form-control" name="nome" value="<?= e($edit['nome'] ?? '') ?>" required></div>
    <div class="mb-3"><label class="form-label">Descrição</label>
      <input class="form-control" name="descricao" value="<?= e($edit['descricao'] ?? '') ?>" ></div>
    <div class="mb-3"><label class="form-label">Peso (kg) *</label>
      <input class="form-control" name="peso" value="<?= e($edit['peso'] ?? '') ?>" type="number" step="0.01" min="0" required></div>
    <div class="mb-3"><label class="form-label">Valor (R$) *</label>
      <input class="form-control" name="valor" value="<?= e($edit['valor'] ?? '') ?>" type="number" step="0.01" min="0" required></div>
    <button class="btn btn-primary"><i class="bi bi-check2"></i> Salvar</button>
    <a class="btn btn-outline-secondary" href="<?= url('produtos/index.php') ?>">Cancelar</a>
  </form>
</div></div>
<?php include __DIR__ . '/../includes/footer.php';
