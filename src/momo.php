<?php

namespace Gadev\Momo;

class Momo
{


    /**
     * @var string $phone
     */
    private string $phone;

    /**
     * @var string $password
     */
    private string $pasword;

    /**
     * @var string $device
     */
    private string $device;

    /**
     * @var string $imei
     */
    private string $imei;

    /**
     * @var string $time
     */
    private string $time;

    /**
     * @var string $hardware
     */
    private string $hardware;

    /**
     * @var string $facture
     */
    private string $facture;

    /**
     * @var string $SECUREID
     */
    private string $SECUREID;

    /**
     * @var string $rkey
     */
    private string $rkey;

    /**
     * @var string $AAID
     */
    private string $AAID;

    /**
     * @var string $TOKEN
     */
    private string $TOKEN;

    /**
     * @var string $MODELID
     */
    private string $MODELID;

    /**
     * @var string $keys
     */
    private string $keys;

    /**
     * @var string $setupKeyDecrypt
     */
    private string $setupKeyDecrypt;

    /**
     * @var string $sessionkey
     */
    private string $sessionkey;

    /**
     * @var string $agent_id
     */
    private string $agent_id;

    /**
     * @var string $authorization
     */
    private string $authorization;

    /**
     * @var string $refreshToken
     */
    private string $refreshToken;



    private array $msgType = [
        "SEND_OTP_MSG" => "https://api.momo.vn/backend/otp-app/public/SEND_OTP_MSG",
        "REG_DEVICE_MSG" => "https://api.momo.vn/backend/otp-app/public/REG_DEVICE_MSG",
        "USER_LOGIN_MSG" => "https://owa.momo.vn/public/login",
        "CHECK_USER_BE_MSG" => "https://api.momo.vn/backend/auth-app/public/CHECK_USER_BE_MSG",
        "QUERY_TRAN_HIS_MSG_NEW" => "https://m.mservice.io/hydra/v2/user/noti",
        "GENERATE_TOKEN_AUTH_MSG" => "https://api.momo.vn/backend/auth-app/public/GENERATE_TOKEN_AUTH_MSG",
    ];


    private array $momoConfig = [
        "appVer" => 40024,
        "appCode" => "4.0.2"
    ];


    public function __construct(string $phone, string $password)
    {
        $this->phone = $phone;
        $this->password = $password;
        $this->time = $this->microtime() . '000000';
    }

    /**
     * Tạo request gửi OTP đến số điện thoại
     *
     * @return bool|string
     */
    public function sendOTP()
    {

        $header = array(
            "agent_id: undefined",
            "sessionkey:",
            "user_phone: undefined",
            "authorization: Bearer undefined",
            "msgtype: SEND_OTP_MSG",
            "Host: api.momo.vn",
            "User-Agent: okhttp/3.14.17",
            "app_version: " . $this->momoConfig["appVer"],
            "app_code: " . $this->momoConfig["appCode"],
            "device_os: Android"
        );

        $body = array(
            'user' => $this->phone,
            'msgType' => 'SEND_OTP_MSG',
            'cmdId' => (string)$this->time . '000000',
            'lang' => 'vi',
            'time' => $this->time,
            'channel' => 'APP',
            'appVer' => $this->momoConfig["appVer"],
            'appCode' => $this->momoConfig["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' => array(
                '_class' => 'mservice.backend.entity.msg.RegDeviceMsg',
                'number' => $this->phone,
                'imei' => $this->imei,
                'cname' => 'Vietnam',
                'ccode' => '084',
                'device' => $this->device,
                'firmware' => '23',
                'hardware' => $this->hardware,
                'manufacture' => $this->facture,
                'csp' => '',
                'icc' => '',
                'mcc' => '452',
                'device_os' => 'Android',
                'secure_id' => $this->SECUREID,
            ),
            'extra' => array(
                'action' => 'SEND',
                'rkey' => $this->rkey,
                'AAID' => $this->AAID,
                'IDFA' => '',
                'TOKEN' => $this->TOKEN,
                'SIMULATOR' => '',
                'SECUREID' => $this->SECUREID,
                'MODELID' => $this->MODELID,
                'isVoice' => false,
                'REQUIRE_HASH_STRING_OTP' => true,
                'checkSum' => '',
            ),
        );

        return $this->CURL_MOMO("SEND_OTP_MSG", $header, $body);
    }

