<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include('../../../db.php');
include('../signup_login/public_signup_login.php');
include('../HttpStatusCode.php');

try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}

$sql = 'SELECT `password` FROM customer_data WHERE id=:id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $_SESSION['customer']['id'], PDO::PARAM_INT);
$statement->execute();
$customer_data= $statement->fetch(PDO::FETCH_ASSOC);

if(empty($_POST['now_password']) || preg_match('/\s/',$_POST['now_password'])){//目前密碼不可為空
    new HttpStatusCode(400, '目前密碼不可為空');
}else if(!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8}/', $_POST['now_password'])){//目前密碼需大小寫八個以上
    new HttpStatusCode(400, '目前密碼需大小寫八個以上');
}else if(!password_verify($_POST['now_password'], $customer_data['password'])){//目前密碼錯誤
	new HttpStatusCode(400, '目前密碼錯誤');
}else if(empty($_POST['password']) || preg_match('/\s/',$_POST['password'])){//修改密碼不可為空
	new HttpStatusCode(400, '修改密碼不可為空');
}else if(!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8}/', $_POST['password'])){//修改密碼需大小寫八個以上
    new HttpStatusCode(400, '修改密碼需大小寫八個以上');
}else if(empty($_POST['two_password']) || preg_match('/\s/',$_POST['tow_password'])){
    new HttpStatusCode(400, '確認密碼不可為空');
}else if($_POST['password'] !== $_POST['two_password']){
    new HttpStatusCode(400, '確認密碼錯誤');
}else{
	$passwordHash = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT,
        ['cost' => 12]
      );
    $sql = 'UPDATE customer_data SET `password`=:password WHERE id=:id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $_SESSION['customer']['id'], PDO::PARAM_INT);
    $statement->bindValue(':password', $passwordHash, PDO::PARAM_STR);
    $result =$statement->execute();
    if($result){
        echo json_encode(['data'=>'修改密碼成功',$_POST['password']]);
    }else{
        var_dump($pdo->errorInfo());
    }
}
?>