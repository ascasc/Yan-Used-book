<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include('../../db.php');
try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}
$sql = 'SELECT `name`, email, `phone`,CVSStoreID, CVSStoreName, CVSAddress FROM customer_data INNER JOIN Map_data on customer_data.id = Map_data.customer_data_id WHERE customer_data.id=:id ';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $_SESSION['customer']['id'], PDO::PARAM_INT);
$result = $statement->execute();
$customer_data= $statement->fetch(PDO::FETCH_ASSOC);
if($result){
	echo json_encode($customer_data, JSON_NUMERIC_CHECK);
}else{
	var_dump($pdo->errorInfo());
}
?>