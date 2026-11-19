<?php
// Inicialização: sessão, conexão com o banco (SQLite via PDO) e funções auxiliares.
session_start();

// Descobre a URL base do projeto (funciona em /logistica-fretes/ ou na raiz) e a pasta (seção) atual
$__raiz = str_replace('\\', '/', realpath(__DIR__ . '/..'));
$__arq  = str_replace('\\', '/', realpath($_SERVER['SCRIPT_FILENAME']));
$__rel  = ltrim(substr($__arq, strlen($__raiz)), '/');          // ex.: produtos/index.php
$__prof = substr_count($__rel, '/');                             // profundidade da pasta
define('SECAO', $__prof ? explode('/', $__rel)[0] : 'inicio');   // ex.: produtos
define('BASE', rtrim(dirname($_SERVER['SCRIPT_NAME'], $__prof + 1), '/\\'));
function url(string $caminho): string { return BASE . '/' . ltrim($caminho, '/'); }

function db(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;
    $dir = __DIR__ . '/../data';
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $pdo = new PDO('sqlite:' . $dir . '/logistica.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('PRAGMA foreign_keys = ON');
    $pdo->exec("
      CREATE TABLE IF NOT EXISTS produtos (
        id INTEGER PRIMARY KEY AUTOINCREMENT, nome TEXT NOT NULL, descricao TEXT,
        peso REAL NOT NULL DEFAULT 0, valor REAL NOT NULL DEFAULT 0);
      CREATE TABLE IF NOT EXISTS enderecos (
        id INTEGER PRIMARY KEY AUTOINCREMENT, apelido TEXT NOT NULL, logradouro TEXT NOT NULL,
        numero TEXT, bairro TEXT, cidade TEXT NOT NULL, uf TEXT NOT NULL, cep TEXT);
      CREATE TABLE IF NOT EXISTS transportadores (
        id INTEGER PRIMARY KEY AUTOINCREMENT, nome TEXT NOT NULL, documento TEXT,
        telefone TEXT, placa TEXT);
      CREATE TABLE IF NOT EXISTS fretes (
        id INTEGER PRIMARY KEY AUTOINCREMENT, data_frete TEXT NOT NULL,
        origem_id INTEGER NOT NULL REFERENCES enderecos(id),
        destino_id INTEGER NOT NULL REFERENCES enderecos(id),
        transportador_id INTEGER NOT NULL REFERENCES transportadores(id),
        valor_frete REAL NOT NULL DEFAULT 0, observacao TEXT);
      CREATE TABLE IF NOT EXISTS frete_produtos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        frete_id INTEGER NOT NULL REFERENCES fretes(id) ON DELETE CASCADE,
        produto_id INTEGER NOT NULL REFERENCES produtos(id),
        quantidade INTEGER NOT NULL DEFAULT 1);
    ");
    return $pdo;
}

function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function money($v): string { return 'R$ ' . number_format((float)$v, 2, ',', '.'); }
function dataBR(string $d): string { return date('d/m/Y', strtotime($d)); }
function flash(string $tipo, string $msg): void { $_SESSION['flash'] = [$tipo, $msg]; }
function redirect(string $caminho): void { header('Location: ' . url($caminho)); exit; }

