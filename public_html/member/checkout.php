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
$sql = 'SELECT book_name, price, customer_data_id FROM product WHERE customer_data_id=:customer_data_id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
$result = $statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);


if($product['book_name'] !==$_POST['book_name'] || $product['book_price'] !==$_POST['price']){
	$sql = 'INSERT INTO product (book_name, price, customer_data_id) VALUES(:book_name, :price, :customer_data_id)';
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':book_name', $_POST['book_name'], PDO::PARAM_STR);
	$statement->bindValue(':price', $_POST['book_price'], PDO::PARAM_STR);
	$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
	$statement->execute();

	$sql = 'DELETE FROM shopcart WHERE customer_data_id=:customer_data_id';
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
	$result = $statement->execute();

	if($result){
		echo json_encode(['name'=>'結帳成功。']);
	}else{
		var_dump($pdo->errorInfo());
	}
}else{
	http_response_code(400);
	echo '此商品已結帳過了。';
}
?>