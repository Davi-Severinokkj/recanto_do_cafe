<?php

$connect = new mysqli("localhost", "root", "Seemg@1222017", "recanto_do_cafe");
$connect->set_charset("utf8");

if ($connect->connect_error) {
    echo "<p>Erro: . $connect->connect_error</p>";
    return;
}
?>
