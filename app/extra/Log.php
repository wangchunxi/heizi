<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/31
 * Time: 9:28
 */
namespace  Log;
class Log{
    private $username;
    private $action_id;
    private $uid ;
    private $content;
    private $url;
    private $type;
    private $table = 'log';
    /*操作人*/
     function set_username($username){
        $this->username = $username;
        return $this;
    }

    /*操作人id*/
     function set_uid($uid){
        $this->uid = $uid;
        return $this;
    }
    /*操作产生的结果id*/
      function  set_action_id($action_id){
        $this->action_id=$action_id;
        return $this;
    }

    /*获取备注说明和访问网址*/
     function content(){
        $r_url = get_url();
        /*获取控制层*/
        $c =strtolower($r_url['c']);
        /*获取操作层*/
        $a = strtolower($r_url['a']);
        /*获取m层*/
        $m =strtolower( $r_url['m']);
        /*用户名称*/
        $username = $this->checkVariate('username');
        /*操作结果*/
        $action_id = $this->action_id;
        /*如果为登录就无需查询菜单库*/
        if($c == 'share' && $a == 'login'){
            $content ='id为'.$this->uid.'用户'.$username.'登录成功';
            $type = '登录';$url = $c.'/'.$m.'/'.$a;
        }else{

            /*查询菜单库*/
            $menu = db('menu')->where("m=$m and c = $c and a=$a")->field('menu_name,url')->find();
            $content ='id为'.$this->uid.'用户'.$username.'访问了'.$menu['menu_name'];
            $url = $menu['url'];
            $type = '访问';
            if($action_id){
                switch($a){
                    case 'add':
                        $type='添加';
                        break;
                    case 'edit':
                        $type='修改';
                        break;
                    case 'del':
                        $type='删除';
                        break;
                }
                $content.=$type.'了id为'.$action_id.'内容';
            }
        }
        $this->type = $type;
        $this->content = $content;
        $this->url = $url;
        return $this;
    }
    /**
     * 检测某个变量是否存在，存在返回对应值
     * @param $variateName 变量的名称
     * @return mixed
     * @throws BLException
     */
    private function checkVariate($variateName)
    {
        if(empty($this->{$variateName})){
            exception('未设置'.$variateName.'参数');
        }
        return $this->$variateName;
    }
    /*日志记录*/
    public  function  action_log($surface='null'){
        $data = null;
        /*数据整合*/
        $data['content'] = $this->checkVariate('content');
        $data['url'] = $this->checkVariate('url');
        $data['add_time'] = time();
        $data['type'] = $this->checkVariate('type');
        $data['uid'] = $this->checkVariate('uid');
        $data['uid_name'] = $this->checkVariate('username');
        $data['action_id'] = $this->action_id;
        $data['surface']= $surface;
        $data['action_ip'] = getIp();
        /*添加数据库*/
        $result = db($this->table)->insert($data);
        if(!$result){
            exception('日志记录失败');
        }
        return $result;
    }
}