<?php
include('signup_public.php');
if($_POST['email'] == $email_fetch['email']){
    msg_error('此Email已存在');
}else{
    var_dump('此Email可使用');
}
?>