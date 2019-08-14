<?php
include('../../../db.php');
header('Content-Type: application/json; charset=utf-8');
try{
    $pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]",$db['username'],$db['password']);
}catch(PDOException $e){
    echo "Database connection failed.";
    exit;
}
function msg_error($msg){
    http_response_code(400);
    echo $msg;
}

$email=filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);//驗證email
//Email是否在資料存在
$sql = 'SELECT email, password FROM customer_data WHERE email=:email';
$statement=$pdo->prepare($sql);
$statement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
$statement->execute();
$fetch=$statement->fetch(PDO::FETCH_ASSOC);

if(empty($_POST['email'])){//Email不可為空
    msg_error('Email不可為空');
}else if(!$email){//Email格式錯誤
    msg_error('Email格式錯誤');
}else if($_POST['email'] !== $fetch['email']){//此Email已存在
    msg_error('Email錯誤');
}else if(empty($_POST['password']) || preg_match('/\s/',$_POST['password'])){//密碼不可為空
    msg_error('密碼不可為空');
}else if(password_verify($_POST['password'], $fetch['password'])){
    var_dump('成功');
}else{
    var_dump('失敗');
}
?>