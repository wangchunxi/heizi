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
    private function username($username){
        $this->username = $username;
        return $this;
    }

    /*操作人id*/
    private function uid($uid){
        $this->uid = $uid;
        return $this;
    }
    /*操作产生的结果id*/
    private  function  action_id($action_id){
        $this->action_id=$action_id;
        return $this;
    }

    /*获取备注说明和访问网址*/
    private function content(){
        $r_url = get_url();
        /*获取控制层*/
        $c =$r_url['c'];
        /*获取操作层*/
        $a = $r_url['a'];
        /*获取m层*/
        $m = $r_url['m'];
        /*用户名称*/
        $username = $this->username;
        /*操作结果*/
        $action_id = $this->action_id;
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
        if(empty($this->$variateName))
            //TODO:信息提醒日志未运行
        return $this->$variateName;
    }
    /*日志记录*/
    public  function  action_log($surface='null'){
        /*数据整合*/
        $data['content'] = $this->checkVariate('content');
        $data['url'] = $this->checkVariate('url');
        $data['add_time'] = time();
        $data['type'] = $this->checkVariate('type');
        $data['uid'] = $this->uid;
        $data['username'] = $this->username;
        $data['action_id'] = $this->action_id;
        $data['surface']= $surface;
       // dump(get_url());
        /*添加数据库*/
//        $result = db($this->table)->add($data);
//        if(!$result){
//            //TODO:提示日志未记录成功
//        }
//        return $result;
    }
}