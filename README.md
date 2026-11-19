# LogiFrete – Gerenciador Logístico em PHP

Projeto da **Atividade Prática Orientada (APO)** – Fundamentos de Programação para Internet (UNIPAR EAD).

Sistema web para cadastrar **produtos**, **endereços** (origem/destino) e **transportadores**, e gerar **fretes**
em que um único transportador leva vários produtos (relação 1 para muitos). Também gera o **relatório de fretes de um dia** (download em CSV).

## Tecnologias
- **Backend:** PHP 8 (PDO + SQLite)
- **Frontend:** HTML5, CSS3, JavaScript e **Bootstrap 5** (CDN)
- **Ambiente:** XAMPP (Apache + PHP)
- **Versionamento:** Git/GitHub

## Funcionalidades
- CRUD de produtos, endereços e transportadores (cadastro, edição, listagem e exclusão)
- Geração de frete com campos de produtos adicionados **dinamicamente via JavaScript**
- Detalhe do frete com totais de peso e valor (impressão)
- Relatório por dia, com download em CSV (abre no Excel) e impressão
- Menu de navegação, validações e máscaras de CEP/telefone

## Estrutura
Cada entidade tem sua própria pasta, e cada operação do CRUD é um arquivo (endpoint):
```
logistica-fretes/
├── index.php                 # painel inicial
├── produtos/                 # (o mesmo padrão vale para enderecos/ e transportadores/)
│   ├── index.php             # READ    – lista os registros
│   ├── form.php              # CREATE/UPDATE – formulário (novo ou ?id= para editar)
│   ├── salvar.php            # CREATE/UPDATE – grava no banco (INSERT/UPDATE)
│   └── excluir.php           # DELETE  – remove o registro
├── fretes/                   # index, novo, salvar, ver, excluir + consultas.php
├── relatorios/               # index.php (tela) e baixar.php (CSV)
├── config/bootstrap.php      # conexão, criação das tabelas e funções auxiliares
├── includes/                 # header.php e footer.php (menu e rodapé)
├── assets/css, assets/js     # estilos e scripts
├── data/                     # banco SQLite (gerado automaticamente)
└── docs/                     # telas (wireframes)
```

## Modelo de dados
`produtos`, `enderecos`, `transportadores`, `fretes` (origem, destino e transportador) e `frete_produtos` (itens do frete: N produtos por frete).

## Autor
Nome: Amanda Santos · RA: 09067557 · Curso: Análise e Desenvolvimento de Sistemas · Polo: EAD Toledo, PR