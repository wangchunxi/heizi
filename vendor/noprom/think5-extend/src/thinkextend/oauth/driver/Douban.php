<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi.cn@gmail.com> <http://www.zjzit.cn>
// | Modify: 申法宽 <sfk@live.cn> <http://www.3uncle.com>
// +----------------------------------------------------------------------

namespace thinkextend\oauth\driver;

use thinkextend\oauth\Driver;

class Douban extends Driver
{
    /**
     * 获取requestCode的api接口
     * @var string
     */
    protected $getRequestCodeURL = 'https://www.douban.com/service/auth2/auth';

    /**
     * 获取access_token的api接口
     * @var string
     */
    protected $getAccessTokenURL = 'https://www.douban.com/service/auth2/token';

    /**
     * API根路径
     * @var string
     */
    protected $apiBase = 'https://api.douban.com/v2/';

    /**
     * 组装接口调用参数 并调用接口
     * @param  string $api    微博API
     * @param  string $param  调用API的额外参数
     * @param  string $method HTTP请求方法 默认为GET
     * @return json
     */
    protected function call($api = '', $param = '', $method = 'GET', $multi = false)
    {
        /* 豆瓣调用公共参数 */
        $params = [];
        $header = ["Authorization: Bearer {$this->token['access_token']}"];
        $data   = $this->http($this->url($api), $this->param($params, $param), $method, $header);
        return json_decode($data, true);
    }

    /**
     * 解析access_token方法请求后的返回值
     * @param string $result 获取access_token的方法的返回值
     */
    protected function parseToken($result)
    {
        $data = json_decode($result, true);
        if ($data['access_token'] && $data['expires_in'] && $data['refresh_token'] && $data['douban_user_id']) {
            $data['openid'] = $data['douban_user_id'];
            unset($data['douban_user_id']);
            return $data;
        } else {
            throw new \Exception("获取豆瓣ACCESS_TOKEN出错：{$data['msg']}");
        }

    }

    /**
     * 获取当前授权应用的openid
     * @return string|null
     */
    public function getOpenId()
    {
        if (!empty($this->token['openid'])) {
            return $this->token['openid'];
        }

        return null;
    }

    /**
     * 获取当前登录的用户信息
     * @return array
     */
    public function getOauthInfo()
    {
        $data = $this->call('user/~me');

        if (empty($data['code'])) {
            $userInfo['type']   = 'DOUBAN';
            $userInfo['name']   = $data['name'];
            $userInfo['nick']   = $data['name'];
            $userInfo['avatar'] = $data['avatar'];
            return $userInfo;
        } else {
            E("获取豆瓣用户信息失败：{$data['msg']}");
        }
    }

}
