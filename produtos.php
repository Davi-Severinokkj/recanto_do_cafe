<?php
include("includes/head.php");

$termo_busca = $_GET['id_produtos'] ?? '';

try {
    $connect = new mysqli("localhost", "root", "Seemg@1222017", "recanto_do_cafe");
    $connect->set_charset("utf8");

    $produtos = [];
    $total_paginas = 0;

    if ($termo_busca === '') {
        $itens_por_pagina = 8;
        $pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($pagina_atual < 1) $pagina_atual = 1;

        $total_result = $connect->query("SELECT COUNT(*) as total FROM produtos WHERE ativo = 1");
        $total_dados = $total_result->fetch_assoc();
        $total_produtos = $total_dados['total'];
        $total_paginas = ceil($total_produtos / $itens_por_pagina);

        if ($pagina_atual > $total_paginas && $total_paginas > 0) $pagina_atual = $total_paginas;

        $inicio = ($pagina_atual - 1) * $itens_por_pagina;

        $stmt = $connect->prepare("SELECT id_produtos, nome, preco, categoria, imagem, descricao FROM produtos WHERE ativo = 1 LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $itens_por_pagina, $inicio);
        $stmt->execute();
        $result = $stmt->get_result();

        $produtos = $result->fetch_all(MYSQLI_ASSOC);
    }

} catch (Exception $e) {
    die("Erro ao conectar com o banco de dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recanto do Café - Produtos</title>

    <style>
        /* =========================================================
           VARIÁVEIS LOCAIS E AJUSTES DE TEMA
           ========================================================= */
        :root {
            --marrom-escuro: #211408;
            --marrom: #412c16;
            --marrom-medio: #5a3518;
            --dourado: #d9a15d;
            --dourado-claro: #f0c98f;
            --creme: #f7e8d2;
            --creme-claro: #fffaf3;
            --branco: #ffffff;
            --texto: #2d2117;
            --texto-claro: #6f6256;
            --borda: rgba(65, 44, 22, .12);
            --sombra: 0 15px 40px rgba(33, 20, 8, .12);
            --sombra-forte: 0 20px 50px rgba(33, 20, 8, .20);
            --transicao: .3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--marrom-escuro);
            color: var(--branco);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            padding: 20px;
            flex: 1;
        }

        h1.titulo-pagina {
            text-align: center;
            color: var(--branco);
            margin-bottom: 30px;
            font-size: 2rem;
        }

        /* BARRA DE PESQUISA */
        .search_container {
            max-width: 600px;
            margin: 0 auto 30px auto;
            display: flex;
            align-items: center;
            background-color: #fff;
            padding: 8px 15px;
            border-radius: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .search_container i {
            color: #888;
            margin-right: 10px;
        }

        .search_container form {
            display: flex;
            width: 100%;
            gap: 10px;
        }

        .search_container input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 0.95rem;
            color: #333;
        }

        .search_container button {
            background-color: var(--marrom-medio);
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .search_container button:hover {
            background-color: var(--dourado);
            color: var(--marrom-escuro);
        }

        /* GRID DE PRODUTOS */
        .vitrine-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* CARD DE PRODUTO */
        .produto-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s;
        }

        .produto-card:hover {
            transform: translateY(-5px);
        }

        .produto-imagem {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: #eaeaea;
        }

        .produto-info {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .produto-categoria {
            font-size: 0.8rem;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .produto-nome {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin: 0 0 10px 0;
        }

        .produto-preco {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2ecc71;
            margin-top: auto;
            margin-bottom: 15px;
        }

        .btn-comprar {
            background-color: var(--marrom-medio);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            font-weight: 600;
            text-align: center;
            transition: background-color 0.2s;
        }

        .btn-comprar:hover {
            background-color: var(--dourado);
            color: var(--marrom-escuro);
        }

        /* PAGINAÇÃO ISOLADA */
        .paginacao-wrapper {
            width: 100%;
            grid-column: 1 / -1;
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .paginacao {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .paginacao a {
            color: #333;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 8px 14px;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-size: 14px;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        .paginacao a:hover {
            background-color: var(--dourado);
            color: var(--marrom-escuro);
            border-color: var(--dourado);
        }

        .paginacao a.pag-ativo {
            background-color: var(--dourado);
            color: var(--marrom-escuro);
            border-color: var(--dourado);
            font-weight: bold;
            pointer-events: none;
        }

        .paginacao a.desativado {
            color: #ccc;
            background-color: #f5f5f5;
            border-color: #ddd;
            pointer-events: none;
        }

        /* ==========================================
           RESPONSIVIDADE (MEDIA QUERIES)
           ========================================== */

        @media (max-width: 768px) {
            main {
                padding: 15px;
            }

            h1.titulo-pagina {
                font-size: 1.6rem;
                margin-bottom: 20px;
            }

            .vitrine-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .produto-imagem {
                height: 180px;
            }

            .paginacao-wrapper {
                margin-top: 30px;
            }

            .paginacao a {
                padding: 7px 12px;
                font-size: 13px;
            }
        }

        @media (max-width: 425px) {
            main {
                padding: 10px;
            }

            h1.titulo-pagina {
                font-size: 1.4rem;
                margin-bottom: 15px;
            }

            .vitrine-container {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .produto-imagem {
                height: 200px;
            }

            .produto-info {
                padding: 12px;
            }

            .paginacao {
                gap: 5px;
            }

            .paginacao a {
                padding: 6px 10px;
                font-size: 12px;
            }

            .search_container {
                flex-direction: column;
                border-radius: 12px;
            }

            .search_container form {
                flex-direction: column;
            }

            .search_container button {
                width: 100%;
            }
        }

        @media (max-width: 375px) {
            h1.titulo-pagina {
                font-size: 1.25rem;
            }

            .produto-nome {
                font-size: 1rem;
            }

            .produto-preco {
                font-size: 1.15rem;
            }

            .btn-comprar {
                padding: 8px;
                font-size: 0.9rem;
            }

            .paginacao a {
                padding: 5px 8px;
                font-size: 11px;
            }
        }

        @media (max-width: 320px) {
            main {
                padding: 8px;
            }

            h1.titulo-pagina {
                font-size: 1.1rem;
            }

            .produto-imagem {
                height: 160px;
            }

            .produto-info {
                padding: 10px;
            }

            .paginacao {
                gap: 3px;
            }

            .paginacao a {
                padding: 4px 6px;
                font-size: 10px;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <a href="index.php">
            <img src="img/logo.png" alt="Recanto do Café">
        </a>
    </div>

    <div class="nav">
        <nav>
            <ul>
                <li><a href="servicos.html">Serviços</a></li>
                <li><a href="suporte.php">Suporte</a></li>
                <li><a href="sobre.html">Sobre nós</a></li>
                <li><a href="clientes.html">Clientes</a></li>
            </ul>
        </nav>
    </div>

    <div class="form">
        <button><a href="form_login.php">Login</a></button>
        <button><a href="form_register.php">Registre-se</a></button>
    </div>

    <div class="modal">
        <button class="menu-btn">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <div class="menuDropDown">
        <nav>
            <ul>
                <li><a href="suporte.php">Suporte</a></li>
                <li><a href="servicos.html">Serviços</a></li>
                <li><a href="sobre.html">Sobre nós</a></li>
                <li><a href="clientes.html">Clientes</a></li>
            </ul>
        </nav>

        <div class="form">
            <button><a href="form_login.php">Login</a></button>
            <button><a href="form_register.php">Registre-se</a></button>
        </div>
    </div>
</header>

<main>
    <section>
        <div class="search_container">
            <i class="fa-solid fa-magnifying-glass"></i>
            <form action="produtos.php" method="GET">
                <input type="text" name="id_produtos" id="id_produtos" placeholder="Pesquisar..."
                       value="<?= htmlspecialchars($termo_busca) ?>">
                <button type="submit">Pesquisar</button>
            </form>
        </div>
    </section>

    <h1 class="titulo-pagina">Nossos Produtos</h1>

    <div class="vitrine-container">
        <?php
        if ($termo_busca !== '') {
            include("functions/select_search.php");
        } else if (!empty($produtos)) {
            foreach ($produtos as $item): ?>
                <div class="produto-card">
                    <img src="<?= htmlspecialchars($item['imagem']); ?>" alt="<?= htmlspecialchars($item['nome']) ?>"
                         class="produto-imagem">
                    <div class="produto-info">
                        <span class="produto-categoria"><?= htmlspecialchars($item['categoria']) ?></span>
                        <h3 class="produto-nome"><?= htmlspecialchars($item['nome']) ?></h3>
                        <div class="produto-preco">
                            R$ <?= number_format($item['preco'], 2, ',', '.') ?>
                        </div>
                        <button class="btn-comprar">Adicionar ao Carrinho</button>
                    </div>
                </div>
            <?php endforeach;
        } else { ?>
            <p style="color: #fff; grid-column: 1/-1; text-align: center;">Nenhum produto encontrado.</p>
        <?php } ?>

        <?php if ($termo_busca === '' && $total_paginas > 1): ?>
            <div class="paginacao-wrapper">
                <nav class="paginacao">
                    <?php if ($pagina_atual > 1): ?>
                        <a href="?pagina=<?= $pagina_atual - 1 ?>" class="botao anterior">&laquo; Anterior</a>
                    <?php else: ?>
                        <a href="#" class="botao anterior desativado">&laquo; Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <a href="?pagina=<?= $i ?>" class="num-pag <?= $i === $pagina_atual ? 'pag-ativo' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($pagina_atual < $total_paginas): ?>
                        <a href="?pagina=<?= $pagina_atual + 1 ?>" class="botao proximo">Próxima &raquo;</a>
                    <?php else: ?>
                        <a href="#" class="botao proximo desativado">Próxima &raquo;</a>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require __DIR__ . "/includes/footer.php"; ?>
<script src="assets/scripts/script.js"></script>
</body>
</html>