<?php
include('signup_public.php');
header('Content-Type: application/json; charset=utf-8');
$email=filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
if(empty($_POST['name'])){//姓名不可為空
    msg_error('姓名不可為空');
}else if(mb_strlen($_POST['name'])<2){//姓名需兩個字以上
    msg_error('姓名需兩個字以上');
}else if($_POST['name'] == $name_fetch['name']){//此名字已存在
    msg_error('此姓名已存在');
}else if(!preg_match("/^([\x7f-\xff]+)$/",$_POST['name']) && !preg_match('/^([A-Za-z]+)$/',$_POST['name'])){//此姓名需中文與英文
    msg_error('此姓名需中文與英文');
}else if(empty($_POST['email'])){//Email不可為空
    msg_error('Email不可為空');
}else if(!$email){//Email格式錯誤
    msg_error('Email格式錯誤');
}else if($_POST['email'] == $email_fetch['email']){//此Email已存在
    msg_error('此Email已存在');
}else if(empty($_POST['phone'])){//手機不可為空
    msg_error('手機不可為空');
}else if(!preg_match('/^09[0-9]{8}$/',$_POST['phone'])){//手機格式錯誤
    msg_error('手機格式錯誤');
}else if(empty($_POST['password'])){//密碼不可為空
    msg_error('密碼不可為空');
}else if(!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8}/', $_POST['password'])){//密碼需大小寫八個以上
    msg_error('密碼需大小寫八個以上');
}else if(empty($_POST['two_password'])){//確認密碼不可為空
    msg_error('確認密碼不可為空');
}else if($_POST['two_password'] !=$_POST['password']){//確認密碼錯誤
    msg_error('確認密碼錯誤');
}else{//inset到資料庫
    http_response_code(200);
    $sql = 'INSERT INTO customer_data (name,email,password) VALUES(:name,:email,:password)';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
    $statement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $statement->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
    $result =$statement->execute();
    if($result){
        echo json_encode(['name'=>'註冊成功'], JSON_NUMERIC_CHECK);
    }else{
        var_dump($pdo->errorInfo());
    }
}
?>