<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/31
 * Time: 14:31
 */
namespace app\model;
use think\Model;
class Admin extends Model{
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
    /*添加or修改*/
     function  admin_sava($data){
        $this->save($data);
    }

    /**验证某个值在某个字段里是否存在
     * 或者 统计个数
     * @param 字段名 $field
     * @param 验证的值 $value
     * @return 返回个数 int|string
     */
     function vali_data(){
        $count =$this->where($this->and)->count();
        return $count;
    }

    /**单条数据查询
     * @return array|false|\PDOStatement|string|Model
     */
     function one_find(){
        $find = $this->where($this->and)->whereOr($this->or)->field($this->field)->find();
        return $find;
    }
}