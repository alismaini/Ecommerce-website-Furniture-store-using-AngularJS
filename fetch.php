<?php

//fetch.php

$connect = new PDO("mysql:host=localhost;dbname=prodisp", "root", "");
//$connect = mysqli_connect('localhost','dprodis','p@qweQWE123','cywsitec_prodisp');


$query = "SELECT * FROM tbl_product";
$statement = $connect->prepare($query);
$statement->execute();
while($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$data[] = $row;
}

echo json_encode($data);

?>