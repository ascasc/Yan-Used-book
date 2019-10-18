<?php
session_start();
$login_status;
$login_level;
if(isset($_SESSION['customer'])){
    if($_SESSION['customer']['m_level'] == 'member'){
        $login_level ='member';
        $login_status ='On';
    }else if($_SESSION['customer']['m_level'] == 'admin'){
        $login_level ='admin';
        $login_status ='On';
    }else{
        $login_level ='';
        $login_status ='Off';
    }
}else if(!isset($_SESSION['customer'])){
    $login_status ='Off';
}
?>
<script>
    var login_status= <?= json_encode($login_status, JSON_NUMERIC_CHECK);?>;
</script>