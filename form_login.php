<?php

session_start();

include("includes/head.php");

?>

<body>

<header>

    <div class="logo">

        <a href="index.php">

            <img
                    src="img/logo.png"
                    alt="Recanto do Café"
            >

        </a>

    </div>


    <nav>

        <ul>

            <li>
                <a href="suporte.php">
                    Suporte
                </a>
            </li>

            <li>
                <a href="servicos.html">
                    Serviços
                </a>
            </li>

            <li>
                <a href="sobre.html">
                    Sobre nós
                </a>
            </li>

            <li>
                <a href="clientes.html">
                    Clientes
                </a>
            </li>

        </ul>

    </nav>


    <div class="form">

        <a href="form_register.php">
            Criar conta
        </a>

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

</body>
</html>