<?php

session_start();

$nome = $_POST['nome'] ?? '';
$senha = $_POST['password'] ?? '';
$email = $_POST['email'] ?? '';
$telefone = $_POST['telefone'] ?? '';


// FUNÇÃO PARA LIMPAR OS DADOS
function verificar_entrada($entrada)
{
    $entrada = trim($entrada);
    $entrada = stripslashes($entrada);
    $entrada = htmlspecialchars($entrada);

    return $entrada;
}


// ==========================
// VALIDAÇÃO DO NOME
// ==========================

$nome = verificar_entrada($nome);

if (empty($nome)) {
    echo "Por favor, insira o seu nome!";
}

if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nome)) {
    echo "Nome inválido. Utilize apenas letras e espaços.";
}


// ==========================
// VALIDAÇÃO DA SENHA
// ==========================

if (empty($senha)) {
    echo "Por favor, insira a senha!";
}

if (!preg_match("/^[a-zA-Z0-9_@!#$%¨&()]+$/", $senha)) {
    echo "Senha inválida. Utilize apenas letras e números.";
}


// ==========================
// VALIDAÇÃO DO E-MAIL
// ==========================

$email = verificar_entrada($email);

if (empty($email)) {
    die("Por favor, insira o e-mail!");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("E-mail inválido.");
}


// ==========================
// VALIDAÇÃO DO TELEFONE
// ==========================

$telefone = verificar_entrada($telefone);

if (empty($telefone)) {
    die("Por favor, insira o telefone!");
}


// ==========================
// CRIPTOGRAFAR SENHA
// ==========================

$senha = password_hash(
    $senha,
    PASSWORD_DEFAULT
);


// ==========================
// CONECTAR AO BANCO
// ==========================

$connect = new mysqli(
    "localhost",
    "root",
    "Seemg@1222017",
    "recanto_do_cafe"
);

$connect->set_charset("utf8");


// ==========================
// INSERIR USUÁRIO
// ==========================

$sql = "INSERT INTO usuario
        (nome, senha, email, telefone)
        VALUES (?, ?, ?, ?)";

$stmt = $connect->prepare($sql);

$stmt->bind_param(
    "ssss",
    $nome,
    $senha,
    $email,
    $telefone
);


// ==========================
// EXECUTAR
// ==========================

if ($stmt->execute()) {

    // Pega o ID do usuário recém-criado
    $id = $connect->insert_id;

    // Guarda o usuário na sessão
    $_SESSION['usuario_id'] = $id;
    $_SESSION['nome'] = $nome;

    // Envia para a página da conta
    header("Location: my_account.php");
    exit;

} else {

    echo "Erro ao cadastrar usuário: " . $stmt->error;
}

?>