<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include('../../db.php');
include('../signup_login/public_signup_login.php');
include('../HttpStatusCode.php');

try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}
if(empty($_POST['name'])){//姓名不可為空
    new HttpStatusCode(400,'姓名不可為空');
}else if(mb_strlen($_POST['name'])<2){//姓名需兩個字以上
    new HttpStatusCode(400,'姓名需兩個字以上');
}else if($_POST['name']!== $_SESSION['customer']['name'] && $_POST['name'] == $name_fetch['name']){//此名字已存在
	new HttpStatusCode(400,'此姓名已存在');
}else if(!preg_match("/^([\x7f-\xff]+)$/",$_POST['name']) && 
        !preg_match('/^([A-Za-z]+)$/',$_POST['name'])){//此姓名需中文與英文
    new HttpStatusCode(400,'此姓名需中文與英文');
}else if(empty($_POST['email'])){//Email不可為空
    new HttpStatusCode(400,'Email不可為空');
}else if(!$email){//Email格式錯誤
    new HttpStatusCode(400,'Email格式錯誤');
}else if($_POST['email'] !== $_SESSION['customer']['email'] && $_POST['email'] == $fetch['email']){//此Email已存在
    new HttpStatusCode(400,'此Email已存在');
}else if(empty($_POST['phone'])){//手機不可為空
    new HttpStatusCode(400,'手機不可為空');
}else if(!preg_match('/^09[0-9]{8}$/',$_POST['phone'])){//手機格式錯誤
    new HttpStatusCode(400,'手機格式錯誤');
}else if($_POST['phone'] !== $_SESSION['customer']['phone'] && $_POST['phone'] == $phone_fetch['phone']){//此手機號碼已存在
    new HttpStatusCode(400,'此手機號碼已存在');
}else{
	$sql = 'UPDATE customer_data SET `name`=:name, email=:email, phone=:phone WHERE id=:id';
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':id', $_SESSION['customer']['id'], PDO::PARAM_INT);
	$statement->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
	$statement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
	$statement->bindValue(':phone', $_POST['phone'], PDO::PARAM_STR);
	$result = $statement->execute();
	$customer_data= $statement->fetch(PDO::FETCH_ASSOC);
	if($result){
		echo json_encode(['data'=>'修改資料成功。']);
	}else{
		var_dump($pdo->errorInfo());
	}
}
?>