<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/7/17
     * Time: 10:11
     */
    namespace app\model;
    use think\Model;
    class View extends Model{
        protected $field;
        protected $and;
        protected $or;

        /*设置and条件*/
        function set_and($and){
            $this->and = $and;
            return $this;
        }

        /*设置or条件*/
        function set_or($or){
            $this->or = $or;
            return $this;
        }

        /*设置查询字段*/
        function set_field($field){
            $this->field = $field;
            return $this;
        }

//        function add_save($data){
//            $result = $this->save($data);
//            return $result;
//        }
        function select_view(){
            $result = $this->where($this->and)->whereOr($this->or)->field($this->field)->select();
            return $result;
        }

    }