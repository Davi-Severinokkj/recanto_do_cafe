<?php
require_once __DIR__ . "/../includes/connect.php";

$id_produtos = $_GET['id_produtos'] ?? '';

if ($id_produtos !== '') {
    // Usamos LIKE para pesquisar no nome ou ID
    $search = "SELECT * FROM produtos WHERE (id_produtos = ? OR nome LIKE ?) AND ativo = 1";
    $param_nome = "%" . $id_produtos . "%";

    $stmt = $connect->prepare($search);
    $stmt->bind_param("ss", $id_produtos, $param_nome);
    $stmt->execute();

    $result = $stmt->get_result();
    $produtos_busca = $result->fetch_all(MYSQLI_ASSOC);

    if (!empty($produtos_busca)) {
        foreach ($produtos_busca as $item) { ?>
            <div class="produto-card">
                <img src="<?= htmlspecialchars($item['imagem']); ?>" alt="<?= htmlspecialchars($item['nome']) ?>" class="produto-imagem">
                <div class="produto-info">
                    <span class="produto-categoria"><?= htmlspecialchars($item['categoria']) ?></span>
                    <h3 class="produto-nome"><?= htmlspecialchars($item['nome']) ?></h3>
                    <div class="produto-preco">
                        R$ <?= number_format($item['preco'], 2, ',', '.') ?>
                    </div>
                    <button class="btn-comprar">Adicionar ao Carrinho</button>
                </div>
            </div>
        <?php }
    } else { ?>
        <p style="color: #fff; grid-column: 1/-1; text-align: center;">Nenhum produto encontrado para a busca.</p>
    <?php }
}
?>