    /**
     * Xác thực mã otp
     *
     * @return bool|string
     */
    public function verifyOTP($otp)
    {

        $oHash = hash('sha256', $this->phone . $this->rkey . $otp);

        $header = array(
            "agent_id: undefined",
            "sessionkey:",
            "user_phone: undefined",
            "authorization: Bearer undefined",
            "msgtype: REG_DEVICE_MSG",
            "Host: api.momo.vn",
            "User-Agent: okhttp/3.14.17",
            "app_version: " . $this->momoConfig["appVer"],
            "app_code: " . $this->momoConfig["appCode"],
            "device_os: ANDROID"
        );

        $body = array(
            "user" => $this->phone,
            "msgType" => "REG_DEVICE_MSG",
            "cmdId" => $this->time,
            "lang" => "vi",
            "time" => $this->time,
            "channel" => "APP",
            "appVer" => $this->momoConfig["appVer"],
            "appCode" => $this->momoConfig["appCode"],
            "deviceOS" => "ANDROID",
            "buildNumber" => 0,
            "appId" => "vn.momo.platform",
            "result" => true,
            "errorCode" => 0,
            "errorDesc" => "",
            "momoMsg" => array(
                "_class" => "mservice.backend.entity.msg.RegDeviceMsg",
                "number" => $this->phone,
                "imei"   => $this->imei,
                "cname"  => "Vietnam",
                "ccode"  => "084",
                "device" => $this->device,
                "firmware" => "23",
                "hardware" => $this->hardware,
                "manufacture" => $this->facture,
                "csp" => "",
                "icc" => "",
                "mcc" => "",
                "device_os" => "Android",
                "secure_id" => $this->SECUREID
            ),
            "extra" => array(
                "ohash" => $oHash,
                "AAID"  => $this->AAID,
                "IDFA" => "",
                "TOKEN"  => $this->TOKEN,
                "SIMULATOR" => "",
                "SECUREID" => $this->SECUREID,
                "MODELID" => $this->MODELID,
                "checkSum" => ""
            )
        );
        return $this->CURL_MOMO("REG_DEVICE_MSG", $header, $body);
    }

    /**
     * Đăng nhập momo
     *
     * @return bool|string
     */
    public function loginMomo()
    {
        $header = array(
            "agent_id: " . $this->agent_id,
            "user_phone: " . $this->phone,
            "sessionkey: " . (!empty($this->sessionkey)) ? $this->sessionkey : "",
            "authorization: Bearer " . $this->authorization,
            "msgtype: USER_LOGIN_MSG",
            "Host: owa.momo.vn",
            "user_id: " . $this->phone,
            "User-Agent: okhttp/3.14.17",
            "app_version: " . $this->momoConfig["appVer"],
            "app_code: " . $this->momoConfig["appCode"],
            "device_os: Android"
        );
        $body = array(
            'user' => $this->phone,
            'msgType' => 'USER_LOGIN_MSG',
            'pass' => $this->password,
            'cmdId' => $this->time,
            'lang' => 'vi',
            'time' => $this->time,
            'channel' => 'APP',
            'appVer' => $this->momoConfig["appVer"],
            'appCode' => $this->momoConfig["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
            array(
                '_class' => 'mservice.backend.entity.msg.LoginMsg',
                'isSetup' => false,
            ),
            'extra' =>
            array(
                'pHash' => $this->get_pHash(),
                'AAID' => $this->AAID,
                'IDFA' => '',
                'TOKEN' => $this->TOKEN,
                'SIMULATOR' => '',
                'SECUREID' => $this->SECUREID,
                'MODELID' => $this->MODELID,
                'checkSum' => $this->generateCheckSum('USER_LOGIN_MSG', $this->time),
            ),
        );
        return $this->CURL_MOMO("USER_LOGIN_MSG", $header, $body);
    }

    /**
     * Kiểm tra tên người dùng momoMsg
     * 
     * @return bool|string
     */
    public function checkHistoryMomo($hours)
    {
        $begin = (time() - (3600 * $hours)) * 1000;
        $header = array(
            "authorization: Bearer " . $this->authorization,
            "user_phone: " . $this->phone,
            "sessionkey: " . $this->sessionkey,
            "agent_id: " . $this->agent_id,
            'app_version: ' . $this->momoConfig["appVer"],
            'app_code: ' . $this->momoConfig["appCode"],
            "Host: m.mservice.io"
        );
        $body = '{
            "userId": "' . $this->phone . '",
            "fromTime": ' . $begin . ',
            "toTime": ' . $this->microtime() . ',
            "limit": 50,
            "cursor": "",
            "cusPhoneNumber": ""
        }';

        $result = $this->CURL_MOMO("QUERY_TRAN_HIS_MSG_NEW", $header, $body);
        $result = json_decode($result, true);
        if (!is_array($result)) {
            return array(
                "status" => "error",
                "code" => -5,
                "message" => "Hết thời gian truy cập vui lòng đăng nhập lại"
            );
        }
        $tranHisMsg = $result["message"]["data"]["notifications"];
        $return = array();
        foreach ($tranHisMsg as $value) {
            if ($value["refId"] == 'receive_money_p2p' || $value["refId"] == 'LuckyMoneyPreviewDetail') {
                $extra = json_decode($value["extra"], true);
                $amount = $value['caption'];
                $name = explode("từ", $amount)[1] ?: "";
                if (strpos($amount, "Nhận") !== false && $name) {
                    preg_match('#Nhận (.+?)đ#is', $amount, $amount);
                    $amount = str_replace(".", "", $amount[1]) > 0 ? str_replace(".", "", $amount[1]) : '0';
                    $comment = $value['body'];
                    $comment = ltrim($comment, '"');
                    $comment = explode('"', $comment);
                    $comment = $comment[0];
                    if ($comment == "Nhấn để xem chi tiết.") {
                        $comment = "";
                    }
                    $return[] = array(
                        "tranId" => $value["tranId"],
                        "ID" => $value["ID"],
                        "patnerID" => $value["sender"],
                        "partnerName" => trim($name),
                        "comment" => $comment,
                        "amount" => (int)$amount,
                        "millisecond" => $value["time"]
                    );
                }
            }
        }
        return array('status' => 'success', 'data' => $return);
    }

