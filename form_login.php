<?php

session_start();

include("includes/head.php");

?>

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
            <button><a href="form_register.php">Registre-se</a></button>
        </div>
    </div>
</header>


<main>

    <div class="form_content">

        <form
                action="form_login_output.php"
                method="POST"
        >

            E-mail:
            <br>

            <input
                    type="email"
                    name="email"
                    required
            >

            <br>


            Senha:
            <br>

            <input
                    type="password"
                    name="password"
                    required
            >

            <br>


            <input
                    type="submit"
                    value="Entrar"
            >

        </form>

    </div>

</main>


<?php

include("includes/footer.php");

?>
<script src="assets/scripts/script.js"></script>
</body>
</html>