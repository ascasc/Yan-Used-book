<?php
header('Content-Type: application/json; charset=utf-8');
include('../HttpStatusCode.php');
include('../../db.php');
try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}

if(!is_uploaded_file($_FILES['file_img1']['tmp_name'])){
    new HttpStatusCode(400,'請選擇檔案');
}else if(empty($_POST['book_name'])){
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
else{//可以新增到資料庫的時候
    $sourcePath1 = $_FILES['file_img1']['tmp_name'];//前封面圖片
    $targetPath1 = "../create_img/".$_FILES['file_img1']['name'];
    $targetPath1_2 = "create_img/".$_FILES['file_img1']['name'];
    $sourcePath2 = $_FILES['file_img2']['tmp_name'];//後封面圖片
    $targetPath2 = "../create_img/".$_FILES['file_img2']['name'];
    $targetPath2_2 = "create_img/".$_FILES['file_img2']['name'];
    if(move_uploaded_file($sourcePath1,$targetPath1) && move_uploaded_file($sourcePath2,$targetPath2)){//照片上傳成功的時候
        $sql = 'INSERT INTO commodity (book_name, author, Publishing_house, Publication_date, price, img1, img2, Introduction, about_the_author, a_list, details)
        VALUES(:book_name, :author, :Publishing_house, :Publication_date, :price, :img1, :img2, :Introduction, :about_the_author , :a_list, :details)';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':book_name', $_POST['book_name'], PDO::PARAM_STR);
        $statement->bindValue(':author', $_POST['author'], PDO::PARAM_STR);
        $statement->bindValue(':Publishing_house', $_POST['Publishing_house'], PDO::PARAM_STR);
        $statement->bindValue(':Publication_date', $_POST['Publication_date'], PDO::PARAM_STR);
        $statement->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
        $statement->bindValue(':img1', $targetPath1_2, PDO::PARAM_STR);
        $statement->bindValue(':img2', $targetPath2_2, PDO::PARAM_STR);
        $statement->bindValue(':Introduction', $_POST['Introduction'], PDO::PARAM_STR);
        $statement->bindValue(':about_the_author', $_POST['about_the_author'], PDO::PARAM_STR);
        $statement->bindValue(':a_list', $_POST['a_list'], PDO::PARAM_STR);
        $statement->bindValue(':details', $_POST['details'], PDO::PARAM_STR);
        $result = $statement->execute();
        //新增商品開關狀態
        $sql = 'INSERT INTO commodity_switch (commodity_id) VALUES(:commodity_id)';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':commodity_id', $pdo->lastInsertId(), PDO::PARAM_INT);
        $result = $statement->execute();
        //調用商品資料庫讓首頁同步
        $sql = 'SELECT * FROM commodity INNER JOIN commodity_switch ON commodity.id=commodity_id ORDER BY commodity.id ASC';
        $statement = $pdo->prepare($sql);
        $result = $statement->execute();
        $commodities= $statement->fetchAll(PDO::FETCH_ASSOC);
        if($result){
            echo json_encode($commodities, JSON_NUMERIC_CHECK);
        }else{
            var_dump($pdo->errorInfo());
        }
    }else{
        new HttpStatusCode(400, '圖片上傳失敗，請上傳完整的前後封面圖片。');
    }
    
}
?>