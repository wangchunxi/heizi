<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/7/17
     * Time: 10:13
     */

    namespace app\admin\logic;
    use app\model\validata;
    use think\Model;
    use think\Validate;

    class view extends Model
    {
        private $Post;
        private $rule;
        private $msg;
        private $model_val;

        function __construct()
        {
            $this->model = new \app\model\View();
            $this->rule = array(
                'view_name' => 'require|unique',
            );
            $this->msg = array(
                'view_name.require' => '模板名称不能为空','view_name.unique' => '模板名称已存在'
            );
            $this->model_val = new Validate($this->rule, $this->msg);
        }
        public function set_post($data){
            $this->Post = $data;
            return $this;
        }

        /**获取所有模板
         * @return false|\PDOStatement|string|\think\Collection
         */
        public function select_view()
        {
            $map['status'] = 1;
            $result = $this->model->set_and($map)->set_field('id,view_name')->select_view();
            $result = convert_array($result,'view_name');
            return $result;
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
                return json_encode(array('status'=>false,'info'=>'排序中含有相同值或者有0或空','url'=>''));
            }
            arsort($sort);
            foreach($sort as $k=>$v){
                if(!$plug[$k]){
                    return json_encode(array('status'=>false,'info'=>'第'.$k.'插件未选择','url'=>''));
                }
                $plug_arr[$k][$v] = $plug[$k];
            }
            unset($post['plug']);unset($post['sort']);
            $post['content'] = serialize($plug_arr);
            $result = $this->model->save($post);
            if($result){
                return json_encode(array('status'=>true,'info'=>'操作成功','url'=>''));
            }else{
                return json_encode(array('status'=>false,'info'=>'操作失败','url'=>''));
            }
        }
    }