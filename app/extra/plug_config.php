<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/8/9
     * Time: 11:50
     */
    namespace plug_config;

    use app\admin\model\Menu;

    class plug_config {
        private $plug;
        private $TabTop;
        private $TabData;
        private $Value;
        function  __construct()
        {
        }

        /**设置配置参数
         * @param $plug
         * @return $this
         */
        public function Set_config($plug){
            $this->plug = $plug;
            return $this;
        }

        /**设置列表标识
         * @param $TabTop
         * @return $this
         */
        public function Set_TabTop($TabTop){
            $this->TabTop = $TabTop;
            return $this;
        }
        public function Set_TabData($TabData){
            $this->TabData = $TabData;
            return $this;
        }
        /*启用赋值*/
        public function Set_Value($Value){
            $this->Value = $Value;
            return $this;
        }
        /**处理配置中转
         * @return array
         */
        public function dispose(){
            /**
             * 是否是列表页表头配置处理
             */
            if($this->TabTop){
                return $this->assembly_TabTop();
            }
//            if($this->TabData){
//                return $this->assembly_TabData();
//            }

            /**
             * 没有标识调用详情页处理
             */

            return $this->assembly_config();
        }

        /**列表页Table处理
         * @return mixed
         */
        function assembly_TabTop(){
            /**
             * 列表页标准数据结构
             */
            $set_config =array(
                'name','style','class'
            );
            $array = array();
            /**
             * 循环配置数据
             */
            foreach($this->plug as $key=>$value){
                /*调用标准数据进行生成数据最终结构*/
                $array['config'][$key] = $this->assembly_config_3($set_config,$value);
//                foreach($set_config as $k=>$v) {
//                    $array['config'][$key] =   isset($value[$k]) ? $value[$k]: '';
//                    if(empty($array['config'][$key])){
//                        $array['config'][$key] =  isset($value[$v]) ? $value[$v]: '';
//                    }
//                }
            }
            /*返回数据调用模块名称*/
            $array['plug'] = 'listtable';
            /*返回完整数据*/
            $data['0']['config'] =json_encode($array);
            return $data;
        }

        /**详情页配置处理
         * @return array
         */
        public function assembly_config(){
            $data = array();
            /*循环配置数据*/
            foreach($this->plug as $k=>$v){
                $config = array();
                /*生成每一项的模块所需要的标准数据*/
                $config['config']= $this->assembly_config_2($v['plug'],$v);
                /*返回模块名称*/
                $config['plug'] = $v['plug'];
                /*进行数据整合*/
                //dump($config);
                $data[$k]['config'] = json_encode($config);
            }
           // dump($data);exit();
            /*返回完整数据*/
            return $data;
        }

        /**获取详情页所提供模块基本数据
         * @param 模块名 $plug
         * @param 配置数据 $data
         * @return 返回每项的组合好的基本数据 array
         */
        public function assembly_config_2($plug,$data){
            /*共用的基本配置*/
            $set_config['info'] =array(
               'name','submit_name'
            );
            $set_config['TabBottom'] =array(
                'title','class','style'
            );
            $set_array = array();
            /*根据模块名生成每项的特殊配置*/
            switch($plug){
                case 'select':
                    $set_array = $set_config['info'];
                    $set_array[]='option';
                    break;
                case 'input':
                    $set_array = $set_config['info'];
                    $set_array[]='type'; $set_array[]='verify';
                    break;
                case 'td_txt':
                    $set_array =  $set_config['TabBottom'];
                    break;
                case 'td_switch':
                    $set_array =  $set_config['TabBottom'];
                    $set_array[] = 'table';$set_array[] ='if';$set_array[] ='else';
                    break;
                case 'upload_one':
                    $set_array =  $set_config['info'];
                    break;
                case 'textarea':
                    $set_array = $set_config['info'];
                    break;
            }
            if($this->Value){
                $set_array[]='value';
            }
            /*调用循环填充配置方法生成最终配置*/
           return $this->assembly_config_3($set_array,$data);
        }

        /**填充配置数据未标准数据
         * @param 模块的标准数据配置       $set_config
         * @param 模块的配置数据           $data
         * @return模块最终配置             array
         */
        public function assembly_config_3($set_config,$data){
            $new_array=array();
            /*循环提供标准数据的配置*/
            foreach($set_config as $k=>$v){
                /*生成每项的最终配置*/
                $new_array[$v] =  isset($data[$k]) ? $data[$k]: '';
                /*特殊的模块参数调用指定方法*/
                if($v == 'option' && isset($data[$k])){
                    $new_array[$v] =  $this->$data[$k]();
                }
                //dump($this->Value[$data['value']]);
                if($v == 'value' && isset($this->Value[$data['value']])){
                    $new_array[$v] =   isset($this->Value[$data['value']]) ? $this->Value[$data['value']]: "";
                }

            }
         //   dump($new_array);
            /*返回标准数据*/
            return $new_array;
        }

        /**获取建立菜单的所有父级菜单
         * 给某些配置项使用
         * @return Menu|array
         */
        public function get_Allmenu(){
            $menu = new Menu();
            $menu =  $menu->set_menu_ids()->get_Allmenu($field = 'id,menu_name,pid,level',true,'┝');
            return $menu;
        }
    }