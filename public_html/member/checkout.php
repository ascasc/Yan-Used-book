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

//結帳資料庫
$sql = 'SELECT book_name, price, customer_data_id FROM product WHERE customer_data_id=:customer_data_id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
$result = $statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

//購物車資料庫
$sql = 'SELECT book_name, price FROM shopcart INNER JOIN commodity on commodity_id=commodity.id WHERE customer_data_id=:customer_data_id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
$result = $statement->execute();
$shopcart = $statement->fetchAll(PDO::FETCH_ASSOC);
//購物車書的名稱與價格名稱總結為明細表
$shopcart_book_name;
$shopcart_price;
foreach ($shopcart as $key => $shopcarts) {
	$shopcart_book_name = $shopcart_book_name .' '. $shopcarts['book_name'];
	$shopcart_price = $shopcart_price + $shopcarts['price'];
}
//偵測在結帳資料庫有無此資料庫，如沒有添加進去結帳資料庫
if($product['book_name'] !==$shopcart_book_name && $product['book_price'] !==$shopcart_price){
	$sql = 'INSERT INTO product (book_name, price, customer_data_id) VALUES(:book_name, :price, :customer_data_id)';
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':book_name', $shopcart_book_name, PDO::PARAM_STR);
	$statement->bindValue(':price', $shopcart_price, PDO::PARAM_STR);
	$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
	$result = $statement->execute();
	if($result){
		echo json_encode(['name'=>'結帳成功。']);
	}else{
		var_dump($pdo->errorInfo());
	}
}else if($product['book_name'] =='' && $product['book_price'] ==''){
	http_response_code(400);
	echo '購物車為空，請選擇商品加入到購物車在進行結帳。';
}else{
	http_response_code(400);
	echo '此商品已結帳過了。';
}
//刪除購物車
$sql = 'DELETE FROM shopcart WHERE customer_data_id=:customer_data_id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
$statement->execute();
?>