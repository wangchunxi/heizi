<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/29
 * Time: 17:06
 */
namespace app\admin\model;
use app\model\validata;
use think\cache\driver\Redis;
use think\Model;
use think\Validate;

class Admin extends Model{
    private $str ='heizi'; private $redis;
    private $Post ; private $rule; private $msg;
    private $model_val; private $view;  private $uid;
    private $info_config =array(
            array('用户名','username','required'),
            array('密码','password','required'),
            array('权限分组','group',),
            array('昵称','nickname','required'),
            array('手机号码','mobile','required'),
            );
    private $index_config = array();

    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
            $this->redis = new  Redis();
            $this->rule= array(
                'username'=>'require|unique:admin|regex:/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/',
                'password'=>'require|regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{9,16}$/',
                'nickname'=>'require',
                'mobile'=>'require|unique:admin|regex:/^1[34578]\d{9}$/'
            );
            $this->msg =array(
                'username.require'=>'邮箱不能为空','username.regex'=>'邮箱格式不对','username.unique'=>'邮箱已存在',
                'password.require'=>'密码不能为空',  'password.regex'=>'密码范围在8~16位数字加字母！',
                'nickname.require'=>'昵称不能为空',
                'mobile.require'=>'手机号码不能为空', 'mobile.unique'=>'手机号码已存在','mobile.regex'=>'手机号码格式错误',
            );
            $this->model_val =new Validate($this->rule,$this->msg);
    }

    function set_uid($uid){
        $this->uid = $uid;
        return $this;
    }
    /**
     *
     * 获取视图配置
     */
    function get_view($view=''){
        $view  = unserialize($view['content']);
        $this->view = $view;
        return $this;
    }

    public function set_post($data){
        $this->Post = $data;
        return $this;
    }

    private function verify_data($data){
        if(empty($this->{$data})){
            exception("{$data}参数为空");
        }
        return $this->{$data};
    }

    /*加密密码*/
    function encrypt_password($password=''){
        //exception($password);
        if(empty($password)){
            exception('传递的密码为空');
        }
        $password = md5($this->str.md5($password));
        return $password;
    }

    /**
     * 修改和添加数据整合
     */
    public  function update_data(){
        $post = $this->verify_data('Post');
        $post['id'] =  isset($post['id']) ? $post['id']: 0;
        /*调用验证*/
        $this->verification($post);
        /*判断是添加or修改*/
        $data = $post;
        if($post['id']){
            $map['id'] = $post['id'];
            $info = $this->where($map)->find()->toArray();
            $password = $this->encrypt_password( $data['password']);
            if($info['password'] == $password){
                unset($data['password']);
            }else{
                $data['password'] = $password;
            }
            $data['update_time'] = time();
        }else{
            $data['add_time'] = time();
            $data['reg_ip'] =getIp();
            $data['password'] =$this->encrypt_password($data['password']);
        }
        if($data['id']>0){
            $result =   $this->save($data);
        }else{
            $result =  $this->insert($data);
        }
        if(!$result){
            exception('数据库操作失败');
        }
        return  json_encode(array('status'=>true,'info'=>'操作成功','url'=>''));
    }

    /*
     * 验证字段是否唯一
    */
    public function vali_data(){
        $post = $this->verify_data('Post'); $field = $post['field']; $value = $post['value'];
        $map[$field] ="'$value'";
        $result = $this->where($map)->count();
        if($result){
            exception('信息已被注册');
        }
        return  json_encode(array('status'=>true,'info'=>'信息可以使用','url'=>''));

    }

    /*
        * 生成前端web的配置
       */
    function set_config($type = 'index'){
        /*获取页面插件配置 index or info 默认index*/
        $web_config = $this->index_config;
        if($type == 'info'){
            $web_config = $this->info_config;
        }
       // dump($this->view);exit();
        $result = set_config_array($web_config,$this->verify_data('view'));
        return $result;
    }

    /*数据验证*/
    function verification($data){
        $rule = $this->rule;
        /*如果是修改模式就改变验证方式*/
        if($data['id']>0){
            $rule['username'] = 'require|unique:admin,username^id|regex:/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/';
            $rule['mobile'] = 'require|unique:admin,mobile^id|regex:/^1[34578]\d{9}$/';
        }
        $this->model_val =new Validate($rule,$this->msg);
        $result =   $this->model_val->check($data);
        if(!$result){
            $tips =  $this->model_val->getError();
            exception($tips);
        }
        return true;
    }

    /**
     * 查询指定的用户信息
     */
    function find_user_Info($uid='',$username='',$field ='*'){
        if(!$uid && !$username){
            exception('uid或者username必须存在一个');
        };
        if($uid){
            $map['id'] = $uid;
        }
        if($username){
            $map['username'] = $username;
        }
        $user_Info = $this->where($map)->field($field)->find()->toArray();
        return $user_Info;
    }

    /**
     *登录后更改的信息
     */
    function save_login(){
        $data = $this->verify_data('Post');
        $result = $this->sava($data);
        return $result;
    }

    //获取用户个人缓存
    function get_user_AuthList($field='*',$map=''){
        $uid = $this->verify_data('uid');
        /*获取用户信息缓存*/
        $cache = $this->redis->has($uid.'authority');
        if($cache){
            $user_info = $this->redis->get($uid.'authority');
            return  $user_info;
        }
        if(empty($map)){
            $map['a.id'] = $uid;
        }
        $user_Info = $this->get_user_info($map,$field);
        if(!$user_Info){
           exception('未查到该用户信息！');
        }
        $menu_arr = '';$rule = '';
        /*权限ID整合*/
        if( $user_Info['rule'] || $user_Info['group_rule']){
            /*进行数据评价*/
            $rule = $user_Info['rule'].','.$user_Info['group_rule'];
            /*成组*/
            $rule = explode(',',$rule);
            if($rule){
                /*去空*/
                $rule = array_filter($rule);
                /*去重复*/
                $rule = array_unique($rule);
            }
            $nav = new nav();
            $menu_arr = $nav->get_Allmenu($rule,$field='m,c,a',false);
        }
        $this->redis->set($uid.'authority',json_encode(array('user_info'=>$user_Info,'url_arr'=>$menu_arr,'rule'=>$rule)),'3600');
        return $menu_arr;
    }


    function get_user_info($where,$field){
        $result = $this->alias('a')
            ->join('h_group b','a.group = b.id','Left')
            ->where($where)
            ->field($field)
            ->find()->toArray();
        return $result;
    }

}