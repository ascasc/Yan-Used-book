<?php
    // 電子地圖
    define('HOME_URL', 'http://54.238.100.136/');
    require('Ecpay.Logistic.Integration.php');
    try {
        $AL = new EcpayLogistics();
        $AL->Send = array(
            'MerchantID' => '3144304',
            'MerchantTradeNo' => 'no' . date('YmdHis'),
            'LogisticsSubType' => EcpayLogisticsSubType::UNIMART,
            'IsCollection' => EcpayIsCollection::NO,
            'ServerReplyURL' => HOME_URL . '/ecpay/Ｍap_data.php',
            'ExtraData' => '測試額外資訊',
            'Device' => EcpayDevice::PC
        );
        // CvsMap(Button名稱, Form target)
        $html = $AL->CvsMap('電子地圖(統一)');
        echo $html;
    } catch(Exception $e) {
        echo $e->getMessage();
    }
?>
