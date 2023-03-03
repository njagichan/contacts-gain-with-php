<?php 
session_start();

if(isset($_SESSION['phone'])){

if(isset($_POST['namevcf'])){

	$name = $_SESSION['name'];
    $phonenumber = $_SESSION['phone'];
    $vcfname = $_POST['namevcf'] ;


    try {

require "config.php";

	$sql = "SELECT * FROM vcfs WHERE name = (:name)";

	$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);

	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	$statement = $conn->prepare($sql);

	$params = ["name"=>$vcfname];

	$statement->execute($params);

	$statement->setFetchMode(PDO::FETCH_ASSOC);

	$rows = $statement->fetchAll();

	$decodd = json_encode($rows);

	$dtimes = $rows[0]['downloads']+1;
	$popty = $rows[0]['strenth']+1;
	$conn = null;

} catch (PDOException $e) {
	
}



	try {

		require "config.php";

		$connection = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
		$query = "SELECT * FROM vfcmembers WHERE phone = (:phone)";
		$prms = ["phone"=>$phonenumber];
		$link = $connection->prepare($query);
		$link->execute($prms);
		$link->setFetchMode(PDO::FETCH_ASSOC);
		$rowno = $link->fetchAll();

		if(count($rowno)==0){
			$SQL = "UPDATE vcfs SET downloads=(:down),strenth=(:strnth) WHERE name =(:name)";


			$addquerry = "INSERT INTO vfcmembers (phone) VALUES (:phone)";
			$linkad = $connection->prepare($addquerry);
			$paramss = ["phone"=>$phonenumber];
			$linkad->execute($paramss);


	        $Bullet = $connection->prepare($SQL);

	        $args = ["down"=>$dtimes,"strnth"=>$popty,"name"=>$vcfname];
	        $Bullet->execute($args);



             $contact_file = fopen($vcfname,"a+")or die("Unable to open file");
             $txt = "BEGIN:VCARD\nVERSION:2.1\nN:;".$name.";;;\nFN:".$name."\nTEL;CELL:".$phonenumber."\nEND:VCARD\n";
             fwrite($contact_file,$txt);
             fclose($contact_file);
}

         $connection = null;

} catch (PDOException $e) {

}
echo $vcfname;

}
}else{
	echo "front-end.htm";

}
 ?>