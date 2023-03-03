<?php 
$name = "Victor Murimi";
$phonenumber = "0716732614"; 
$contact_file = fopen("contacts.vcf","w")or die("Unable to open file");
$txt = "BEGIN:VCARD\nVERSION:2.1\nN:;".$name.";;;\nFN:".$name."\nTEL;CELL:".$phonenumber."\nEND:VCARD\n";
fwrite($contact_file,$txt);
fclose($contact_file);
echo"Your contact details added in our vcf file";

?>