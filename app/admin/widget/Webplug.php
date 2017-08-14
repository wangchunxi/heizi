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

        /**
         * @param string $data
         * @return string
         */
        public function webplug($data=''){
            $data =  json_decode($data,true);
            $config = $data['config'];
            $plug = $data['plug'];
            //dump($config);
            $this->model->assign('data',$config);
            return $this->model->fetch('widget:'.$plug);
        }
        /**列表页的
         * @return string
         */
        public function td_checkbox(){
            return $this->model->fetch('widget:td_checkbox');
        }

        public function table_list($data = ''){
            $data =  json_decode($data,true);
            $vo = $data['vo'];
            $data = $data['config'];
            $data = json_decode($data,true);
            $config = $data['config'];
            $plug = $data['plug'];
//            dump($config);dump($vo);exit();
            $this->model->assign('data',$config);
            $this->model->assign('vo',$vo);
            return $this->model->fetch('widget:'.$plug);
        }
        public  function Button($data=''){
            if($data){
                $data = json_decode($data,true);
                $Button = $data['Button'];
                $type = $data['type'];
                $this->model->assign('Button',$Button);
                $this->model->assign('type',$type);
                return $this->model->fetch('widget:button');
            }
        }
    }