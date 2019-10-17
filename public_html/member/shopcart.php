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
$sql = 'SELECT commodity_id, customer_data_id FROM shopcart WHERE commodity_id=:commodity_id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':commodity_id', $_POST['id'], PDO::PARAM_INT);
$result = $statement->execute();
$commodity_id = $statement->fetch(PDO::FETCH_ASSOC);
if($commodity_id['commodity_id'] !== $_POST['id'] || $commodity_id['customer_data_id'] !== $_SESSION['customer']['id']){//不重複insert書單的id

	$sql = 'INSERT INTO shopcart (commodity_id, customer_data_id) VALUES(:commodity_id, :customer_data_id)';
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':commodity_id', $_POST['id'], PDO::PARAM_INT);
	$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
	$statement->execute();

	$sql = 'SELECT * FROM shopcart INNER JOIN commodity on commodity_id = commodity.id WHERE customer_data_id=:customer_data_id';
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
	$result = $statement->execute();
	$shopcart = $statement->fetchAll(PDO::FETCH_ASSOC);
	if($result){
		echo json_encode($shopcart, JSON_NUMERIC_CHECK);
	}else{
		var_dump($pdo->errorInfo());
	}
}else{
	http_response_code(400);
	echo '商品已在購物車中。';
}


?>