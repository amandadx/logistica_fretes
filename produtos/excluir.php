<?php
require __DIR__ . '/../config/bootstrap.php';

// DELETE: remove o registro (só aceita POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db()->prepare('DELETE FROM produtos WHERE id = ?')->execute([(int)($_POST['id'] ?? 0)]);
        flash('success', 'Produto excluído com sucesso.');
    } catch (PDOException $ex) {
        flash('danger', 'Não é possível excluir: o produto está em um frete.');
    }
}
redirect('produtos/index.php');
