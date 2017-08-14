<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/7/7
     * Time: 10:59
     */
    namespace app\admin\controller;
    use app\admin\model\Menu ;
    use Plug\Plug;

    class  Nav extends  Base{
        private $model;
        private $post;
        public function __construct()
        {
            parent::__construct(); // TODO: Change the autogenerated stub
            /*实例化处理层*/
            $this->model = new Menu();
            $this->post =  input('post.');
        }

        public function index(){
            return view();
        }
        public function add(){
            return  $this->info();
        }

        /*导航详情页*/
        public function info(){
            try{
                $plug = new Plug();
                /*获取配置*/
                $view_plug = $plug->index('Set_Menu_info');
                //dump($view_plug);exit();
                $request_url['submit_url'] = url('update');
                return $this->Set_ListPage($view_plug,"public/info",$request_url);
            }catch( \Exception $e){
                $this->error($e->getMessage());
            }
        }

        public function update(){
            if(request()->isPost()){
                try{
                     $result =  $this->model->set_post($this->post)->update_data();
                     return $result;
                    }catch( \Exception $e){
                        return ajax_return(false,$e->getMessage());
                    }
            }
        }

        /**
         * 左侧菜单返回
         * @return mixed
         */
        public function leftnav(){
            if(!session('uid')){
                return false;
            }
            $array =   $this->model->set_menu_ids()->get_Allmenu();
            return       $array;
        }

        public function navlist(){
            return view();
        }
    }