<?php
session_start();

$nome = "";
$senha = "";
$email = "";
$telefone = "";

$nome_err = "";
$senha_err = "";
$email_err = "";
$telefone_err = "";

include("includes/head.php");
?>


<body>
    <?php include_once("includes/header.php"); ?>

    <main>

        <div class="form_content">

            <form action="form_register_output.php " method="post">

                Nome completo:<br>
                <input type="text" name="nome" value="<?= htmlspecialchars($nome) ?>">
                <span>* <?= $nome_err ?></span>
                <br>

                Senha:<br>
                <input type="password" name="password">
                <span>* <?= $senha_err ?></span>
                <br>

                E-mail:<br>
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">
                <span><?= $email_err ?></span>
                <br>

                Telefone:<br>
                <input type="text" name="telefone" value="<?= htmlspecialchars($telefone) ?>">
                <span><?= $telefone_err ?></span>
                <br>

                <input type="submit" value="Enviar">

            </form>

        </div>

    </main>

    <?php
    include("includes/footer.php");
    ?>
    <script src="assets/scripts/script.js"></script>
</body>

</html>