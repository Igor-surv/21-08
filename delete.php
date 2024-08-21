<?php
require_once('config.php');

session_start();

if (!isset($_SESSION["email"])) {
	header("Location: login.php");
	exit;
}

$userEmail = $_SESSION['email'];

$autorizado = "inovagest376@gmail.com";
$query = "SELECT * FROM admin WHERE email = '$autorizado'";
$result = mysqli_query($conn, $query);

if(!empty($_GET['id']))
{
    $id = $_GET['id'];

    if ($userEmail === $autorizado) {
        $sqlSelect = "SELECT * FROM pedidos WHERE id = ?";

        $stmt = $conn->prepare($sqlSelect);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0)
        {
        $sqlDelete = "DELETE FROM pedidos WHERE id = ?";

        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $id);
        $stmtDelete->execute();
        }
    } else {
        ?>
        <script>
            $(document).ready(function(){
                $('#modalErro').modal('show');
            });
        </script>
        <?php
    }
}
?>
    <link rel="stylesheet" type="text/css" href="pendentes.css">
    <div class="modal">
        <h2>Erro de autorização</h2>
        <span>Você não tem permissão para excluir pedidos.</span>
        <p>Administrador logado: <?php echo $userEmail ?></p>
        <button type="button"><a href="pedidos_pendentes.php">Voltar</a></button>
    </div>
