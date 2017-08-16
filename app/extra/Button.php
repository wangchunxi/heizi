<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/8/25
     * Time: 14:51
     */
    class Button{
        private $uid;
        private $menu_id;
        private $menu_model;
        private $location;
        private $Auth;
        function __construct()
        {
            $this->menu_model = new \app\admin\model\Menu();
            $this->Auth = new \Auth\Auth();
        }

        /*正在访问的用户id*/
        function Set_Uid($uid){
            $this->uid = $uid;
            return $this;
        }
        /*正在访问的页面*/
        function Set_menu_id($menu_id){
            $this->menu_id = $menu_id;
            return $this;
        }
        function Set_location($location){
            $this->location = $location;
            return $this;
        }
        function Vali_data($data){
            if(empty($this->{$data})){
                exception($data.'未传值');
            }
            return $this->{$data};
        }
        /*验证当前页是否存在子页面*/
        function Vali_page(){
            $menu_id = $this->Vali_data('menu_id');
            $data =  $this->menu_model->get_floor($menu_id,'count',$this->location);
            if($data<=0){
                return false;
            }
            return true;
        }

        /**
         * 获取指定页面的所有子集页面
         */
        function get_page(){
            $menu_id = $this->Vali_data('menu_id');
            $data =  $this->menu_model->set_fied('id,menu_name,m,a,c,nav_seat,status,css,class,url')->get_floor($menu_id,'',$this->location);
            return $data;
        }
        function dispose(){
            $uid = $this->Vali_data('uid');
            /*访问页面是否存在子集*/
            if(!$this->Vali_page()){
                return false;
            }
            $data = $this->get_page();
            if($uid == 1){
                $Auth_menu = $data;
            }else{
                foreach($data as $k){
                    $url['m'] = $k['m'];
                    $url['c'] = $k['c'];
                    $url['a'] = $k['a'];
                    $result = $this->Auth->check($url,$uid);
                    if($result == true){
                        $Auth_menu[] = $k;
                    }
                }
            }
            return $Auth_menu;
        }
    }