<?php
try{
$conn = new PDO("mysql:host=localhost;dbname=vic","vic","1234");
}catch(Exception $e){
    echo $e;
}

?>