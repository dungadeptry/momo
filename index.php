<?php


require_once 'vendor/autoload.php';


// $momo = new Gadev\Momo\Momo('phone', 'password', 'device', 'hardware, 'facture, 'SECUREID, 'MODELID');

$momo = new Gadev\Momo\Momo('0395562711', '111111', '2', 'SM-G532F', 'mt6735', 'samsung', 'samsung sm-g532gmt6735r58j8671gsw');

print_r($momo->sendOTP());
