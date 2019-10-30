<?php
header('Content-Type: application/json; charset=utf-8');
include('../../db.php');

try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}
$sql = 'SELECT id, book_name,author, Publishing_house, Publication_date, price, img1, img2, Introduction,
about_the_author, a_list, details FROM commodity WHERE id=:id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$result = $statement->execute();
$commodity = $statement->fetch(PDO::FETCH_ASSOC);

if($result){
    echo json_encode(['id'=>$commodity['id'], 'book_name'=> $commodity['book_name'], 'author'=> $commodity['author'],'Publishing_house'=> $commodity['Publishing_house']
	,'Publication_date'=> $commodity['Publication_date'],'price'=> $commodity['price'],'img1'=> $commodity['img1'],'img2'=> $commodity['img2'], 'Introduction'=> $commodity['Introduction']
	,'about_the_author'=>$commodity['about_the_author'],'a_list'=>$commodity['a_list'],'details'=>$commodity['details']]);
}
?>