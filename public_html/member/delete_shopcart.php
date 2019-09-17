<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include('../../../db.php');

try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}
$sql = 'DELETE FROM shopcart WHERE customer_data_id=:customer_data_id AND commodity_id=:commodity_id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
$statement->bindValue(':commodity_id', $_POST['id'], PDO::PARAM_INT);
$result = $statement->execute();
if($result){
	echo json_encode(['commodity_id'=>$_POST['id']]);
}else{
	var_dump($pdo->errorInfo());
}

?>