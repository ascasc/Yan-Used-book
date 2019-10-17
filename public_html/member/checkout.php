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

//購物車資料庫
$sql = 'SELECT book_name, price, commodity_id FROM shopcart INNER JOIN commodity on commodity_id=commodity.id WHERE customer_data_id=:customer_data_id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
$statement->execute();
$shopcart = $statement->fetchAll(PDO::FETCH_ASSOC);
//購物車書的名稱與價格名稱總結為明細表
$shopcart_book_name;
$shopcart_price;
foreach ($shopcart as $key => $shopcarts) {
	$shopcart_book_name = $shopcart_book_name .' '. $shopcarts['book_name'];
	$shopcart_price = $shopcart_price + $shopcarts['price'];
	$shopcart_commodity_id[] = $shopcarts['commodity_id'];
}
if(empty($shopcart_commodity_id)){
	http_response_code(400);
	echo '購物車為空，請選擇商品加入到購物車在進行結帳。';
}else{
	$sql = 'INSERT INTO product (book_name, price, customer_data_id) VALUES(:book_name, :price, :customer_data_id)';
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':book_name', $shopcart_book_name, PDO::PARAM_STR);
	$statement->bindValue(':price', $shopcart_price, PDO::PARAM_STR);
	$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
	$result=$statement->execute();
	//出貨狀態
	$sql = 'INSERT INTO product_status (product_id) VALUES(:product_id)';
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':product_id', $pdo->lastInsertId(), PDO::PARAM_INT);
	$result=$statement->execute();
	//關掉首頁的商品
	foreach ($shopcart as $key => $shopcarts) {
		$sql = 'UPDATE commodity_switch SET switch=:switch WHERE commodity_id=:commodity_id';
		$statement = $pdo->prepare($sql);
		$statement->bindValue(':commodity_id', $shopcarts['commodity_id'], PDO::PARAM_INT);
		$statement->bindValue(':switch', 0, PDO::PARAM_INT);
		$result=$statement->execute();
		//刪除其他使用者購物車存在的商品
		$sql = 'DELETE FROM shopcart WHERE commodity_id=:commodity_id';
		$statement = $pdo->prepare($sql);
		$statement->bindValue(':commodity_id', $shopcarts['commodity_id'], PDO::PARAM_INT);
		$result=$statement->execute();
		$data[]='.'.$shopcarts['commodity_id'];
	}
	if($result){
		echo json_encode(['name'=>'結帳成功。', 'data'=>$data]);
	}else{
		var_dump($pdo->errorInfo());
	}
}
//刪除購物車
$sql = 'DELETE FROM shopcart WHERE customer_data_id=:customer_data_id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':customer_data_id', $_SESSION['customer']['id'], PDO::PARAM_INT);
$statement->execute();
?>