<?php

include_once 'constant.php';

class sync
{
    const IMG = '/usr/download/test.jpg';
    public function syncmaterial()
    {
        $material = constants::material;
        //通过上传封面获得thumb_id
        $thumb = $this->uploadFormData(self::IMG, constants::authorizer_access_token, $type = 'thumb');
        if(!empty($thumb['media_id'])) {
            //处理特殊字符
            $this->dealSpecialMaterial($material['content'], constants::authorizer_access_token);
            $materialInfo = array(
                'title' => urlencode($material['title']),
                'thumb_media_id' => $thumb['media_id'],
                'author' => urlencode($material['author']),
                'digest' => urlencode($material['digest']),
                'show_cover_pic' => $material['show_cover_pic'] == 1 ? 1 : 0,
                'content' => urlencode($material['content']),
                'content_source_url' => $material['tweet_url']
            );
            $material['articles'][] = $materialInfo;
            $postData = urldecode(json_encode($material));
            $url = constants::add_news_url . constants::authorizer_access_token;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);

            $result = curl_exec($ch);
            $ret = json_decode($result, true);
            if(isset($ret['thumb_id']))
                return constants::ok;
            else
                return $ret['errcode'];
        } else {
            return $thumb['errcode'];
        }

    }

    /**
     * @param $content
     * @param $authorizer_access_token
     * 处理内容中的图片,视频,音频
     * 注意:内容中的""统一换成''
     */
    public function dealSpecialMaterial(&$content, $authorizer_access_token)
    {
        preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $content, $img_matches);
        //内容中的图片需要先上传到微信,获得腾讯系下的域名在替换到内容中
        if(!empty($img_matches[1])) {
            $images = $img_matches[1];
            foreach ($images as $image) {
                $imgUrl = constants::uploadimg_url . $authorizer_access_token;
                $postfields = array("media" => "@" . $image);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $imgUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                $result = curl_exec($ch);
                $weixin_url = json_decode($result, true);
                $content = str_replace($image, $weixin_url['url'], $content);
            }
        }
        //处理视频URL中的%
        preg_match_all('/< *iframe[^>]*src *= *["\']?([^"\']*)/i', $content, $video_matches);
        if(!empty($video_matches[1])) {
            $videos = $video_matches[1];
            foreach ($videos as $video) {
                if(strpos($video, 'v.qq.com') != false) {
                    $video_url = preg_replace('/%\d*[\d$]/', '', $video);
                    $content = str_replace($video, $video_url, $content);
                }
            }
        }
        $content = str_replace("\"","'",$content);
    }

    /**
     * @param $img
     * @param $authorizer_access_token
     * @param $type
     * @return mixed
     * 上传封面图,通过命令行实现,如果用curl_setopt无法控制上传文件的名称
     */
    public function uploadFormData($img, $authorizer_access_token, $type)
    {
        $url = sprintf(constants::add_material_url, $authorizer_access_token, $type);
        $media = '@' . realpath($img);
        $cmd = "curl -F media=".$media." ".$url;
        exec($cmd, $thumb, $result);
        return json_decode($thumb[0], true);
    }
}