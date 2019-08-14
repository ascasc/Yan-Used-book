<?php
include('../../../db.php');
header('Content-Type: application/json; charset=utf-8');
try{
    $pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]",$db['username'],$db['password']);
}catch(PDOException $e){
    echo "Database connection failed.";
    exit;
}


$email=filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);//驗證email

//姓名是否在資料存在
$sql = 'SELECT name FROM customer_data WHERE name=:name';
$statement=$pdo->prepare($sql);
$statement->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
$statement->execute();
$name_fetch=$statement->fetch(PDO::FETCH_ASSOC);

//Email是否在資料存在
$sql = 'SELECT email, password FROM customer_data WHERE email=:email';
$statement=$pdo->prepare($sql);
$statement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
$statement->execute();
$fetch=$statement->fetch(PDO::FETCH_ASSOC);

function msg_error($msg){
    http_response_code(400);
    echo $msg;
}
?>