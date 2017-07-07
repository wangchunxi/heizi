<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/7/7
     * Time: 10:57
     */
    namespace app\model;
    use think\Model;
    class Nav extends Model{
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
        }
        /*设置查询字段*/
        function set_field($field){
            $this->field = $field;
            return $this;
        }


    }