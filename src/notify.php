<?php
/**
 * 微信回调接口,接收component_verify_ticket,authorization_code,unauthorized等信息
 */

include_once "./decrypt/wxBizMsgCrypt.php";
include_once "constant.php";

class notify
{
    const TICKET = 'component_verify_ticket';
    const UNAUTHORIZED = 'unauthorized';
    const SUCCESS_CODE = 'success';

    public function WechatCallback()
    {
        //解密
        $wx = new WXBizMsgCrypt(constants::token, constants::encodingAesKey, constants::appId);
        $encryptMsg = file_get_contents('php://input');
        $xml_tree = new DOMDocument();
        $xml_tree->loadXML($encryptMsg);
        $array_encrypt = $xml_tree->getElementsByTagName('Encrypt');
        $array_signature = $xml_tree->getElementsByTagName('MsgSignature');
        $encrypt = $array_encrypt->item(0)->nodeValue;
        $msg_sign = $array_signature->item(0)->nodeValue;

        $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
        $from_xml = sprintf($format, $encrypt);
        $msg = '';
        $errCode = $wx->decryptMsg($msg_sign, constants::timeStamp, constants::nonce, $from_xml, $msg);
        if ($errCode != 0) {
            print_r("解密失败,错误码:".$errCode);
        }
        //入库
        $de_xml_tree = new DOMDocument();
        $de_xml_tree->loadXML($msg);
        $array_info = $de_xml_tree->getElementsByTagName('InfoType');
        $array_create = $de_xml_tree->getElementsByTagName('CreateTime');
        $create_time = $array_create->item(0)->nodeValue;
        //获取component_verify_ticket
        if($array_info->item(0)->nodeValue == self::TICKET) {
            $ticket = $de_xml_tree->getElementsByTagName('ComponentVerifyTicket')->item(0)->nodeValue;
        }
        //获取取消授权的AuthorizerAppid
        if($array_info->item(0)->nodeValue == self::UNAUTHORIZED){
            $authorizerAppid = $de_xml_tree->getElementsByTagName('AuthorizerAppid')->item(0)->nodeValue;
        }
        return self::SUCCESS_CODE;
    }
}