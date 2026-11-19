<?php
require __DIR__ . '/../config/bootstrap.php';

// CREATE / UPDATE (tela): se vier ?id= carrega o registro para EDITAR; sem id, é um cadastro novo
$edit = null;
if (!empty($_GET['id'])) {
    $st = db()->prepare('SELECT * FROM transportadores WHERE id = ?');
    $st->execute([(int)$_GET['id']]);
    $edit = $st->fetch() ?: null;
}

$titulo = $edit ? 'Editar transportador' : 'Novo transportador';
include __DIR__ . '/../includes/header.php';
?>
<h2 class="mb-3"><i class="bi bi-person-badge"></i> <?= e($titulo) ?></h2>
<div class="card shadow-sm" style="max-width: 640px"><div class="card-body">
  <form method="post" action="<?= url('transportadores/salvar.php') ?>" autocomplete="off">
    <input type="hidden" name="id" value="<?= e($edit['id'] ?? '') ?>">
    <div class="mb-3"><label class="form-label">Nome / Razão social *</label>
      <input class="form-control" name="nome" value="<?= e($edit['nome'] ?? '') ?>" required></div>
    <div class="mb-3"><label class="form-label">CPF / CNPJ</label>
      <input class="form-control" name="documento" value="<?= e($edit['documento'] ?? '') ?>" ></div>
    <div class="mb-3"><label class="form-label">Telefone</label>
      <input class="form-control" name="telefone" value="<?= e($edit['telefone'] ?? '') ?>" data-mask="tel"></div>
    <div class="mb-3"><label class="form-label">Placa do veículo</label>
      <input class="form-control" name="placa" value="<?= e($edit['placa'] ?? '') ?>" ></div>
    <button class="btn btn-primary"><i class="bi bi-check2"></i> Salvar</button>
    <a class="btn btn-outline-secondary" href="<?= url('transportadores/index.php') ?>">Cancelar</a>
  </form>
</div></div>
<?php include __DIR__ . '/../includes/footer.php';
