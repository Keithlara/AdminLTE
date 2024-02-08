<?php

include_once 'connectdb.php';

if(isset($_SESSION['id'])){

    $id = $_GET['id'];

    $delete=$pdo->prepare("delete from tbl_user where userid=" . $id);
    $delete->execute();
}

?>