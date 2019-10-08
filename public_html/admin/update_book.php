<?php
header('Content-Type: application/json; charset=utf-8');
include('../HttpStatusCode.php');
include('../../../db.php');
try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}

if(empty($_POST['book_name'])){
    new HttpStatusCode(400, '書名不可為空');
}
else if(empty($_POST['author'])){
    new HttpStatusCode(400, '作者不可為空');
}
else if(empty($_POST['Publishing_house'])){
    new HttpStatusCode(400, '出版社不可為空');
}
else if(empty($_POST['Publication_date'])){
    new HttpStatusCode(400, '出版日期不可為空');
}
else if(empty($_POST['price'])){
    new HttpStatusCode(400, '價錢不可為空');
}
else if(!preg_match('/^[0-9]+$/', $_POST['price'])){
    new HttpStatusCode(400, '請輸入價錢');
}
else{
    $sourcePath = $_FILES['file_img']['tmp_name'];
    $targetPath1 = "../create_img/".$_FILES['file_img']['name'];
    $targetPath2 = "create_img/".$_FILES['file_img']['name'];
    if(move_uploaded_file($sourcePath,$targetPath1)){
        echo json_encode(['name'=>'上傳成功。']); 
    }else{
        new HttpStatusCode(400, '上傳失敗');
    }
    $sql = 'UPDATE commodity SET book_name=:book_name, author=:author, Publishing_house=:Publishing_house, Publication_date=:Publication_date, price=:price, img=:img, Introduction=:Introduction, about_the_author=:about_the_author, a_list=:a_list, details=:details WHERE id=:id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
    $statement->bindValue(':book_name', $_POST['book_name'], PDO::PARAM_STR);
    $statement->bindValue(':author', $_POST['author'], PDO::PARAM_STR);
    $statement->bindValue(':Publishing_house', $_POST['Publishing_house'], PDO::PARAM_STR);
    $statement->bindValue(':Publication_date', $_POST['Publication_date'], PDO::PARAM_STR);
    $statement->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
    $statement->bindValue(':img', $targetPath2, PDO::PARAM_STR);
    $statement->bindValue(':Introduction', $_POST['Introduction'], PDO::PARAM_STR);
    $statement->bindValue(':about_the_author', $_POST['about_the_author'], PDO::PARAM_STR);
    $statement->bindValue(':a_list', $_POST['a_list'], PDO::PARAM_STR);
    $statement->bindValue(':details', $_POST['details'], PDO::PARAM_STR);
    $result = $statement->execute();
    if(!$result){
        var_dump($pdo->errorInfo());
    }
}
?>