<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/7/7
     * Time: 10:57
     */
    namespace app\model;
    use think\Model;
    class Menu extends Model{
        protected $field;
        protected $and;
        protected $or;
        protected $post;

        /*设置and条件*/
        public function set_and($and){
            $this->and = $and;
            return $this;
        }
        /*设置or条件*/
        public function set_or($or){
            $this->or = $or;
            return $this;
        }
        /*设置查询字段*/
        public function set_field($field){
            $this->field = $field;
            return $this;
        }

        public function set_post($post)
        {
            $this->post = $post;
            return $this;
        }

        /**
         * 不是翻页
         * 菜单结果集查询
         * 结果集查询
         */
        public function select_menu(){
            if($this->or){
                $result =    $this->where($this->and)->whereOr($this->or)->field($this->field)->select()->toArray();
            }else{
                $result =  $this->where($this->and)->field($this->field)->select()->toArray();
            }
          //  dump($result);
            return $result;
        }

        /**
         *获取单个导航数据
         * @return array|false|\PDOStatement|string|Model
         */
        public  function find_menu(){
            $result = $this->where($this->and)->whereOr($this->or)->field($this->field)->find()->toArray();
            return $result;
        }

        /**
         * 操作数据库添加或修改
         */
        public  function save_add(){
            $post = $this->post;
            if($post['id']>0){
                $result =  $this->save($post);
            }else{
                $result =  $this->insert($post);
            }
            return $result;
        }
    }