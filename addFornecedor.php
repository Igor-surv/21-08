<?php 
  include_once 'config.php';

  session_start();

   if (!isset($_SESSION["email"])) {
       header("Location: login.php");
       exit;
   }
   
   $userEmail = $_SESSION['email'];


    $sql = "SELECT * FROM admin";
    $result = mysqli_query($conn, $sql);

    // Verificar se o email foi encontrado
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['email'] == $userEmail) {
            $permitirExecutar = true;
        } else {
            $permitirExecutar = false;
        }
    } else {
        $permitirExecutar = false;
    }
  
  mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="addEstoque.css">
  <title>Adicionar Fornecedor</title>
</head>
<body>

<form action="add_fornecer.php" class="container" method="post">
  <h1>Adicionar Fornecedor</h1>

  <label for="nome">Nome:</label>
  <input type="text" name="nome" maxlength="100" required>
  <br><br>

  <label for="cpfcnpj">CPF/CNPJ:</label>
  <input type="text" name="cpfcnpj" maxlength="18" required>
  <br><br>

  <label for="endereco">Endereço:</label>
  <input type="text" name="endereco" maxlength="150" required>
  <br><br>  

  <label for="preco">Preço:</label>
  <input type="number" id="preco" name="preco" step="0.01" min="0" required>
  <br><br>

  <label for="contato">Contato:</label>
  <input type="number" id="contato" name="contato" maxlength="50" required >
  <br><br>

  <?php if ($permitirExecutar) { ?>
  <input type="submit" name="add" id="submit" value="Adicionar Fornecedor">
  <?php } else { ?>
      <p>Você não tem permissão para executar essa ação.</p>
  <?php } ?>
</form>

</body>
</html>