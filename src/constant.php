<?php

class constants
{
    const ok = 0;

    const encodingAesKey = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFG";
    const token = "pamtest";
    const timeStamp = "1409304348";
    const nonce = "xxxxxx";
    const appId = "wxb11529c136998cb6";
    const appSecret = "xxxxxxxxxxxxxxxx";

    const authorizer_access_token_url = "https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token=";
    const component_access_token_url = "https://api.weixin.qq.com/cgi-bin/component/api_component_token";
    const pre_auth_code_url = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token=";
    const add_material_url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=%s&type=%s';
    const add_news_url = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=';
    const uploadimg_url = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=';

    const component_access_token = "GRCWC82B3UQF7pFXIECNiyi2fvi0vkZndafKQlWAv8weGC1p9bEI0z3ZDoIDEl3ik4PURj5FeAU3Veslu9VqV_fpAojpcuypptZkbPQNrWIBARdABALKB";
    const component_verify_ticket = "ticket@@@LsdhKMLmDaVq8qngUSORoXKW3a-O9rfwSZHcxvE2FulQg7Z2EitKWQm-Q4vUeFUJFpvIaUhDfqwderAZPoEWyw";
    const authorizer_appid = "wxb4b62525d65bfe0b";
    const authorizer_refresh_token = "refreshtoken@@@P-xzgv7LbWXNzH663HeOVpyckynMXHg3e_i9_ht_qAk";
    const authorization_code = 'queryauthcode@@@AkOEjUaEp8KwdBw9kRcvf9pa7jSeg4Zwm07kM49F-jrukWw-a_P-UhFLuQfI3JRSq4ZWONByxFb8R-torZp79A';
    const authorizer_access_token = 'Ol1mtrSvlCL9KU8yD4qEa7bhrbRo_Yhy1P8TrCUr3yxjxoZk660-SVmnsstQPkQUECgPqtST-lF_nRlLZlIxXFRPhGOHD2KvsvwrY-LPZQPoyigenHlZxSz7q_Q8fAqSCXUcAEDJEB';

    const material = array(
        'title' => '这是标题',
        'author' => 'CRC10',
        'digest' => '这是摘要',
        'show_cover_pic' => 1,
        'content' => '这是内容',
        'content_source_url' => 'http://mp.weixin.qq.com/s?__biz=MzA3MDk4NzMzNg==&mid=2651704203&idx=1&sn=4b155bdef7f34f6e0452d3b43dca0a9d&mpshare=1&scene=1&srcid=1118QtPi2vSLKjgxL86reFRY#rd'
    );
}