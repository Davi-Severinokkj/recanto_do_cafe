<?php
session_start();

$produtos = [];
$termo_busca = trim($_GET['id_produtos'] ?? '');
$categoria = $_GET['categoria'] ?? '';

try {

    // 1. Inclui a conexão com o banco de dados
    require_once("includes/connect.php");

    // 2. Consulta inicial: somente produtos ativos
    $sql = "SELECT id_produtos, nome, preco, categoria, imagem, descricao
            FROM produtos
            WHERE ativo = 1";

    $condicoes = [];
    $parametros = [];
    $tipos = "";

    // 3. Filtro pelo nome do produto
    if ($termo_busca !== '') {

        $condicoes[] = "nome LIKE ?";
        $parametros[] = "%" . $termo_busca . "%";
        $tipos .= "s";
    }


    // Filtro pela categoria
    if ($categoria !== '') {

        $condicoes[] = "categoria = ?";
        $parametros[] = $categoria;
        $tipos .= "s";
    }


    // 5. Adiciona os filtros à consulta
    if (!empty($condicoes)) {

        $sql .= " AND " . implode(" AND ", $condicoes);
    }

    // 6. Organiza os resultados
    $sql .= " ORDER BY id_produtos DESC";

    // 7. Prepara a consulta
    $stmt = $connect->prepare($sql);

    // 8. Associa os parâmetros, caso existam
    if (!empty($parametros)) {

        $stmt->bind_param($tipos, ...$parametros);
    }

    // 9. Executa a consulta
    $stmt->execute();

    // 10. Recupera todos os produtos encontrados
    $result = $stmt->get_result();

    $produtos = $result->fetch_all(MYSQLI_ASSOC);

    // 11. Libera os recursos
    $stmt->close();
} catch (Throwable $e) {

    die("<p style='color: white;'>Erro ao consultar os produtos: "
        . htmlspecialchars($e->getMessage())
        . "</p>");
}

// Inclui o cabeçalho da página
include("includes/head.php");

?>

<!DOCTYPE html>
<html lang="pt-BR">

<link rel="stylesheet" href="assets/styles/produtos.css">
<title>Recanto do Café - Produtos</title>

<body>

    <?php include_once("includes/header.php"); ?>

    <main>




        <section class="filtros-produtos">

            <form action="produtos.php" method="GET" class="form-filtros">

                <!-- PESQUISA -->
                <div class="filtro-box">

                    <label for="id_produtos" class="filtro-label">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Pesquisar produto
                    </label>

                    <div class="pesquisa-campo">

                        <input
                            type="text"
                            name="id_produtos"
                            id="id_produtos"
                            placeholder="Digite o nome do produto..."
                            value="<?= htmlspecialchars($termo_busca) ?>">

                        <button type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            Pesquisar
                        </button>

                    </div>

                </div>

                <!-- CATEGORIAS -->
                <div class="filtro-box">

                    <span class="filtro-label">
                        <i class="fa-solid fa-layer-group"></i>
                        Filtrar por categoria
                    </span>

                    <div class="categorias-wrapper">

                        <div class="categorias-botoes">

                            <button type="submit" name="categoria" value=""
                                class="categoria-btn">
                                Todas
                            </button>

                            <button type="submit" name="categoria" value="Cafés"
                                class="categoria-btn">
                                Cafés
                            </button>

                            <button type="submit" name="categoria" value="Bebidas Geladas"
                                class="categoria-btn">
                                Bebidas Geladas
                            </button>

                            <button type="submit" name="categoria" value="Bebidas Quentes"
                                class="categoria-btn">
                                Bebidas Quentes
                            </button>

                            <button type="submit" name="categoria" value="Chás"
                                class="categoria-btn">
                                Chás
                            </button>

                            <button type="submit" name="categoria" value="Sucos"
                                class="categoria-btn">
                                Sucos
                            </button>

                            <button type="submit" name="categoria" value="Vitaminas"
                                class="categoria-btn">
                                Vitaminas
                            </button>

                            <button type="submit" name="categoria" value="Salgados"
                                class="categoria-btn">
                                Salgados
                            </button>

                            <button type="submit" name="categoria" value="Sanduíches"
                                class="categoria-btn">
                                Sanduíches
                            </button>

                            <button type="submit" name="categoria" value="Café da Manhã"
                                class="categoria-btn">
                                Café da Manhã
                            </button>

                            <button type="submit" name="categoria" value="Combos"
                                class="categoria-btn">
                                Combos
                            </button>

                            <button type="submit" name="categoria" value="Bolos"
                                class="categoria-btn">
                                Bolos
                            </button>

                            <button type="submit" name="categoria" value="Sobremesas"
                                class="categoria-btn">
                                Sobremesas
                            </button>

                            <button type="submit" name="categoria" value="Doces"
                                class="categoria-btn">
                                Doces
                            </button>

                            <button type="submit" name="categoria" value="Bebidas"
                                class="categoria-btn">
                                Bebidas
                            </button>

                            <button type="submit" name="categoria" value="Produtos de Café"
                                class="categoria-btn">
                                Produtos de Café
                            </button>

                            <button type="submit" name="categoria" value="Produtos"
                                class="categoria-btn">
                                Produtos
                            </button>

                        </div>

                    </div>

                </div>

            </form>

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
        </div>
    </main>

    <?php require __DIR__ . "/includes/footer.php"; ?>
    <script src="assets/scripts/script.js"></script>
</body>

</html>