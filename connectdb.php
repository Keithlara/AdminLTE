<?php

try{

    $pdo = new PDO('mysql:host=localhost;dbname=pos_barcode_db','root','');

}catch(PDOException $e){

echo $e->getMessage();

}



//echo'connection success';




?>