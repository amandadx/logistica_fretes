<?php
// Consulta compartilhada por fretes/ e relatorios/
function fretesComDados(string $where = '', array $params = []): array {
    $sql = "SELECT f.*, o.apelido AS origem, o.cidade AS origem_cidade, o.uf AS origem_uf,
                   d.apelido AS destino, d.cidade AS destino_cidade, d.uf AS destino_uf,
                   t.nome AS transportador,
                   (SELECT COUNT(*) FROM frete_produtos fp WHERE fp.frete_id = f.id) AS itens
            FROM fretes f
            JOIN enderecos o ON o.id = f.origem_id
            JOIN enderecos d ON d.id = f.destino_id
            JOIN transportadores t ON t.id = f.transportador_id
            $where ORDER BY f.data_frete DESC, f.id DESC";
    $st = db()->prepare($sql);
    $st->execute($params);
    return $st->fetchAll();
}
