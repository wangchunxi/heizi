<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: luofei614 <weibo.com/luofei614>　
// +----------------------------------------------------------------------
namespace Auth;
use app\admin\logic\user;

class Auth{

    private $user;
    //默认配置
    protected $_config = array(
        'auth_on'           => true,                      // 认证开关
        'auth_type'         => 1,                         // 认证方式，1为实时认证；2为登录认证。
        'auth_group'        => 'admin',        // 用户组数据表名
        'auth_group_access' => 'group', // 用户-用户组关系表
        'auth_rule'         => 'menu',         // 权限规则表
        'auth_user'         => 'member'   ,          // 用户信息表
        'session'         =>'rule',           //存放的权限字段
        'fild'    =>'a.*,b.group_rule,b.group_name',/*查询的权限字段*/
        'url'=> '',/*访问无效跳转页面  请设为配置权限里*/
    );
    /*配置附加权限*/
    protected $_auth=array(
        'admin/index/index','admin/index/info','admin/nav/leftnav'
    );
    function __construct()
    {
        $this->user = new user();
    }

    /**
     * 检查权限
     * @param name string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
     * @param uid  int           认证用户的id
     * @param string mode        执行check的模式
     * @param relation string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
     * @return boolean           通过验证返回true;失败返回false
     */
    public function check($url, $uid, $mode='url', $relation='or')
    {
        if(empty($uid)){
            if(empty(session('uid'))){
               exception('未登录请先登录');
            }
            $uid = session('uid');
        }
        //id,a.username,a.group,a.rule,a.nickname
        $config = $this->_config;

        $authList = $this->user->set_uid(session('uid'))->get_user_AuthList($config['fild']); //获取用户需要验证的所有有效规则列表
        if (!$this->_config['auth_on'])
            return true;

        /*存在附加无需验证*/
        $arr_url = strtolower($url['m'].'/'.$url['c'].'/'.$url['a']);
        if(in_array($arr_url,$this->_auth)){
            return true;
        }
        /*插件方法无需验证*/
        if($url['c'] == 'Webplug'){
            return true;
        }
        $auth_user =false;

        if(is_array($authList['url_arr']) && isset($authList['url_arr'][0])){
            $auth_user = $this->check_url($authList['url_arr'],$url,$mode);
        }
        return $auth_user;

    }

    /*url组装*/
    function  assembly($url,$authList,$level =3){
        if($url){
            $arr['url'] =$url['m'].'/'.$url['c'].'/'.$url['a'];
        }
        if($authList){
            foreach($authList as $k=>$va){
                /*组装成完整的权限列表*/
                switch($level){
                    case 1: $arr['menu_arr'][$k]=   strtolower($va['m']);
                        break;
                    case 2: $arr['menu_arr'][$k]=   strtolower($va['m'].'/'.$va['c']);
                        break;
                    case 3: $arr['menu_arr'][$k]=   strtolower($va['m'].'/'.$va['c'].'/'.$va['a']);
                        break;
                }
            }
        }
        return $arr;
    }
    /*url验证*/
    function ck_url(){
        $url =  isset($this->_config['url']) ? $this->_config['url'] : $this->_auth[0]['m'].'/'.$this->_auth[0]['c'].'/'.$this->_auth[0]['a'];
        return $url;
    }
    /**
     * 进行URL验证
     * @param $authList
     * @param $url
     */
    function check_url($authList,$url,$mode='url'){
        $arr_url= '';/*要验证的链接*/
        $arr_auth =array();
        /*全链接验证模式*/
        if($mode == 'url' ){
            $array = $this->assembly($url,$authList,3);
            $arr_url = $array['url'];
            $arr_auth = $array['menu_arr'];
        }
        /*模块验证模式*/
        if($mode == 'm'){
            $array = $this->assembly('',$authList,1);
            $arr_url = $url['m'];
            $arr_auth =array_unique($array['menu_arr']);
        }
        /*模块+控制器模式*/
        if($mode == 'm_c'){
            $array = $this->assembly('',$authList,2);
            $arr_url = $url['m'].'/'.$url['c'];
            $arr_auth = array_unique($array['menu_arr']);
        }
        /*进行数据验证*/
        if(in_array(strtolower($arr_url),$arr_auth)){
            return true;
        }
        return  false;
    }

}