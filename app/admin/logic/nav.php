<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/7/18
     * Time: 16:25
     */
    namespace app\admin\logic;
    use app\model\Menu;
    use app\model\validata;
    use think\Model;
    use think\Validate;

    class nav extends Model{
        private $view;
        private $post;
        private $modle;
        /*导航详情页配置*/
        private $info_config = array(
                                array('导航名称','menu_name','required'), array('选择父级导航','pid'), array('模型层','m'),
                                array('控制层','c'), array('方法名','a'), array('链接地址(静态地址)','url'),
                                array('分组名','group','required'), array('按钮位置','nav_seat'), array('导航样式','css'),
                                array('选择模板','view'), array('备注','content')
            );
        private $index_config = array();

        function __construct()
        {
            $this->modle =new Menu();
           // parent::__construct($data);
        }

        /**
         *
         * @return mixed
         * 获取视图配置
         */
        function get_view($view=''){
            $view  = unserialize($view['content']);
            $this->view = $view;
            return $this;
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
            /*添加下拉框选项*/
            $web_config[1][3] = $this->parent_nav();
            $view = new view();
            $web_config[9][3] =$view->select_view();
            /*生成插件配置数组*/
            foreach($web_config as $k=>$v){
                $config[$k] =  create_array($v);
            }
            /*获取视图配置*/
            $view_content = $this->view;
            /*进行组装生成完整页面插件转换json*/
            foreach($view_content as $k=>$v){
                foreach($v as $key=>$val){
                    $view_plug[$key]['plug'] = $val;
                    $view_plug[$key]['config'] =json_encode($config[$k]);
                }
            }
          //  dump($view_plug);
            return $view_plug;
        }
        /*所有一级导航*/
        function parent_nav(){
            $map['pid'] = 0 ;
            $map['status'] = 1;
            $result = $this->modle->set_and($map)->set_field('id,menu_name')->select_menu();
            $result = convert_array($result,'menu_name');
            return $result;
        }

        /**
         * 获取所有的链接进行组装
         */
        function get_Allmenu(){
            $map['status'] = 1;
            $result = $this->modle->set_and($map)->set_field('id,menu_name,url,css,pid,level')->select_menu();
            $data_array = array();
            /*字段名转换*/
            foreach($result as $k=>$v){
                $data_array[$k]['title'] = $v['menu_name'];
                $data_array[$k]['icon'] =  $v['css'];
                $data_array[$k]['href'] =  isset($v['url']) ?Url('/'.$v['url'].'/menu_id/'. $v['id']): 'javascript:;';
                $data_array[$k]['spread'] = false;$data_array[$k]['pid'] = $v['pid'];$data_array[$k]['level'] = $v['level'];
                $data_array[$k]['id'] = $v['id'];
            }
            $result = arr2tree($data_array);
            return $result;
        }

        /*前端提交信息接收*/
        function set_post($post=''){
            $this->post = $post;
            return $this;
        }
        /*添加or修改数据整合*/
        function update_data(){
            $post =$this->post;
            $post['id'] = isset($post['id']) ?$post['id'] :0;
            $post = is_add($post['id'],$post);
            $post['status'] = 1;
            $post['patn'] = '0-';
            /*判断当前是为顶级导航*/
            if($post['pid']!=0 && $post['pid']){
                /*不是顶级导航根据pid查询父级*/
                $map['id'] = $post['pid'];$map['status'] = 1;
                $field ='level,patn';
                $parent =  $this->modle->set_and($map)->set_field($field)->find_menu();
                /*判断父级是否存在*/
                if(!$parent){
                    return ajax_return(false,'父级不存在或不能被选中');
                }
                /*根据父级导航生成对应的level等级*/
                $post['patn'] = $parent['patn'].$post['pid'].'-';
                $post['level'] = $parent['level']+1;
            }
            /*当不存在静态链接直接组装*/
            if(isset($post['url']) && ($post['m'] && $post['c'] && $post['a'])){
                $post['url'] = $post['m'].'/'.$post['c'].'/'.$post['a'];
            }
            $result = $this->modle->set_post($post)->save_add();
            if(!$result){
                return ajax_return(false,'数据库执行失败');
            }
            return ajax_return(true,'操作成功');
        }
    }