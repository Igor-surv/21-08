<?php
include_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $item = $_POST['item'];
  $quantidade = $_POST['quantidade'];
  $id_do_cliente = $_POST['id_do_cliente'];
  $nome_do_cliente = $_POST['nome_do_cliente'];
  $id_do_admin = $_POST['id_do_admin'];
  $detalhes = $_POST['detalhes'];
  $status = 'Pendente';

  // Preparar a consulta
  $sqlInsert = "INSERT INTO pedidos (item, quantidade, id_do_cliente, nome_do_cliente, id_do_admin, detalhes, status) 
  VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sqlInsert);

  // Vincular os parâmetros
  $stmt->bind_param("sssssss", $item, $quantidade, $id_do_cliente, $nome_do_cliente, $id_do_admin, $detalhes, $status);

  // Executar a consulta
  if ($stmt->execute()) {
    echo "Pedido adicionado com sucesso!";
  } else {
    echo "Erro ao adicionar pedido: ". $stmt->error;
  }

  // Fechar o statement
  $stmt->close();
}

// Redirecionar para a página anterior
header('Location: pedidos_pendentes.php');
exit;
?>