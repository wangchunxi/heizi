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
    private $field ;
    private $where;
    /*设置条件*/
    private function set_where($where){
        $this->$where = $where;
        return $this;
    }
    /*设置查询条件*/
    private function set_field($field){
        $this->field = $field;
        return $this;
    }
    /*添加or修改*/
    private function  admin_sava($data){
        $this->save($data);
    }
    /**验证某个值在某个字段里是否存在
     * 或者 统计个数
     * @param 字段名 $field
     * @param 验证的值 $value
     * @return 返回个数 int|string
     */
    private function vali_data(){
        $count =$this->where($this->where)->count($this->field);
        return $count;
    }
    private function one_select(){
        $find = $this->where($this->where)->field($this->field)->find();
    }
}