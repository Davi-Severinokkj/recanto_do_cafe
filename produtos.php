<?php
include ("includes/head.php");
include ("includes/header.php");

try {
    $connect = new mysqli("localhost", "root", "Seemg@1222017", "recanto_do_cafe");
    $connect->set_charset("utf8");

    // 1. DEFINIÇÕES DA PAGINAÇÃO
    $itens_por_pagina = 6; // Altere aqui a quantidade de produtos por página
    $pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    if ($pagina_atual < 1) $pagina_atual = 1;

    // 2. BUSCAR O TOTAL DE PRODUTOS ATIVOS (Para saber quantas páginas existem)
    $total_result = $connect->query("SELECT COUNT(*) as total FROM produtos WHERE ativo = 1");
    $total_dados = $total_result->fetch_assoc();
    $total_produtos = $total_dados['total'];
    $total_paginas = ceil($total_produtos / $itens_por_pagina);

    // Impedir que o usuário acesse uma página maior do que o total existente
    if ($pagina_atual > $total_paginas && $total_paginas > 0) $pagina_atual = $total_paginas;

    // 3. CALCULAR O ÍNDICE DE INÍCIO (OFFSET)
    $inicio = ($pagina_atual - 1) * $itens_por_pagina;

    // 4. CONSULTA COM LIMIT E OFFSET
    $stmt = $connect->prepare("SELECT id_produtos, nome, preco, categoria, imagem, descricao FROM produtos WHERE ativo = 1 LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $itens_por_pagina, $inicio);
    $stmt->execute();
    $result = $stmt->get_result();

    $produtos = $result->fetch_all(MYSQLI_ASSOC);

} catch (Exception $e) {
    die("Erro ao conectar com o banco de dados: " . $e->getMessage());
}
?>

<style>
    /* Estilos Gerais */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #211408;
        margin: 0;
        padding: 0px;
    }

    main {
        padding: 20px;
    }

    h1 {
        text-align: center;
        color: #ffffff;
        margin-bottom: 30px;
    }

    /* Container do Grid de Produtos */
    .vitrine-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Card do Produto */
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

    /* Imagem do Produto */
    .produto-imagem {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background-color: #eaeaea;
    }

    /* Informações do Produto */
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

    /* Botão de Compra */
    .btn-comprar {
        background-color: #573315;
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
        background-color: #2980b9;
    }

    /* Container de Paginação Isolado do Grid */
    .paginacao-wrapper {
        width: 100%;
        grid-column: 1 / -1; /* Força a paginação a ocupar a largura total no grid */
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }

    .paginacao {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
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
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .paginacao a.ativo {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
        font-weight: bold;
        pointer-events: none; /* Desativa o clique na página já ativa */
    }

    .paginacao a.desativado {
        color: #ccc;
        background-color: #f5f5f5;
        border-color: #ddd;
        pointer-events: none; /* Desativa os cliques nos botões Anterior/Próximo inválidos */
    }
</style>

<body>

<main>
    <h1>Nossos Produtos</h1>

    <div class="vitrine-container">

        <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $item): ?>
                <div class="produto-card">
                    <img src="<?= htmlspecialchars($item['imagem']);?>" alt="<?= htmlspecialchars($item['nome']) ?>" class="produto-imagem">
                    <div class="produto-info">
                        <span class="produto-categoria"><?= htmlspecialchars($item['categoria']) ?></span>
                        <h3 class="produto-nome"><?= htmlspecialchars($item['nome']) ?></h3>
                        <div class="produto-preco">
                            R$ <?= number_format($item['preco'], 2, ',', '.') ?>
                        </div>
                        <button class="btn-comprar">Adicionar ao Carrinho</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: #fff; grid-column: 1/-1; text-align: center;">Nenhum produto encontrado.</p>
        <?php endif; ?>

        <!-- Bloco de navegação da paginação dinâmica -->
        <?php if ($total_paginas > 1): ?>
            <div class="paginacao-wrapper">
                <nav class="paginacao">
                    <!-- Botão Anterior -->
                    <?php if ($pagina_atual > 1): ?>
                        <a href="?pagina=<?= $pagina_atual - 1 ?>" class="botao anterior">&laquo; Anterior</a>
                    <?php else: ?>
                        <a href="#" class="botao anterior desativado">&laquo; Anterior</a>
                    <?php endif; ?>

                    <!-- Números das Páginas -->
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <a href="?pagina=<?= $i ?>" class="numero <?= $i === $pagina_atual ? 'ativo' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <!-- Botão Próxima -->
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

</body>