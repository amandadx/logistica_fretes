<?php
require __DIR__ . '/../config/bootstrap.php';

// DELETE: remove o frete (os itens em frete_produtos saem junto, por ON DELETE CASCADE)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    db()->prepare('DELETE FROM fretes WHERE id = ?')->execute([(int)($_POST['id'] ?? 0)]);
    flash('success', 'Frete excluído com sucesso.');
}
redirect('fretes/index.php');
