<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/7/17
     * Time: 10:13
     */
    namespace app\admin\model;
    use app\model\validata;
    use think\Model;
    use think\Validate;
    class View extends Model
    {
        private $Post; private $rule; private $msg; private $model_val;
        private $map;  private $index_config = array(); private $page;
        private $fields;
        protected $type = [
            'add_time'  =>  'timestamp:Y-m-d H:i:s',
        ];
        private $table_config;
        function initialize()
        {
            /*验证字段*/
            $this->rule = array(
                'view_name' => 'require|unique',
            );
            /*验证失败提示语句*/
            $this->msg = array(
                'view_name.require' => '模板名称不能为空','view_name.unique' => '模板名称已存在'
            );
            /*验证数据*/
            $this->model_val = new Validate($this->rule, $this->msg);
            /*页面显示配置*/
            $this->index_config =array(
              // array(),
                array(
                    'config'=>array(
                        'config'=>array(
                            array('name'=>'视图名称','style'=>'width:30% ','class'=>''), array('name'=>'添加人','style'=>'','class'=>''),
                            array('name'=>'添加时间','style'=>'','class'=>''), array('name'=>'禁用/启用','style'=>'','class'=>''),
                            array('name'=>'操作','style'=>'width:20%','class'=>'')
                        ),
                        'plug'=>'listtable'
                    ),
                ),
            );
            $this->table_config = array(
                array(
                    'config'=>array(
                        'config'=>array(
                            'title'=>'title','class'=>'','style'=>''
                        ),
                        'plug'=>'td_txt'
                    )),
                array(
                    'config'=>array(
                        'config'=>array(
                            'title'=>'username','class'=>'','style'=>''
                        ),
                        'plug'=>'td_txt'
                    )),
                array(
                    'config'=>array(
                        'config'=>array(
                            'title'=>'add_time','class'=>'','style'=>''
                        ),
                        'plug'=>'td_txt'
                    )),
                array(
                    'config'=>array(
                        'config'=>array(
                            'table'=>'view', 'class'=>'','style'=>'','if'=>'启用','else'=>'禁用','field'=>'status'
                        ),
                        'plug'=>'td_switch',
                    )),
            );
        }
        /**
         * 获取查询字段
         */
        function set_field($field){
            $this->fields =  isset($field) ? $field: '*';
            return $this;
        }
        /**获取提交数据
         * @param $data
         * @return $this
         */
         function set_post($data){
            $this->Post = $data;
            return $this;
        }
        function set_page($page){
            $this->page = $page;
            return $this;
        }
        /**
         * 条件组装
         */
         function set_map($data){
            $map['status'] = 1;
            if(isset($data['id']) && is_numeric($data['id'])){
                $map['id'] = $data['id'];
            }
            $this->map = $map;
            return $this;
        }
        /**获取所有模板
         * @return false|\PDOStatement|string|\think\Collection
         */
        public function select_view()
        {
            $map = $this->map;
            $result = $this->where($map)->field('id,view_name')->select()->toArray();
            $result = convert_array($result,'view_name');
            return $result;
        }

        /**
         * 获取指定视图
         */
        public function find_view(){
            //$this->model->select_view()
        }
        /*
         * 添加或修改处理数据和验证过程
         * */
        public function update_data(){
            /*接收前台传递参数*/
            $post = $this->Post;
            /*判断添加还是修改*/
            $post = is_AddUpdate($post);
            /*获取插件名和排序顺序*/
            $plug = $post['plug']; $sort = $post['sort'];
            $plug_arr=array();
            /*排序值验证是否相同或为0位非空*/
            if((count(array_unique($sort)) !=  count($sort)) || ((count(array_filter($sort))) != count($sort) )){
                exception('排序中含有相同值或者有0或空');
            }
            /*排序*/
            arsort($sort);
            /*循环排序找对应插件*/
            foreach($sort as $k=>$v){
                /*验证插件是否选择*/
                if(!$plug[$k]){
                    exception('第'.$k.'插件未选择');
                }
                /*组装数组*/
                $plug_arr[$k][$v] = $plug[$k];
            }
            /*销毁插件和排序*/
            unset($post['plug']);unset($post['sort']);
            /*进行序列化*/
            $post['content'] = serialize($plug_arr);
            /*判断修改还是添加*/
            if($post['id']>0){
                $result =  $this->update($post);
            }else{
                $result =  $this->insert($post);
            }
            if(!$result){
               exception('数据库操作失败');
            }
            return json_encode(array('status'=>true,'info'=>'操作成功','url'=>''));
        }

        /**返回列表页配置
         * @return array
         */
        function get_list_conf($config){
            $data = array();
            foreach( $this->$config as $k=>$v){
                $data[$k]['config'] = json_encode($v['config']);
            }
            return $data;
        }

        /**
         * 分页查询列表数据
         * @return mixed
         */
        function getList(){
            $map['status'] = 1;
            /*获取数据*/
            $post = $this->Post;$field = $this->fields;
            /*查询数据总量*/
            $data['total_num'] = $this->where($map)->count('id');/*总数量*/
            $data['page_num'] =10;/*每页显示数量*/
            $data['total_page'] = ceil($data['total_num']/ $data['page_num']);
            /*清空查询条件*/
            $map = null;
            $map['a.status'] = array('EGT',0);
            /*获取当前页数*/
            $page =  isset($this->page) ? ($this->page): 1;
            /*联表查询数据*/
            $data['list'] = $this->alias('a')
                ->join('h_admin b','a.add_id = b.id','Left')
                ->where($map)->field($field)->
                page($page,$data['page_num'])->
                order('a.id')->select()->toArray();
            $data['config'] =$this->get_list_conf('table_config');
            return $data;
        }
    }