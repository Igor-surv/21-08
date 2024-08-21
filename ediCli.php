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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM clientes WHERE id = '$id'";
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
    <title>Editar colaborador</title>
</head>
<body>
    
    <div class="container">
        <form action="enviar_ediCli.php" class="block" method="post">
            <input type="hidden" name="id" value="<?php echo $resultado['id']; ?>">

            <label for="nome">Nome:</label><br>
            <input type="text" id="nome" name="nome" value="<?php echo $resultado['nome']; ?>"><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo $resultado['email']; ?>"><br><br>

            <label for="telefone">Telefone:</label><br>
            <input type="tel" id="telefone" name="telefone" value="<?php echo $resultado['telefone']; ?>"><br><br>

            <label for="endereco">Endereço:</label><br>
            <input type="text" id="endereco" name="endereco" value="<?php echo $resultado['endereco']; ?>"><br><br>

            <label for="cpf">CPF:</label><br>
            <input type="number" id="cpf" name="cpf" value="<?php echo $resultado['cpf']; ?>"><br><br>

            <?php if ($permitirExecutar) { ?>
                <input type="submit" name="update" id="submit" value="Atualizar">
            <?php } else { ?>
                <p>Você não tem permissão para executar essa ação.</p>
            <?php } ?>
        </form>
    </div>

</body>
</html>