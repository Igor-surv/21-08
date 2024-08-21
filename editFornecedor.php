<?php
include_once 'config.php';

session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}

$userEmail = $_SESSION['email'];

$autorizado = "inovagest376@gmail.com";
$query = "SELECT * FROM admin WHERE email = '$autorizado'";
$result = mysqli_query($conn, $query);

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

if (isset($_GET['nome'])) {
    $nome = $_GET['nome'];
    $query = "SELECT * FROM fornecedores WHERE nome = '$nome'";
    $result = $conn->query($query);

    if (!$result) {
        die("Erro ao recuperar o registro: ". $conn->error);
    }

    $resultado = $result->fetch_assoc();
} else {
    $resultado = array();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit.css">
    <title>Editar fornecedor</title>
</head>
<body>
    
    <div class="container">
        <form action="editarFornecedor.php" class="block" method="post">

            <input type="hidden" name="nome" value="<?php echo $resultado['nome']; ?>">

            <label for="nvnome">Nome:</label><br>
            <input type="text" id="nvnome" name="nvnome" value="<?php echo $resultado['nome']; ?>"><br><br>

            <label for="cpfCnpj">CPF/CNPJ:</label><br>
            <input type="text" id="cpfCnpj" name="cpfCnpj" value="<?php echo $resultado['cpfCnpj']; ?>"><br><br>

            <label for="endereco">Endereço:</label><br>
            <input type="text" id="endereco" name="endereco" value="<?php echo $resultado['endereco']; ?>"><br><br>

            <label for="preco">Preço:</label><br>
            <input type="number" id="preco" name="preco" step="0.01" min="0" value="<?php echo $resultado['preco']; ?>"><br><br>

            <label for="contato">Contato:</label><br>
            <input type="number" id="contato" name="contato" value="<?php echo $resultado['contato']; ?>"><br><br>

            <?php if ($permitirExecutar) { ?>
                <input type="submit" name="update" id="submit">
            <?php } else { ?>
                <p>Você não tem permissão para executar essa ação.</p>
            <?php } ?>
        </form>
    </div>

</body>
</html>