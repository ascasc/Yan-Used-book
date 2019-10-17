<?php
header('Content-Type: application/json; charset=utf-8');
include('../../db.php');
try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}

$sql = 'SELECT * FROM((product INNER JOIN customer_data ON customer_data_id=customer_data.id) 
INNER JOIN Map_data ON product.customer_data_id=Map_data.customer_data_id)
INNER JOIN product_status ON product.id=product_id ORDER BY product.id ASC';
$statement = $pdo->prepare($sql);
$result = $statement->execute();
$shopping_list_admin= $statement->fetchAll(PDO::FETCH_ASSOC);
if($result){
	echo json_encode(['data'=>$shopping_list_admin]);
}else{
	var_dump($pdo->errorInfo());
}

?>