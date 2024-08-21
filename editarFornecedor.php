<?php
require_once 'config.php';

$nome = $_POST['nome'];
$nvnome = $_POST['nvnome'];
$cpfCnpj = $_POST['cpfCnpj'];
$endereco = $_POST['endereco'];
$preco = $_POST['preco'];
$contato = $_POST['contato'];

$stmt = mysqli_prepare($conn, "UPDATE fornecedores SET nome = ?, cpfCnpj = ?, endereco = ?, preco = ?, contato = ? WHERE nome = ?");
mysqli_stmt_bind_param($stmt, "sssssi", $nvnome, $cpfCnpj, $endereco, $preco, $contato, $nome);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_errno($stmt)) {
    die("Erro ao executar a consulta: " . mysqli_stmt_error($stmt));
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header('Location: financeiro.php');
exit;
?>