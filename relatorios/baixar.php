<?php
require __DIR__ . '/../config/bootstrap.php';
require __DIR__ . '/../fretes/consultas.php';

// Download do relatório do dia em CSV (abre direto no Excel)
$dia = $_GET['dia'] ?? date('Y-m-d');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dia)) $dia = date('Y-m-d');
$fretes = fretesComDados('WHERE f.data_frete = ?', [$dia]);

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="relatorio-fretes-' . $dia . '.csv"');
$out = fopen('php://output', 'w');
fwrite($out, "\xEF\xBB\xBF");   // BOM para o Excel entender os acentos
fputcsv($out, ['Frete', 'Data', 'Origem', 'Destino', 'Transportador', 'Produtos', 'Valor do frete'], ';');

$total = 0;
$st = db()->prepare('SELECT p.nome, fp.quantidade FROM frete_produtos fp JOIN produtos p ON p.id = fp.produto_id WHERE fp.frete_id = ?');
foreach ($fretes as $f) {
    $st->execute([$f['id']]);
    $prod = implode(', ', array_map(fn($i) => $i['nome'] . ' (x' . $i['quantidade'] . ')', $st->fetchAll()));
    fputcsv($out, [$f['id'], dataBR($f['data_frete']),
        $f['origem'] . ' - ' . $f['origem_cidade'] . '/' . $f['origem_uf'],
        $f['destino'] . ' - ' . $f['destino_cidade'] . '/' . $f['destino_uf'],
        $f['transportador'], $prod, number_format($f['valor_frete'], 2, ',', '.')], ';');
    $total += $f['valor_frete'];
}
fputcsv($out, ['', '', '', '', '', 'TOTAL', number_format($total, 2, ',', '.')], ';');
fclose($out);
