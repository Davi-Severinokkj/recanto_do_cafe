<!DOCTYPE html>
<html lang="pt-br">

<?php include("includes/head.php"); ?>

<body>
<div class="container">
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
                    <li><a href="sobre.html">Sobre nós</a></li>
                    <li><a href="clientes.html">Clientes</a></li>
                </ul>
            </nav>
        </div>


        <div class="form">
            <button>
                <a href="form_login.php">Login</a>
            </button>
            <button>
                <a href="form_register.php">Registre-se</a>
            </button>
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
                <button>
                    <a href="form_login.php">Login</a>
                </button>
                <button>
                    <a href="form_register.php">Registre-se</a>
                </button>
            </div>
        </div>
    </header>

    <div class="section-titulo-paginas">
        <h1>Central de Atendimento</h1>
        <p>Dúvidas, feedbacks ou solicitações especiais? Estamos aqui para ouvir você.</p>
    </div>

    <section class="suporte-conteudo">

        <div class="suporte-esquerda">

                <span class="tag">
                    ☕ Estamos aqui para ajudar
                </span>

            <h1>Entre em contato com o Recanto do Café</h1>

            <p>
                Nossa equipe está pronta para atender você. Tire dúvidas,
                faça sugestões ou entre em contato através dos nossos canais
                oficiais.
            </p>

            <div class="contatos">

                <div class="contato-item">
                    <i class="fa-solid fa-phone"></i>

                    <div>
                        <h3>Telefone</h3>
                        <span>(31) 99999-9999</span>
                    </div>
                </div>

                <div class="contato-item">
                    <i class="fa-solid fa-envelope"></i>

                    <div>
                        <h3>E-mail</h3>
                        <span>contato@recantodocafe.com</span>
                    </div>
                </div>

                <div class="contato-item">
                    <i class="fa-solid fa-location-dot"></i>

                    <div>
                        <h3>Endereço</h3>
                        <span>Rua Exemplo, 123 - Centro</span>
                    </div>
                </div>

            </div>

            <div class="apps">

                <a href="#">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>

                <a href="#">
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <a href="#">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>

            </div>

        </div>


    </section>
    <?php include('includes/footer.php') ?>

</div>
<script src="assets/scripts/script.js"></script>
</body>

</html>