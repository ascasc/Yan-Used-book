<?php
header('Content-Type: application/json; charset=utf-8');
include('../../../db.php');
try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}

$sql = 'UPDATE shopping_list_status SET shipment_status=:shipment_status WHERE product_id=:id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$statement->bindValue(':shipment_status', $_POST['shipment_status'], PDO::PARAM_STR);
$result = $statement->execute();
if($result){
	echo json_encode(['id'=>$_POST['id'], 'shipment_status'=>$_POST['shipment_status']]);
}else{
	var_dump($pdo->errorInfo());
}

?>