    /**
     * Lấy lại token đăng nhập
     * 
     * @return bool|string
     */
    public function refreshTokenMomo() {
        $header = array(
            "agent_id: " . $this->agent_id,
            "user_phone: " . $this->phone,
            "sessionkey: " . (!empty($this->sessionkey)) ? $this->sessionkey : "",
            "authorization: Bearer " . $this->authorization,
            "msgtype: GENERATE_TOKEN_AUTH_MSG",
            "Host: api.momo.vn",
            "user_id: " . $this->phone,
            "User-Agent: MoMoPlatform-Release/31062 CFNetwork/1325.0.1 Darwin/21.1.0",
            "app_version: " . $this->momoConfig["appVer"],
            "app_code: " . $this->momoConfig["appCode"],
            "device_os: Android"
        );
        $body = array(
            'user' => $this->phone,
            'msgType' => 'GENERATE_TOKEN_AUTH_MSG',
            'cmdId' => $this->time,
            'lang' => 'vi',
            'time' => $this->time,
            'channel' => 'APP',
            'appVer' => $this->momoConfig["appVer"],
            'appCode' => $this->momoConfig["appCode"],
            'deviceOS' => 'ANDROID',
            'buildNumber' => 0,
            'appId' => 'vn.momo.platform',
            'result' => true,
            'errorCode' => 0,
            'errorDesc' => '',
            'momoMsg' =>
                array(
                    '_class' => 'mservice.backend.entity.msg.RefreshTokenMsg',
                    'refreshToken' => $this->refreshToken,
                ),
            'extra' =>
                array(
                    'pHash' => $this->get_pHash(),
                    'AAID' => $this->AAID,
                    'IDFA' => '',
                    'TOKEN' => $this->TOKEN,
                    'SIMULATOR' => '',
                    'SECUREID' => $this->SECUREID,
                    'MODELID' => $this->MODELID,
                    'checkSum' => $this->generateCheckSum('GENERATE_TOKEN_AUTH_MSG', $this->time),
                ),
        );
        return $this->CURL_MOMO("GENERATE_TOKEN_AUTH_MSG", $header, $body);
    }

    /**
     * Tạo info mới cho momo
     *
     * @return bool|string
     */
    public function generateInfo()
    {
        return json_encode(array(
            'message' => 'Lấy info momo thành công',
            'data' => array(
                'phone' => $this->phone,
                'password' => $this->password,
                'imei' => $this->generateUUID(),
                'device' => $this->randomDevice()['device'],
                'hardware' => $this->randomDevice()['hardware'],
                'MODELID' => $this->randomDevice()['MODELID'],
                'facture' => $this->randomDevice()['facture'],
                'SECUREID' => $this->get_SECUREID(),
                'rkey' => $this->generateRandom(20),
                'AAID' => $this->generateUUID(),
                'TOKEN' => $this->get_TOKEN(),
            )
        ));
    }

