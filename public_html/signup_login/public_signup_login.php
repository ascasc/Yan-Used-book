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

//姓名是否在資料庫存在
    $sql = 'SELECT name FROM customer_data WHERE name=:name';
    $statement=$pdo->prepare($sql);
    $statement->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
    $statement->execute();
    $name_fetch=$statement->fetch(PDO::FETCH_ASSOC);

//手機是否在資料庫存在
    $sql = 'SELECT phone FROM customer_data WHERE phone=:phone';
    $statement=$pdo->prepare($sql);
    $statement->bindValue(':phone', $_POST['phone'], PDO::PARAM_STR);
    $statement->execute();
    $phone_fetch=$statement->fetch(PDO::FETCH_ASSOC);
//Email與密碼是否在資料庫存在
    $sql = 'SELECT email,password FROM customer_data WHERE email=:email';
    $statement=$pdo->prepare($sql);
    $statement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $statement->execute();
    $fetch=$statement->fetch(PDO::FETCH_ASSOC);
?>