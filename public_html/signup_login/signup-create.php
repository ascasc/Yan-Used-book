<?php
include('public_signup_login.php');
include('../HttpStatusCode.php');
header('Content-Type: application/json; charset=utf-8');

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
}else if($_POST['name'] == $name_fetch['name']){//此名字已存在
    new HttpStatusCode(400,'此姓名已存在');
}else if(!preg_match("/^([\x7f-\xff]+)$/",$_POST['name']) && 
        !preg_match('/^([A-Za-z]+)$/',$_POST['name'])){//此姓名需中文與英文
    new HttpStatusCode(400,'此姓名需中文與英文');
}else if(empty($_POST['email'])){//Email不可為空
    new HttpStatusCode(400,'Email不可為空');
}else if(!$email){//Email格式錯誤
    new HttpStatusCode(400,'Email格式錯誤');
}else if($_POST['email'] == $fetchAll['email']){//此Email已存在
    new HttpStatusCode(400,'此Email已存在');
}else if(empty($_POST['phone'])){//手機不可為空
    new HttpStatusCode(400,'手機不可為空');
}else if(!preg_match('/^09[0-9]{8}$/',$_POST['phone'])){//手機格式錯誤
    new HttpStatusCode(400,'手機格式錯誤');
}else if($_POST['phone'] == $phone_fetch['phone']){//此手機號碼已存在
    new HttpStatusCode(400,'此手機號碼已存在');
}else if(empty($_POST['password']) || preg_match('/\s/',$_POST['password'])){//密碼不可為空
    new HttpStatusCode(400,'密碼不可為空');
}else if(!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8}/', $_POST['password'])){//密碼需大小寫八個以上
    new HttpStatusCode(400,'密碼需大小寫八個以上');
}else if(empty($_POST['two_password'])){//確認密碼不可為空
    new HttpStatusCode(400,'確認密碼不可為空');
}else if($_POST['two_password'] !=$_POST['password']){//確認密碼錯誤
    new HttpStatusCode(400,'確認密碼錯誤');
}else{//inset到資料庫
    $passwordHash = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT,
        ['cost' => 12]
      );
    http_response_code(200);
    $sql = 'INSERT INTO customer_data (name,email, phone, password) VALUES(:name, :email, :phone, :password)';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
    $statement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $statement->bindValue(':phone', $_POST['phone'], PDO::PARAM_STR);
    $statement->bindValue(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));
    $result =$statement->execute();
    if($result){
        echo json_encode(['name'=>'註冊成功'], JSON_NUMERIC_CHECK);
    }else{
        var_dump($pdo->errorInfo());
    }
}
?>