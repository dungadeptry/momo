<?php


require_once 'vendor/autoload.php';


$momo = new Gadev\Momo\Momo($phone, $password);

// $info = $momo->generateInfo();
// $info = json_encode(json_decode($info)->data);
// file_put_contents('0564744920.json', $info);

$infoPhone = file_get_contents('0564744920.json');
$info = json_decode($infoPhone, true);



// var_dump($momo->sendOTP());

// $otp = '7139';

// $result = $momo->verifyOTP($otp);

// $dataNew = array();

// foreach($info as $key => $value) {
//     $dataNew[$key] = $value;
// }

// $dataNew['setupKey'] = json_decode($result)->extra->setupKey;
// $dataNew['setupKeyDecrypt'] = $momo->get_setupKey(json_decode($result)->extra->setupKey, json_decode($result)->extra->ohash);

// file_put_contents('0564744920.json', json_encode($dataNew));

// var_dump($result);


// foreach($info as $key => $value) {
//     $dataNew[$key] = $value;
// }

// $dataNew['agent_id'] = "";
// $dataNew['sessionkey'] = "";
// $dataNew['authorization'] = "";

// $momo->changeInfo($dataNew);


// $result = $momo->loginMomo();

// foreach($info as $key => $value) {
//     $dataNew[$key] = $value;
// }

// $dataNew['authorization'] = json_decode($result)->extra->AUTH_TOKEN;
// $dataNew['RSA_PUBLIC_KEY'] = json_decode($result)->extra->REQUEST_ENCRYPT_KEY;
// $dataNew['sessionkey'] = json_decode($result)->extra->SESSION_KEY;
// $dataNew['balance'] = json_decode($result)->extra->BALANCE;
// $dataNew['agent_id'] = json_decode($result)->momoMsg->agentId;
// $dataNew['BankVerify'] = json_decode($result)->momoMsg->bankVerifyPersonalid;
// $dataNew['name'] = json_decode($result)->momoMsg->name;
// $dataNew['refreshToken'] = json_decode($result)->extra->REFRESH_TOKEN;

// file_put_contents('0564744920.json', json_encode($dataNew));

// var_dump(json_decode($info)->data);

// var_dump($momo->sendOTP());



/** LẤY LẠI TOKEN ĐĂNG NHẬP */

// $momo->changeInfo($info);
// $result = $momo->refreshTokenMomo();
// var_dump($result);

// foreach($info as $key => $value) {
//     $dataNew[$key] = $value;
// }

// $dataNew['authorization'] = json_decode($result)->extra->AUTH_TOKEN;
// $dataNew['RSA_PUBLIC_KEY'] = json_decode($result)->extra->REQUEST_ENCRYPT_KEY;

// file_put_contents('0564744920.json', json_encode($dataNew));

/** LẤY THÔNG TIN TÊN MOMO */

$momo->changeInfo($info);
$result = $momo->checkMoney();

$json = json_decode($result, true);

$first = $json['momoMsg']['transactions'][0];

// foreach($json['momoMsg']['transactions'] as $gadev) {
//     if ($gadev == reset($array)) {
//         echo 'AAA';
//     }
// }
// var_dump($first['moneySourceAmount']);

// if (empty(json_decode($result)->errorCode)) {
//     $receiver = array(
//         'comment' => 'test',
//         'amount' => 100,
//         'receiver' => '0564744920',
//         'partnerName' => json_decode($result)->extra->NAME
//     );

//     $resultCreateTransferMoney = $momo->createTransferMoney($receiver);


//     $id = json_decode($resultCreateTransferMoney, true)['momoMsg']['replyMsgs'][0]['ID'];


//     $resultComfirmTransfer = $momo->transferMoney($id, $receiver);

//     var_dump($resultComfirmTransfer);
// }

// foreach($info as $key => $value) {
//     $dataNew[$key] = $value;
// }

// $dataNew['authorization'] = json_decode($result)->extra->AUTH_TOKEN;
// $dataNew['RSA_PUBLIC_KEY'] = json_decode($result)->extra->REQUEST_ENCRYPT_KEY;
