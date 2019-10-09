<?php
header('Content-Type: application/json; charset=utf-8');
include('../../../db.php');
try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}
//商品啟動與關閉狀態
$sql = 'UPDATE commodity_switch SET switch=:switch WHERE commodity_id=:id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$statement->bindValue(':switch', $_POST['commodity_switch'], PDO::PARAM_STR);
$result = $statement->execute();
if($result){
	echo json_encode(['id'=>$_POST['id'], 'commodity_switch'=>$_POST['commodity_switch']]);
}else{
	var_dump($pdo->errorInfo());
}
?>