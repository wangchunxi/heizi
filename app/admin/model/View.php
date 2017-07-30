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
        private $Post;
        private $rule;
        private $msg;
        private $model_val;
        private $map;
        private $index_config = array();

        function initialize()
        {
            $this->rule = array(
                'view_name' => 'require|unique',
            );
            $this->msg = array(
                'view_name.require' => '模板名称不能为空','view_name.unique' => '模板名称已存在'
            );
            $this->model_val = new Validate($this->rule, $this->msg);
            $this->index_config =array(
              // array(),
                array(
                    'config'=>array(
                        'config'=>array(
                            array('name'=>'视图名称','style'=>'width:30% ','class'=>''), array('name'=>'添加人','style'=>'','class'=>''),
                            array('name'=>'添加时间','style'=>'','class'=>''),array('name'=>'状态','style'=>'','class'=>''),
                            array('name'=>'操作','style'=>'width:20%','class'=>'')
                        ),
                        'plug'=>'listtable'
                    ),
                ),
            );
        }

        /**获取提交数据
         * @param $data
         * @return $this
         */
         function set_post($data){
            $this->Post = $data;
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
            $post = $this->Post;
            if(!empty($post['id'])){
                $post['update'] = time();
                /*修改人*/
                $post['update_id'] = '';
            }else{
                $post['add_time'] = time();
                //添加人
                $post['add_id'] = '';
            }
            $plug = $post['plug']; $sort = $post['sort'];
            $plug_arr=array();
            if((count(array_unique($sort)) !=  count($sort)) || ((count(array_filter($sort))) != count($sort) )){
                exception('排序中含有相同值或者有0或空');
            }
            arsort($sort);
            foreach($sort as $k=>$v){
                if(!$plug[$k]){
                   // return json_encode(array('status'=>false,'info'=>'第'.$k.'插件未选择','url'=>''));
                    exception('第'.$k.'插件未选择');
                }
                $plug_arr[$k][$v] = $plug[$k];
            }
            unset($post['plug']);unset($post['sort']);
            $post['content'] = serialize($plug_arr);
            if($post['id']>0){
                $result =  $this->save($post);
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
        function get_list_conf(){
            $data = array();
            foreach($this->index_config as $k=>$v){
                $data[$k]['config'] = json_encode($v['config']);
            }
            return $data;
        }

        /**
         * 分页查询列表数据
         * @return mixed
         */
        function getList(){
            $post = $this->Post;$map = $this->map;$field = $this->field;
            $data['total_num'] = $this->where($map)->count('id');
            $data['page_num'] =1;
            //$data['list'] = $this->where($map)->field()->page()->order()->select()->toArray();
            return $data;
        }
    }