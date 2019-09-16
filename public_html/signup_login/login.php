<?php
include('public_signup_login.php');
include('../HttpStatusCode.php');
header('Content-Type: application/json; charset=utf-8');

if(empty($_POST['email'])){//Email不可為空
    new HttpStatusCode(400, 'Email不可為空');
}else if(!$email){//Email格式錯誤
    new HttpStatusCode(400, 'Email格式錯誤');
}else if($_POST['email'] !== $fetch['email']){//此Email已存在
    new HttpStatusCode(400, 'Email錯誤');
}else if(empty($_POST['password']) || preg_match('/\s/',$_POST['password'])){//密碼不可為空
    new HttpStatusCode(400, '密碼不可為空');
}else if(!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8}/', $_POST['password'])){//密碼需大小寫八個以上
    new HttpStatusCode(400, '密碼需大小寫八個以上');
}else if($fetch['email'] && password_verify($_POST['password'], $fetch['password'])){
    session_start();
    //Email與密碼是否在資料庫存在
    $sql = 'SELECT * FROM customer_data WHERE email=:email';
    $statement=$pdo->prepare($sql);
    $statement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $statement->execute();
    $fetchAll=$statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($fetchAll as $key => $row) {
        $_SESSION['customer'] = [
            'name'=>$row['name'],
            'email'=>$row['email'],
            'phone'=>$row['phone'],
            'm_level'=>$row['m_level'],
        ];
    }
    echo json_encode(['name'=>'登入成功']); 
    
}else{
    new HttpStatusCode(400, '密碼錯誤');
}
?>