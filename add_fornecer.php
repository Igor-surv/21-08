<?php
include_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nome = $_POST['nome'];
  $cpfcnpj = $_POST['cpfcnpj'];
  $endereco = $_POST['endereco'];
  $preco = $_POST['preco'];
  $contato = $_POST['contato']; // fechou a aspas

  // Preparar a consulta
  $stmt = $conn->prepare("INSERT INTO fornecedores (nome, cpfCnpj, endereco, preco, contato) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $nome, $cpfcnpj, $endereco, $preco, $contato); // corrigiu o tipo de parâmetro

  // Executar a consulta
  if ($stmt->execute()) {
    echo "Item adicionado com sucesso!";
  } else {
    echo "Erro ao adicionar pedido: " . $stmt->error;
  }

  // Fechar a statement
  $stmt->close();
}

// Redirecionar para a página anterior
header('Location: financeiro.php');
exit;
?>