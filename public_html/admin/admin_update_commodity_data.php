<?php
header('Content-Type: application/json; charset=utf-8');
include('../../../db.php');


try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}

$sql = 'SELECT * FROM customer_data ORDER BY id ASC';
$statement = $pdo->prepare($sql);
$result = $statement->execute();
$admin_update_customer_datas= $statement->fetchAll(PDO::FETCH_ASSOC);
if($result){
	echo json_encode(['data'=>$admin_update_customer_datas]);
}
?>