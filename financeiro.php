<?php
require_once 'config.php';

session_start();

   if (!isset($_SESSION["email"])) {
       header("Location: login.php");
       exit;
   }
   
   $userEmail = $_SESSION['email'];


    $sql = "SELECT * FROM admin";
    $result = mysqli_query($conn, $sql);

    if (!$result){
        die("Erro ao executar a consulta: ". mysqli_error($conn));
    }

//Somar o valor gasto com os fornecedores
$stmt = $conn->prepare("SELECT SUM(preco) AS valores FROM fornecedores WHERE preco > 0");
$stmt->execute();
$result = $stmt->get_result();
$valores = $result->fetch_assoc()['valores'];

//Somar o prejuizo dos itens fora do estoque
$stmt = $conn->prepare("SELECT SUM(quantidade) AS total FROM itens WHERE disponiveis = ?");
$stmt->bind_param("i", $disponiveis); // "i" stands for integer
$disponiveis = 0;
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$estoque = isset($row['total']) ? $row['total'] : 0;

// Consulta para obter os fornecedores
$sql = "SELECT * FROM fornecedores ORDER BY id ASC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
if (mysqli_stmt_errno($stmt)) {
    die("Erro ao executar a consulta: ". mysqli_stmt_error($stmt));
}
$resultFornecedores = mysqli_stmt_get_result($stmt);

// Consulta para obter os recibos
$sql = "SELECT * FROM recibo LIMIT 5";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
if (mysqli_stmt_errno($stmt)) {
    die("Erro ao executar a consulta: ". mysqli_stmt_error($stmt));
}
$resultRecibos = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Financeiro</title>
    <link rel="stylesheet" type="text/css" href="financeiro.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Gastos', '%'],
          ['Fornecedor',     <?php echo $valores ?> ],
          ['Itens fora de estoque',      <?php echo $estoque ?>]
        ]);

        var options = {
          title: 'Gastos',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
</head>
<body>
    
    <div class="menu">
          <ul>
            <li><a href="home.php">Inicio</a></li>
            <li><a href="pedidos_pendentes.php">Pedidos</a></li>
            <li><a href="estoque.php">Estoque</a></li>
            <li><a href="financeiro.php">Financeiro</a></li>
            <li><a href="relatorio.php">Relatorios</a></li>
            <li><a href="clientes.php">Colaboradores</a></li>
            <li><a href="admin.php">Administradores</a></li>
          </ul>
    </div>

<div class="container">
    <h1>Financeiro</h1>

    <div class="block">
    <h2>Resumo financeiro</h2>
    <div class="grafico">
    <div id="piechart_3d" style="width: 43vw; height: 500px;"></div>
    </div></div>

    <div class="recibos">
  <h2>Recibos recentes</h2>
  <table> 
    <thead>
      <tr>
        <th>Emitente</th>
        <th>Cliente</th>
        <th>Pedido</th>
        <th>Itens</th>
      </tr>
    </thead>

    <tbody>
      <?php
          while($row = mysqli_fetch_array($resultRecibos)){
            echo "<tr>";
            echo "<td>".$row['emitente']."</td>";
            echo "<td>".$row['pedido']."</td>";
            echo "<td>".$row['codigo']."</td>";
            echo "<td>".$row['nome']."</td>";
            } ?>
      </tbody>
    </table>
  </div>

  <div class="fornecer">
  <table class="fornecedor"> 
    <h2>Fornecedores</h2>
    <button class="add"> <a href="addFornecedor.php">  Adicionar Fornecedor</a></button>
      <thead>
        <tr>
          <th>Nome</th>
          <th>CPF/CNPJ</th>
          <th>Endereço</th>
          <th>Valor gasto</th>
          <th>Contato</th>
          <th>Ações</th>
        </tr>
      </thead>

      <tbody id="fornecedor-lista"> 
        <?php
          while($row = mysqli_fetch_array($resultFornecedores)){
            echo "<tr>";
            echo "<td>".$row['nome']."</td>";
            echo "<td>".$row['cpfCnpj']."</td>";
            echo "<td>".$row['endereco']."</td>";
            echo "<td>".$row['preco']."</td>";
            echo "<td>".$row['contato']."</td>";
            echo "<td>
              <a class='btn btn-sm btn-danger' href='editFornecedor.php?nome=".$row['nome']."' title='Editar'>
                <img src='https://cdn-icons-png.flaticon.com/512/1828/1828911.png' width='18px' height='18px'>
              </a>
              </td>";
            } ?>
        </tbody>
    </table>
          </div>
</div>

<footer>
  <p>Site criado por <a href="#">InovaGest</a></p>
</footer>
</body>
</html>