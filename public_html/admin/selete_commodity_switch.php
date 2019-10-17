<?php
header('Content-Type: application/json; charset=utf-8');
include('../../db.php');


try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}

$sql = 'SELECT * FROM commodity_switch INNER JOIN commodity ON commodity_id=commodity.id ORDER BY commodity.id ASC';
$statement = $pdo->prepare($sql);
$result = $statement->execute();
$commodity_switch= $statement->fetchAll(PDO::FETCH_ASSOC);
if($result){
	echo json_encode(['data'=>$commodity_switch]);
}else{
	var_dump($pdo->errorInfo());
}
?>