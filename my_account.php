<?php

session_start();


/*
    1. VERIFICAR SE EXISTE USUÁRIO LOGADO
*/

if (!isset($_SESSION['usuario_id'])) {

    header("Location: form_login.php");

    exit;
}


/*
    2. CONECTAR AO BANCO
*/

$connect = new mysqli(
        "localhost",
        "root",
        "Seemg@1222017",
        "recanto_do_cafe"
);

$connect->set_charset("utf8");


/*
    3. PEGAR O ID DA SESSÃO
*/

$id = $_SESSION['usuario_id'];


/*
    4. CRIAR A CONSULTA
*/

$sql = "SELECT id, nome, email, telefone
        FROM usuario
        WHERE id = ?";


/*
    5. PREPARAR
*/

$stmt = $connect->prepare($sql);


/*
    6. COLOCAR O ID NO ?
*/

$stmt->bind_param(
        "i",
        $id
);


/*
    7. EXECUTAR
*/

$stmt->execute();


/*
    8. PEGAR O RESULTADO
*/

$result = $stmt->get_result();


/*
    9. TRANSFORMAR EM ARRAY
*/

$usuario = $result->fetch_assoc();


/*
    10. HTML
*/

include("includes/head.php");

?>


<style>

    /* =========================
       ÁREA PRINCIPAL
    ========================= */

    .my_account_content {

        min-height: calc(100vh - 100px);

        display: flex;
        flex-direction: column;

        align-items: center;
        justify-content: center;

        text-align: left;

        padding: 60px 20px;

        background:
                linear-gradient(
                        135deg,
                        #211408,
                        #412c16,
                        #2b1a0d
                );

        color: #fff;

    }


    /* =========================
       CARD DA CONTA
    ========================= */

    .my_account_content {

        /* mantém o fundo da seção */

    }

    .my_account_content h1,
    .my_account_content p,
    .my_account_content a {

        width: 100%;
        max-width: 600px;

    }


    .my_account_content h1 {

        margin-bottom: 35px;

        text-align: center;

        font-size: 42px;

        color: #f5d7a1;

        letter-spacing: 1px;

    }


    /* =========================
       INFORMAÇÕES DO USUÁRIO
    ========================= */

    .my_account_content p {

        box-sizing: border-box;

        margin: 8px 0;

        padding: 18px 22px;

        background: rgba(255, 255, 255, 0.08);

        border: 1px solid rgba(245, 215, 161, 0.25);

        border-radius: 12px;

        color: #f5f5f5;

        font-size: 17px;

        backdrop-filter: blur(5px);

        transition: 0.3s ease;

    }


    .my_account_content p:hover {

        transform: translateY(-2px);

        background: rgba(255, 255, 255, 0.12);

        border-color: rgba(245, 215, 161, 0.5);

    }


    /* =========================
       TÍTULOS DAS INFORMAÇÕES
    ========================= */

    .my_account_content strong {

        display: inline-block;

        min-width: 90px;

        color: #f5d7a1;

    }


    /* =========================
       BOTÃO SAIR
    ========================= */

    .my_account_content a {

        box-sizing: border-box;

        margin-top: 30px;

        padding: 14px 35px;

        max-width: 180px;

        text-align: center;

        text-decoration: none;

        color: #fff;

        background: #8b4513;

        border: 1px solid #b87333;

        border-radius: 10px;

        font-weight: bold;

        transition: all 0.3s ease;

    }


    .my_account_content a:hover {

        background: #b87333;

        transform: translateY(-3px);

        box-shadow:
                0 8px 20px rgba(0, 0, 0, 0.35);

    }


    /* =========================
       RESPONSIVIDADE
    ========================= */

    @media (max-width: 600px) {

        .my_account_content {

            padding: 40px 15px;

        }


        .my_account_content h1 {

            font-size: 32px;

        }


        .my_account_content p {

            font-size: 15px;

            padding: 15px;

        }


        .my_account_content strong {

            display: block;

            margin-bottom: 5px;

        }

    }

</style>

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


    <span style="color: white;">

        Olá,

        <?= htmlspecialchars($_SESSION['nome']) ?>

    </span>

</header>


<main>

    <div class="my_account_content">

        <h1>
            Minha conta
        </h1>

        <p>
            <strong>
                ID:
            </strong>

            <?= htmlspecialchars($usuario['id']) ?>
        </p>


        <p>

            <strong>
                Nome:
            </strong>

            <?= htmlspecialchars($usuario['nome']) ?>

        </p>


        <p>

            <strong>
                E-mail:
            </strong>

            <?= htmlspecialchars($usuario['email']) ?>

        </p>


        <p>

            <strong>
                Telefone:
            </strong>

            <?= htmlspecialchars($usuario['telefone']) ?>

        </p>


        <a href="logout.php">
            Sair
        </a>
    </div>

</main>

<?php  include ("includes/footer.php"); ?>

</body>
</html>