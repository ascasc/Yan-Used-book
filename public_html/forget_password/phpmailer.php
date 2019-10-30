<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    // Load Composer's autoloader
    require 'forget_password/vendor/autoload.php';
    include('../db.php');
    include('signup_login/public_signup_login.php');
    header('Content-Type: text/html; charset=UTF-8');
    if(empty($_POST['email'])){//Email不可為空
        echo '<div class="error-msg open">
                <div class="alert alert-danger">Email不可為空</div>
             </div><br>
             <center><input type ="button" onclick="window.history.back()" value="回到上一頁"></input></center>';
    }else if(!$email){//Email格式錯誤
        echo '<div class="error-msg open">
                <div class="alert alert-danger">Email格式錯誤</div>
             </div>
             <center><input type ="button" onclick="window.history.back()" value="回到上一頁"></input></center>';
    }else if($_POST['email'] != $fetch['email']){//此Email不存在
        echo '<div class="error-msg open">
                <div class="alert alert-danger">此Email不存在</div>
             </div>
             <center><input type ="button" onclick="window.history.back()" value="回到上一頁"></input></center>';
    }else{
        $mail = new PHPMailer(true);
        //Server settings
        $mail->SMTPDebug = 0;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = '';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = '';                     // SMTP username
        $mail->Password   = '';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 25;                                    // TCP port to connect to
        $mail->CharSet = 'utf8';
    
        //Recipients
        $mail->setFrom('asc824@gmail.com', 'Yan二手書店');
        $mail->addAddress($_POST['email'], $fetch['name']);     // Add a recipient
    
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Yan二手書店重置密碼';
        $mail->Body    = $fetch['password'];
        $mail->AltBody = '附加內容文字';
        if($mail->send()){
            echo '<center>
                    <div class="error-msg open">
                        <div class="alert alert-danger">將重置密碼傳入您的信箱，請進入信箱後重置密碼。
                    </div>
                    <input onclick="window.close();" value="關閉視窗" type="button">
                  </center>';
            
        }else{
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    ?>
</body>
</html>

