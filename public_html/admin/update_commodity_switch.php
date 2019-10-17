<?php
header('Content-Type: application/json; charset=utf-8');
include('../../db.php');
try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}
//商品啟動與關閉狀態
$sql = 'UPDATE commodity_switch SET switch_num=:switch_num ,switch=:switch WHERE commodity_id=:id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$statement->bindValue(':switch_num', $_POST['commodity_switch_num'], PDO::PARAM_INT);
$statement->bindValue(':switch', $_POST['commodity_switch'], PDO::PARAM_STR);
$result = $statement->execute();
$sql = 'SELECT * FROM commodity INNER JOIN commodity_switch ON commodity.id=commodity_id ORDER BY commodity.id ASC';
$statement = $pdo->prepare($sql);
$result = $statement->execute();
$commodities= $statement->fetchAll(PDO::FETCH_ASSOC);
if($result){
	echo json_encode($commodities, JSON_NUMERIC_CHECK);
}else{
	var_dump($pdo->errorInfo());
}
?>