<?php  

require "config.php";

try {


	$sql = "SELECT * FROM vcfs ORDER BY -strenth";

	$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);

	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	$statement = $conn->prepare($sql);

	$statement->execute();

	$statement->setFetchMode(PDO::FETCH_ASSOC);

	$rows = $statement->fetchAll();

	$decodd = json_encode($rows);

	echo $decodd;
	$conn = null;


	
} catch (Exception $e) {
	
}
?>