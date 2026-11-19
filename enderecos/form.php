<?php
require __DIR__ . '/../config/bootstrap.php';

// CREATE / UPDATE (tela): se vier ?id= carrega o registro para EDITAR; sem id, é um cadastro novo
$edit = null;
if (!empty($_GET['id'])) {
    $st = db()->prepare('SELECT * FROM enderecos WHERE id = ?');
    $st->execute([(int)$_GET['id']]);
    $edit = $st->fetch() ?: null;
}

$titulo = $edit ? 'Editar endereço' : 'Novo endereço';
include __DIR__ . '/../includes/header.php';
?>
<h2 class="mb-3"><i class="bi bi-geo-alt"></i> <?= e($titulo) ?></h2>
<div class="card shadow-sm" style="max-width: 640px"><div class="card-body">
  <form method="post" action="<?= url('enderecos/salvar.php') ?>" autocomplete="off">
    <input type="hidden" name="id" value="<?= e($edit['id'] ?? '') ?>">
    <div class="mb-3"><label class="form-label">Identificação (ex.: Depósito Central) *</label>
      <input class="form-control" name="apelido" value="<?= e($edit['apelido'] ?? '') ?>" required></div>
    <div class="mb-3"><label class="form-label">Logradouro *</label>
      <input class="form-control" name="logradouro" value="<?= e($edit['logradouro'] ?? '') ?>" required></div>
    <div class="mb-3"><label class="form-label">Número</label>
      <input class="form-control" name="numero" value="<?= e($edit['numero'] ?? '') ?>" ></div>
    <div class="mb-3"><label class="form-label">Bairro</label>
      <input class="form-control" name="bairro" value="<?= e($edit['bairro'] ?? '') ?>" ></div>
    <div class="mb-3"><label class="form-label">Cidade *</label>
      <input class="form-control" name="cidade" value="<?= e($edit['cidade'] ?? '') ?>" required></div>
    <div class="mb-3"><label class="form-label">UF *</label>
      <input class="form-control" name="uf" value="<?= e($edit['uf'] ?? '') ?>" maxlength="2" required></div>
    <div class="mb-3"><label class="form-label">CEP</label>
      <input class="form-control" name="cep" value="<?= e($edit['cep'] ?? '') ?>" data-mask="cep"></div>
    <button class="btn btn-primary"><i class="bi bi-check2"></i> Salvar</button>
    <a class="btn btn-outline-secondary" href="<?= url('enderecos/index.php') ?>">Cancelar</a>
  </form>
</div></div>
<?php include __DIR__ . '/../includes/footer.php';
