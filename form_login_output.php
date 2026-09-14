<?php
// 1. Inicia a sessão APENAS UMA VEZ no topo do arquivo
session_start();

$email = $_POST['email'] ?? '';
$senha = $_POST['password'] ?? '';
$erro_login = ""; // Criamos essa variável para guardar o erro se ele acontecer

$connect = new mysqli(
        "localhost",
        "root",
        "Seemg@1222017",
        "recanto_do_cafe"
);

$connect->set_charset("utf8");

$sql = "SELECT id, nome, senha, email, telefone
        FROM usuario
        WHERE email = ?";

$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if ($usuario && password_verify($senha, $usuario['senha'])) {
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];

    header("Location: my_account.php");
    exit;
} else {
    // Em vez de dar "echo" aqui em cima e quebrar o HTML, guardamos na variável
    $erro_login = "E-mail ou senha incorretos.";
}

// Inclui o head do HTML depois de processar o PHP do banco
include("includes/head.php");
?>

</head>

<body>

<header>
    <div class="logo">
        <a href="index.html">
            <img src="img/logo.png" alt="Recanto do Café">
        </a>
    </div>

    <nav>
        <ul>
            <li><a href="suporte.php">Suporte</a></li>
            <li><a href="servicos.html">Serviços</a></li>
            <li><a href="sobre.html">Sobre nós</a></li>
            <li><a href="clientes.html">Clientes</a></li>
        </ul>
    </nav>

    <div class="form">
        <a href="form_register.php">Criar conta</a>
    </div>
</header>

<main>
    <div class="form_content">
        <?php
        // Se a variável de erro não estiver vazia, mostra o erro de forma organizada
        if (!empty($erro_login)) {
            echo "<p style='color: red; font-weight: bold;'>$erro_login</p>";
        }
        ?>
    </div>
</main>

<?php
include("includes/footer.php");
?>

</body>
</html>
