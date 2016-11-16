<?php

/**
 * 获取预授权码authorizer_access_token
 */
include_once "constant.php";

class AuthorizerAccessToken
{
    public function getAuthorizerAccessToken()
    {
        return $this->_request();
    }

    public function _request()
    {
        $postData = json_encode(array(
            'component_appid'         => constants::appId,
            'authorizer_appid' => constants::authorizer_appid,
            'authorizer_refresh_token' => constants::authorizer_refresh_token,
        ));
        $url = constants::authorizer_access_token_url.constants::component_access_token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
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