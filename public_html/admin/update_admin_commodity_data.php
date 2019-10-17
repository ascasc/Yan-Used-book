<?php
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

if(empty($_POST['email'])){//Email不可為空
    new HttpStatusCode(400,'Email不可為空');
}else if(!$email){//Email格式錯誤
    new HttpStatusCode(400,'Email格式錯誤');
}else if($_POST['email'] == $fetchAll['email']){//此Email已存在
    new HttpStatusCode(400,'此Email已存在');
}else{
	$sql = 'UPDATE customer_data set email=:email WHERE id=:id';
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
	$statement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
	$result = $statement->execute();
	
	$sql = 'SELECT * FROM customer_data ORDER BY id ASC';
	$statement = $pdo->prepare($sql);
	$statement->execute();
	$admin_update_customer_datas= $statement->fetchAll(PDO::FETCH_ASSOC);
	if($result){
		echo json_encode(['id'=>$_POST['id'],'email'=>$_POST['email'],'data'=>$admin_update_customer_datas]);
	}else{
		var_dump($pdo->errorInfo());
	}
}
?>