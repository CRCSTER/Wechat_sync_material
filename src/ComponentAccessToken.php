<?php
/**
 * 通过component_verify_ticket获取component_access_token
 */
include_once "constant.php";

class ComponentAccessToken
{

    public function getComponentAccessToken()
    {
        return $this->_request();
    }

    public function _request()
    {
        $postData = json_encode(array(
            'component_appid'         => constants::appId,
            'component_appsecret'     => constants::appSecret,
            'component_verify_ticket' => constants::component_verify_ticket
        ));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, constants::component_access_token_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $result = curl_exec($ch);
        return json_decode($result, true);
    }
}