    public function changeInfo($info)
    {
        foreach ($info as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Tạo curl đến momo
     *
     * @return string
     */

    private function CURL_MOMO($Action, $header, $data)
    {
        $Data = is_array($data) ? json_encode($data) : $data;
        $curl = curl_init();
        // echo strlen($Data); die;
        $header[] = 'Content-Type: application/json';
        $header[] = 'accept: application/json';
        $header[] = 'Content-Length: ' . strlen($Data);
        $opt = array(
            CURLOPT_URL => $this->msgType[$Action],
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST => empty($data) ? FALSE : TRUE,
            CURLOPT_POSTFIELDS => $Data,
            CURLOPT_CUSTOMREQUEST => empty($data) ? 'GET' : 'POST',
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_ENCODING => "",
            CURLOPT_HEADER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_TIMEOUT => 20,
        );
        curl_setopt_array($curl, $opt);
        $body = curl_exec($curl);
        // echo strlen($body); die;
        if (is_object(json_decode($body))) {
            return $body;
        }
        return $this->Decrypt_data($body);
    }

    /**
     * Decode response momo
     *
     * @return string
     */
    public function Decrypt_data($data)
    {

        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return openssl_decrypt(base64_decode($data), 'AES-256-CBC', $this->keys, OPENSSL_RAW_DATA, $iv);
    }

    /**
     * Tạo UUID cho imei
     *
     * @return string
     */
    private function generateUUID(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    public function generateCheckSum($type, $microtime)
    {
        $Encrypt = $this->phone . $microtime . '000000' . $type . ($microtime / 1000000000000.0) . 'E12';
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return base64_encode(openssl_encrypt($Encrypt, 'AES-256-CBC', $this->setupKeyDecrypt, OPENSSL_RAW_DATA, $iv));
    }

    private function get_pHash()
    {
        $key = $this->imei . "|" . $this->password;
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return base64_encode(openssl_encrypt($key, 'AES-256-CBC', $this->setupKeyDecrypt, OPENSSL_RAW_DATA, $iv));
    }


    /**
     * Tạo microtime
     *
     * @return string
     */
    private function microtime(): string
    {
        $arr = explode(' ', microtime());

        return bcadd(($arr[0] * 1000), bcmul($arr[1], 1000));
    }

    /**
     * Tạo random string length
     * 
     * @return string
     */
    public function generateRandom($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Tạo random token length
     * 
     * @return string
     */
    public function get_TOKEN()
    {
        return $this->generateRandom(22) . ':' . $this->generateRandom(9) . '-' . $this->generateRandom(20) . '-' . $this->generateRandom(12) . '-' . $this->generateRandom(7) . '-' . $this->generateRandom(7) . '-' . $this->generateRandom(53) . '-' . $this->generateRandom(9) . '_' . $this->generateRandom(11) . '-' . $this->generateRandom(4);
    }

    /**
     * Tạo random SECUREID length
     * 
     * @return string
     */
    public function get_SECUREID($length = 17)
    {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function randomDevice()
    {
        $data = array(
            array('device' => 'SM-G532F', 'hardware' => 'mt6735', 'facture' => 'samsung', 'MODELID' => 'samsung sm-g532gmt6735r58j8671gsw'),
            array('device' => 'SM-A102U', 'hardware' => 'a10e', 'facture' => 'Samsung', 'MODELID' => 'Samsung SM-A102U'),
            array('device' => 'SM-A305FN', 'hardware' => 'a30', 'facture' => 'Samsung', 'MODELID' => 'Samsung SM-A305FN'),
            array('device' => 'HTC One X9 dual sim', 'hardware' => 'htc_e56ml_dtul', 'facture' => 'HTC', 'MODELID' => 'HTC One X9 dual sim'),
            array('device' => 'HTC 7060', 'hardware' => 'cp5dug', 'facture' => 'HTC', 'MODELID' => 'HTC HTC_7060'),
            array('device' => 'HTC D10w', 'hardware' => 'htc_a56dj_pro_dtwl', 'facture' => 'HTC', 'MODELID' => 'HTC htc_a56dj_pro_dtwl'),
            array('device' => 'Oppo realme X Lite', 'hardware' => 'RMX1851CN', 'facture' => 'Oppo', 'MODELID' => 'Oppo RMX1851'),
            array('device' => 'MI 9', 'hardware' => 'equuleus', 'facture' => 'Xiaomi', 'MODELID' => 'Xiaomi equuleus'),
        );

        // $device = mt_rand(0, count($data) - 1);

        return $data[rand(0, count($data) - 1)];
    }

    public function get_setupKey($setUpKey, $ohash)
    {
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return openssl_decrypt(base64_decode($setUpKey), 'AES-256-CBC', $ohash, OPENSSL_RAW_DATA, $iv);
    }
}
