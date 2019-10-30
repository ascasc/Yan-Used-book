<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
</head>
<body>
    <?php
        include('../../db.php');
        header('Content-Type: text/html; charset=UTF-8');
        try {
            $pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
        } catch (PDOException $e) {
            echo "Database connection failed.";
            exit;
        }

        function alert($message,$history){
            echo '<center>
                    <div class="error-msg open">
                        <div class="alert alert-danger">'.$message.'</div>
                    </div><br>';
            if($history == 'back'){
                echo '<input type ="button" onclick="window.history.back()" value="回到上一頁"></input>
                      </center>';
            }else if($history =='close'){
                echo '<input type ="button" value="關閉視窗" id="close"></input>
                </center>';
            }

        }if(empty($_POST['reset_password']) || preg_match('/\s/',$_POST['reset_password'])){//重置密碼不可為空
             alert('重置密碼不可為空','back');
        }else if(!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8}/', $_POST['reset_password'])){//重置密碼需大小寫八個以上
             alert('重置密碼需大小寫八個以上','back');
        }else if(empty($_POST['two_reset_password']) || preg_match('/\s/',$_POST['tow_reset_password'])){
             alert('確認重置密碼不可為空','back');
        }else if($_POST['reset_password'] !== $_POST['two_reset_password']){
             alert('確認重置密碼錯誤','back');
        }else{
            $passwordHash = password_hash(
                $_POST['two_reset_password'],
                PASSWORD_DEFAULT,
                ['cost' => 12]
              );
            $sql = 'UPDATE customer_data SET `password`=:two_reset_password WHERE password=:password';
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
            $statement->bindValue(':two_reset_password', $passwordHash, PDO::PARAM_STR);
            $result =$statement->execute();
            if($result){
                echo alert('重置密碼成功','close');
            }else{
                var_dump($pdo->errorInfo());
            }
        }
    ?>
<script>
    $('#close').on('click', function (e) {
        window.location.href="about:blank";
        window.close();
    });
</script>
</body>
</html>