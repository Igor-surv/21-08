<?php
require_once 'config.php';

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$emitente = $_POST['emitente'];
$pedido = $_POST['pedido'];
$codigo = $_POST['codigo'];
$nome = $_POST['nome'];

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO recibo (emitente, pedido, codigo, nome) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $emitente, $pedido, $codigo, $nome);

if ($stmt->execute()) {
    echo "Recibo emitido com sucesso";
} else {
    echo "Erro ao adicionar pedido: ". $conn->error;
}

// Redirecionar para a página anterior
header('Location: relatorio.php');
exit;
?>