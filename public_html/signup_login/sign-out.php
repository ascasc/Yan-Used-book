<?php
session_start();
unset($_SESSION['customer']);
echo json_encode(['name'=>'成功']);
?>