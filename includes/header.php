<?php if (isset($_SESSION['usuario_id'])):

    $sql = "SELECT * FROM usuario WHERE id = ?";

    $stmt = $connect->prepare($sql);

    $stmt->bind_param(
        "i",
        $_SESSION['usuario_id']
    );

    $stmt->execute();

    $resultado = $stmt->get_result();
    $infos = $resultado->fetch_assoc();

    $primeiro_nome = explode(" ", $infos['nome'])[0];

?>
    <header>
        <div class="logo">
            <a href="index.php">
                <img src="img/logo.png" alt="Recanto do Café">
            </a>
        </div>


        <div class="nav">
            <nav>
                <ul>
                    <li><a href="produtos.php">Cardápio</a></li>
                    <li><a href="suporte.php">Suporte</a></li>
                    <li><a href="servicos.php">Serviços</a></li>
                    <li><a href="sobre.php">Sobre nós</a></li>
                    <li><a href="clientes.php">Clientes</a></li>
                </ul>
            </nav>
        </div>


        <div class="form">
            <button>
                <a href="my_account.php">Olá, <?= $primeiro_nome ?>!</a>
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
                    <li><a href="produtos.php">Cardápio</a></li>
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

<?php else: ?>

    <header>
        <div class="logo">
            <a href="index.php">
                <img src="img/logo.png" alt="Recanto do Café">
            </a>
        </div>


        <div class="nav">
            <nav>
                <ul>
                    <li><a href="produtos.php">Cardápio</a></li>
                    <li><a href="suporte.php">Suporte</a></li>
                    <li><a href="servicos.php">Serviços</a></li>
                    <li><a href="sobre.php">Sobre nós</a></li>
                    <li><a href="clientes.php">Clientes</a></li>
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
                    <li><a href="produtos.php">Cardápio</a></li>
                    <li><a href="suporte.php">Suporte</a></li>
                    <li><a href="servicos.php">Serviços</a></li>
                    <li><a href="sobre.php">Sobre nós</a></li>
                    <li><a href="clientes.php">Clientes</a></li>
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

<?php endif; ?>