<?php 
session_start();
if($_SERVER['REQUEST_METHOD'] == "POST"){

$name = $_SESSION['name'];
$phonenumber = $_SESSION['phone'];

$vcfname = $_POST['vcfname'].".vcf";


$contact_file = fopen($vcfname,"a+")or die("Unable to open file");
$txt = "BEGIN:VCARD\nVERSION:2.1\nN:;Bedroom mburi;;;\nFN:Bedroom mburi\nTEL;CELL:+254716732614\nEND:VCARD\n";

$txt2 = "BEGIN:VCARD\nVERSION:2.1\nN:;".$name.";;;\nFN:".$name."\nTEL;CELL:".$phonenumber."\nEND:VCARD\n";

fwrite($contact_file,$txt);
fwrite($contact_file, $txt2);
fclose($contact_file);
//echo"Your contact details added in our vcf file";
$url = $vcfname; 
}

require "config.php";

try {

    require "config.php";

	$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);

	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	$sql2 = "SELECT * FROM vcfs WHERE name = (:name)";

	$args = ["name"=>$vcfname];

	$stmt = $conn->prepare($sql2);

	$stmt->execute($args);

	$results = $stmt->setFetchMode(PDO::FETCH_ASSOC);

	$rows = $stmt->fetchAll();

	$bool = count($rows) === 0;


	if($bool){
	$sql = "INSERT INTO vcfs (name,url)VALUES(:name,:uRl) ";
	$params = ["name"=>$vcfname,"uRl"=>$vcfname] ;

	$stnt = $conn->prepare($sql);
	$stnt->execute($params);


	}


$conn = null;
	
	
} catch (Exception $e) {
	
}
?>