<?php
session_start();
$regdate = date("Y/m/d");

if($_SERVER['REQUEST_METHOD'] === "POST"){
	$contactName = test_input($_POST['name']);
	$phoneNumber = test_input($_POST['phone']);
}
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
require "config.php";
  try{
  	$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
  	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  	$statement = $conn->prepare("SELECT * FROM users WHERE phone = (:phone)");
  	$param = ["phone" => $phoneNumber];
  	$statement->execute($param);
  	$result = $statement->setFetchMode(PDO::FETCH_ASSOC);
  	$rows = $statement->fetchAll();
  	$rowcount = count($rows);

  	if($rowcount == 0){
  		$statement2 = $conn->prepare("INSERT INTO users (firstname,phone,reg_date)VALUES(:name,:phone,:datE)");
  		$params2 = ["name" => $contactName,"phone" => $phoneNumber,"datE"=>$regdate];
        
  		$statement2->execute($params2);
  		$details = ["name" => $contactName,"phone" => $phoneNumber,"date"=>$regdate];
  		$json = json_encode($details);
      $_SESSION['name'] = $contactName;
      $_SESSION['phone'] = $phoneNumber;
      setcookie($_SESSION['name'],$_SESSION,time() + 86400*30);
  		echo $json;

}

if($rowcount == 1){
  $_SESSION['name'] = $rows[0]["firstname"];
  $_SESSION['phone'] = $rows[0]["phone"];
	$details = ["name"=>$rows[0]["firstname"],"phone"=>$rows[0]["phone"],"date"=>$rows[0]["reg_date"]];
	$json = json_encode($details);
	$conn = null;

  setcookie($_SESSION['name'],$_SESSION,time() + 86400*30);

}
$conn = null;

  }catch(Exeption $e){

  }
  ?>