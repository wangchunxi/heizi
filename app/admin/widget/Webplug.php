<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/7/13
     * Time: 13:12
     */
    namespace app\admin\widget;
    use app\common;

    class  Webplug extends common{
        private $model;
         function __construct()
        {
            $this->model = new \think\View();
        }
        public function webplug($data=''){
            $data =  json_decode($data,true);
            $config = $data['config'];
            $plug = $data['plug'];
            $this->model->assign('data',$config);
            return $this->model->fetch('widget:'.$plug);
        }
    }