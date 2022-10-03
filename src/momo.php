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


    private array $msgType = [
        "SEND_OTP_MSG" => "https://api.momo.vn/backend/otp-app/public/SEND_OTP_MSG",
        "REG_DEVICE_MSG" => "https://api.momo.vn/backend/otp-app/public/REG_DEVICE_MSG",
        "USER_LOGIN_MSG" => "https://owa.momo.vn/public/login",
    ];


    private array $momoConfig = [
        "appVer" => 40024,
        "appCode" => "4.0.2"
    ];


    public function __construct(string $phone, string $password, string $device, string $hardware, string $facture, string $SECUREID, string $MODELID)
    {
        $this->phone = $phone;
        $this->password = $password;
        $this->imei = $this->generateUUID();
        $this->time = $this->microtime();
        $this->device = $device;
        $this->hardware = $hardware;
        $this->SECUREID = $SECUREID;
        $this->rkey = $this->generateRandom(20);
        $this->AAID = $this->generateUUID();
        $this->TOKEN = $this->get_TOKEN();
        $this->MODELID = $MODELID;
        $this->facture = $facture;
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
        $oHash = hash('sha256', $this->phone . $this->imei . $otp);

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
}
