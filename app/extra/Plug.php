<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/8/9
     * Time: 13:13
     */
    namespace Plug;
    use plug_config\plug_config;

    class Plug{
        private $model;
        private $TabTob;
        private $TabData;
        private $Value;
        function __construct()
        {
           $this->model =  new plug_config();
        }
        public function Set_TabTop($TabTob =''){
            $this->TabTob =  $TabTob;
            return $this;
        }
        /*启用赋值*/
        public function Set_Value($Value){
            $this->Value = $Value;
            return $this;
        }
        public function Set_TabData($TabData =''){
            $this->TabData =  $TabData;
            return $this;
        }

        public function index($web){
            return $this->model->Set_config($this->$web())->Set_TabTop($this->TabTob)->Set_Value($this->Value)->dispose();
        }

        /**用户列表头部
         * @return array
         */
        function Set_User_TabTop(){
            $array =array(
                array('用户名',),
                array('昵称'),
                array('分组'),
                array('手机号'),
                array('最后次登陆时间'),
                array('最后次登陆ip'),
                array('创建人'),
                array('创建时间'),
                array('状态'),
                array('操作','style'=>'width:20%')
            );
            return $array;
        }
        /**用户列表格数据
         * @return array
         */
        function Set_User_TabBottom(){
            $array =array(
                array('username','plug'=>'td_txt'),
                array('nickname','plug'=>'td_txt'),
                array('group_name','plug'=>'td_txt'),
                array('mobile','plug'=>'td_txt'),
                array('last_login_time','plug'=>'td_txt'),
                array('last_login_ip','plug'=>'td_txt'),
                array('add_username','plug'=>'td_txt'),
                array('add_time','plug'=>'td_txt'),
                array('status','','','admin','启用','禁用','plug'=>'td_switch'),
            );
            return $array;
        }
        /**用户添加页配置
         * @return array
         */
         function Set_User_Info(){
            $array =   array(
                array('用户名','username','text','required','plug'=>'input','value'=>'username'),
                array('密码','password','password','','plug'=>'input','value'=>''),
                array('权限分组','group','plug'=>'select','value'=>'group'),
                array('昵称','nickname','text','required','plug'=>'input','value'=>'nickname'),
                array('手机号码','mobile','text','required','plug'=>'input','value'=>'mobile'),
                array('','id','hidden','','plug'=>'input','value'=>'id')
            );
            return $array;
        }

        /**菜单添加页配置
         * @return array
         */
         function Set_Menu_info(){
            $array = array(
                array('导航名称','menu_name','text','required','plug'=>'input'),
                array('选择父级导航','pid','get_Allmenu','plug'=>'select'),
                array('模型层','m','text','plug'=>'input'),
                array('控制层','c','text','plug'=>'input'),
                array('链接打开方式','class','get_class','plug'=>'select'),
                array('方法名','a','text','plug'=>'input'),
                array('链接地址(静态地址)','url','text','plug'=>'input'),
                array('分组名','group','text','','plug'=>'input'),
                array('按钮位置','nav_seat','text','plug'=>'input'),
                array('链接类型','url_type','get_url_type','plug'=>'select'),
                array('导航样式','css','text','plug'=>'input'),
                array('备注','content','plug'=>'textarea')
            );
            return $array;
        }
        /*分组页面列表表头*/
        function Set_Group_TabTop(){
            $array =array(
                array('分组名称',),
                array('添加时间'),
                array('添加人'),
                array('状态'),
                array('操作','style'=>'width:20%')
            );
            return $array;
        }
        /**用户组列表格数据
         * @return array
         */
        function Set_Group_TabBottom(){
            $array =array(
                array('group_name','plug'=>'td_txt'),
                array('add_time','plug'=>'td_txt'),
                array('add_username','plug'=>'td_txt'),
                array('status','','','admin','启用','禁用','plug'=>'td_switch'),
            );
            return $array;
        }
        /**用户列表格数据
         * @return array
        */
        function Set_Group_Info(){
            $array =array(
                array('用户组名称','group_name','text','required','plug'=>'input','value'=>'group_name'),
                array('','id','hidden','','plug'=>'input','value'=>'id')
            );
            return $array;
        }

        /**附件水印图修改
         * @return array
         */
        function Set_Watermark_TabTop(){
            $array =array(
                array('ID',),
                array('图片','width:20%'),
                array('名称'),
                array('大小'),
                array('上传时间'),
                array('状态'),
                array('操作')
            );
            return $array;
        }

        /**
         * 附件水印图详情页
         */
        function Set_Watermark_Info(){
            $array =array(
                array('水印图名称','group_name','text','required','plug'=>'input','value'=>'name'),
                array('上传','group_name','text','','plug'=>'upload_one','value'=>'group_name'),
                array('','id','hidden','','plug'=>'input','value'=>'id'),
                array('','class','hidden','','plug'=>'input','value'=>'')
            );
            return $array;
        }
        /**进销存列表
         * @return array
         */
        function Set_Purchase_TabTop(){
            $array =array(
                array('序号'),
                array('货物名称'),
                array('货物规格'),
                array('货物型号'),
                array('条形编码'),
                array('单价'),
                array('数量'),
                array('金额'),
                array('版本号'),
                array('操作')
            );
            return $array;
        }
        /**进销存列表
         * @return array
         */
        function Set_Purchase_TabBottom(){
            $array =array(
                array('id','plug'=>'td_txt'),
                array('goods_name','plug'=>'td_txt'),
                array('goods_specification','plug'=>'td_txt'),
                array('goods_version','plug'=>'td_txt'),
                array('shape_code','plug'=>'td_txt'),
                array('goods_pice','plug'=>'td_txt'),
                array('goods_num','plug'=>'td_txt'),
                array('goods_pice','plug'=>'td_txt'),
                array('data_node','plug'=>'td_txt'),
            );
            return $array;
        }
        /**
         * 添加货物详情页
         */
        function Set_Purchase_Info(){
            $array =array(
                array('货物名称','goods_name','text','required','plug'=>'input','value'=>'goods_name'),
                array('货物规格','goods_specification','text','required','plug'=>'input','value'=>'goods_specification'),
                array('货物型号','goods_version','text','required','plug'=>'input','value'=>'goods_version'),
                array('条形码','shape_code','text','','plug'=>'input','value'=>'shape_code'),
                array('货物单价','goods_pice','text','','plug'=>'input','value'=>'goods_pice'),
                array('','id','hidden','','plug'=>'input','value'=>'id'),
            );
            return $array;
        }
        /*批量添加货物页面*/
        function Set_Excel_Import_Goods_Info(){
            $array =array(
                array('上传货物表格','group_name','text','','plug'=>'uploadXml','value'=>'group_name'),
                array('','class','hidden','','plug'=>'input','value'=>'')
            );
            return $array;
        }
        /*选择货物页面*/
        function Set_Choice_Goods(){
            $array =array(
                array('搜索框','search_name','search_class','goods_name','/admin/Purchase/ajax_search_goods','名称/规格/型号','plug'=>'ajax_search'),
                array('货物名称','goods_name[]','get_all_goods','goods_name','checkbox','plug'=>'checkbox'),
                array('emblem_goods_name','plug'=>'div'),
            );
            return $array;
        }
        /*进销存*/
        function Set_Enters_sells_saves(){
            $array =array(
                array('上传表格','group_name','text','','plug'=>'uploadXml','value'=>'group_name'),
                array('状态选择','goods_name','','goods_name','switch','plug'=>'checkbox','additional'=>array('textis'=>'进仓','texton'=>'出仓')),
                array('','class','hidden','','plug'=>'input','value'=>'')
            );
            return $array;
        }
    }