<?php

/**
 * Created by PhpStorm.
 * User: Nio
 * Date: 2020/06/01
 * Time: 10:45
 */

namespace Common\Utils\Sms;

use Common\Models\Sms\SmsLog;
use Common\Utils\Data\DateHelper;
use Common\Utils\Helper;
use Admin\Services\Sms\SmsServer;
use Common\Utils\Curl;
use Yunhan\Utils\Env;

class SmsPesoGlobalHelper {

    use Helper;
    private $_url = "https://api.onbuka.com/v3/sendSms";

    public function getSign($account, $password, $time) {
        return md5($account . $password . $time);
    }

    public function getConfig($sendId) {
        $config = json_decode(env('GLOBAL'), true);
        return $config[$sendId] ?? [];
    }

    public function send($mobile, $eventId, $values, $sendId = 'CashCat') {
        $config = $this->getConfig($sendId);
        $content = SmsServer::server()->getTplByEventId($eventId);
        if (!$content) {
            $content = t($eventId, "sms-peso");
        }
        return $this->sendMarketing($mobile, $content, $values, $sendId, $eventId);
    }

    public function sendMarketing($mobile, $content, $values = [], $sendId = 'CashCat', $eventId = 0) {
        $config = $this->getConfig($sendId);
        $mobile = "2" . substr($mobile, -11);
        foreach ($values as $k => $v) {
            $content = str_replace("{{" . $k . "}}", $v, $content);
        }
        $time = time();
        $sign = self::getSign($config['account'], $config['password'], $time);
        $url = $this->_url;

        $postData = [
            "appId" => $config['app_id'],
            "numbers" => $mobile,
            "content" => urlencode($content),
            "senderId" => $sendId,
        ];
        $json = json_encode($postData);
        $header = [
            'Content-Type: application/json; charset=utf-8',
            'Sign: ' . $sign,
            'Timestamp: ' . $time,
            'Api-Key: ' . $config['account']
//            'Content-Length: ' . strlen($json),
        ];
        $res = Curl::post($json, $url, $header);
        $res = json_decode($res, true);
        $log = [
            "telephone" => $mobile,
            "event_id" => $eventId,
            "send_content" => $content,
            "created_at" => DateHelper::dateTime(),
            "remark" => $sendId,
            "type" => SmsLog::TYPE_SMS,
            "status" => $res['status'] == '0' ? 1 : 0,
            "res" => json_encode($res),
            "msg_id" => $res['array'][0]['msgId'] ?? 0,
            "sms_channel" => "skylinelabs"
        ];
        SmsLog::model()->create($log);
        if ('0' == $res['status']) {
            return true;
        } else {
            return false;
        }
    }

}
