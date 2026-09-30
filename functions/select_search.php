<?php

require_once __DIR__ . "/../includes/connect.php";

$id_produtos = $_GET['id_produtos'] ?? '';

if ($id_produtos !== '') {

$search = "SELECT * FROM produtos WHERE id_produtos or nome = ?";

$stmt = $connect->prepare($search);
$stmt->bind_param("i", $id_produtos);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

$produto = $result->fetch_assoc();
}
?>
    <div class="vitrine-container">
                <?php for ($i = 0; $i < count($result); $i++) {?>
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

                <?php } ?>

            <p style="color: #fff; grid-column: 1/-1; text-align: center;">Nenhum produto encontrado.</p>

    </div>
<?php } ?>