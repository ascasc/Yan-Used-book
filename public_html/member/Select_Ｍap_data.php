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
$sql = 'SELECT customer_data_id FROM Map_data WHERE customer_data_id=:customer_data_id ';
$statement = $pdo->prepare($sql);
$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
$result = $statement->execute();
$Map_data = $statement->fetch(PDO::FETCH_ASSOC);
if($Map_data['customer_data_id']!==$_SESSION['customer']['id']){
	http_response_code(400);
}else{
	echo json_encode(['name'=>'結帳成功，已導入過電子地圖。']);
}
?>