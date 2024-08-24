<?php
require_once('config.php');


if(!empty($_GET['id']))
{
    $id = $_GET['id'];

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
    } 
?>

