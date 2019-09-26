<?php
header('Content-Type: application/json; charset=utf-8');
include('../../../db.php');
try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}

$sql = 'SELECT id,`name`, email FROM customer_data WHERE id=:id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$result = $statement->execute();
$admin_update_customers= $statement->fetch(PDO::FETCH_ASSOC);
if($result){
	echo json_encode(['id'=>$admin_update_customers['id'],'name'=>$admin_update_customers['name'],'email'=>$admin_update_customers['email']]);
}else{
	var_dump($pdo->errorInfo());
}
?>