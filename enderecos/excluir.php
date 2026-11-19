<?php
require __DIR__ . '/../config/bootstrap.php';

// DELETE: remove o registro (só aceita POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db()->prepare('DELETE FROM enderecos WHERE id = ?')->execute([(int)($_POST['id'] ?? 0)]);
        flash('success', 'Endereço excluído com sucesso.');
    } catch (PDOException $ex) {
        flash('danger', 'Não é possível excluir: o endereço está em um frete.');
    }
}
redirect('enderecos/index.php');
