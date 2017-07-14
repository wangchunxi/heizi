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

        public function listtable($data=''){
            $data =  json_decode($data,true);
            $this->model->assign('data',$data);
            return $this->model->fetch('widget:listtable');
        }
        public function text($data=''){
            $data =  json_decode($data,true);
            $this->model->assign('data',$data);
            return  $this->model->fetch('widget:text');
        }
        public function select($data=''){
            $data =  json_decode($data,true);
            $this->model->assign('data',$data);
            return $this->model->fetch('widget:select');
        }
        public function textarea($data=''){
            $data =  json_decode($data,true);
            $this->model->assign('data',$data);
            return $this->model->fetch('widget:textarea');
        }
        public function rich_text($data=''){
            $data =  json_decode($data,true);
            $this->model->assign('data',$data);
            return $this->model->fetch('widget:rich_text');
        }
        public function time_plug($data=''){
            $data =  json_decode($data,true);
            $this->model->assign('data',$data);
            return $this->model->fetch('widget:time_plug');
        }
    }