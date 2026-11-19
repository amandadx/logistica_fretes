<?php
$menu = ['inicio' => ['Início', 'index.php'], 'produtos' => ['Produtos', 'produtos/index.php'],
         'enderecos' => ['Endereços', 'enderecos/index.php'], 'transportadores' => ['Transportadores', 'transportadores/index.php'],
         'fretes' => ['Fretes', 'fretes/index.php'], 'relatorios' => ['Relatório', 'relatorios/index.php']];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($titulo ?? 'Gerenciador Logístico') ?> · LogiFrete</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="<?= url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="<?= url('index.php') ?>"><i class="bi bi-truck"></i> LogiFrete</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto">
        <?php foreach ($menu as $secao => [$nome, $link]): ?>
          <li class="nav-item"><a class="nav-link <?= SECAO === $secao ? 'active' : '' ?>" href="<?= url($link) ?>"><?= $nome ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</nav>
<main class="container pb-5">
<?php if (!empty($_SESSION['flash'])): [$t, $m] = $_SESSION['flash']; unset($_SESSION['flash']); ?>
  <div class="alert alert-<?= e($t) ?> alert-dismissible fade show"><?= e($m) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>
