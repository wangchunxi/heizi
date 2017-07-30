<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/25
 * Time: 10:58
 */
    /*获取当前链接*/
    function get_url(){
        $array = array('m'=>request()->module(),'c'=>request()->controller(),'a'=>request()->action());
        return $array;
    }
    //获取用户真实IP
    function getIp() {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else
            if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            else
                if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
                    $ip = getenv("REMOTE_ADDR");
                else
                    if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
                        $ip = $_SERVER['REMOTE_ADDR'];
                    else
                        $ip = "unknown";
        return ($ip);
    }

    /**
     *生成对应的数组
     * @param 参数名称 $parameter
     * @param 字段 $fields
     */
    function create_array($parameter,$fields=array('name','submit_name','verify','option')){
        $new_array = array();
        foreach($fields as $k=>$v){
            $new_array[$v] =  isset($parameter[$k]) ? $parameter[$k] : false;
        }
        return $new_array;
    }

    /**
     * 判断是否是添加 or 删除 生成对应于的数据并进行返回
     * @param 判断的依据参数$id 存在则为update
     * @param 旧数组 $post 要整合的数组
     * @return mixed 返回新数组
     */
    function is_add($id,$post){
        if($id>0){
            $post['update_time'] = time();
            $post['update_id'] = '';
        }else{
            $post['add_time'] = time();
            $post['add_id'] = '';
        }
        return $post;
    }

    /**
     * @param 返回的状态$status
     * @param 返回的提示$info
     * @param 返回的数据$info_data
     * @param 跳转的链接$url
     */
    function ajax_return($status=false,$info='未提供提示语句',$info_data='',$url='',$ajax_status=true){
        if($ajax_status == true){
            return json_encode(array('status'=>$status,'info'=>$info,'info_data'=>$info_data,'url'=>$url));
        }
        return array('status'=>$status,'info'=>$info,'info_data'=>$info_data,'url'=>$url);
    }

    /*
     * 用于option转换统一的名字方便页面输出
     */
    function convert_array($data=array(),$old_field_title,$new_field_new='title',$old_field_value='id',$new_field_value='id'){
            if(empty($data) || empty($old_field_title) || empty($new_field_new) ){
                exception('参数未传递完整请检查第1、4、5参数');
            }
            if(!is_array($data)){
                exception('第一个参数必定为数组');
            }
            $new_array = array();
            foreach($data as $k=>$v){
                $new_array[$k][$new_field_value] = $v[$old_field_value];
                $new_array[$k][$new_field_new] = $v[$old_field_title];
            }
            return $new_array;
    }

    //形成树状格式
    function arr2tree($tree, $rootId = 0,$level=1,$ico='') {
        $return = array();
        foreach($tree as $leaf) {
            if($leaf['pid'] == $rootId) {
                $leaf["level"] = $level;
                if($ico && $rootId!=0){
                    $leaf['title'] = $ico.$leaf['title'];
                }
                if($rootId == 0){
                    $ico = str_replace('&nbsp;','',$ico);
                }
                foreach($tree as $subleaf) {
                    if($subleaf['pid'] == $leaf['id']) {
                        $leaf['children'] = arr2tree($tree, $leaf['id'],$level+1,$ico='&nbsp;&nbsp;'.$ico);
                        break;
                    }
                }
                $return[] = $leaf;
            }
        }
        return $return;
    }

    /**
     * 配置页面数组
     * @param 配置数组 $web_config
     * @param 页面格式 $view_content
     * @return mixed
     */
    function set_config_array($web_config,$view_content){
        /*生成插件配置数组*/
        foreach($web_config as $k=>$v){
            $config[$k] =  create_array($v);
        }
        /*进行组装生成完整页面插件转换json*/
        foreach($view_content as $k=>$v){
            foreach($v as $key=>$val){
                $view_plug[$key]['config'] =json_encode(array('config'=>$config[$k],'plug'=>$val));
            }
        }
        return $view_plug;
    }
    function verify_data($data){
        if(empty($data) || isset($data)){
            exception("{$data}参数为空");
        }
        return $data;
    }

//    function isset_exception($data){
//     //   dump($data);
//        if($data['status'] === false){
//          return  exception($data['tips']);
//        }
//        return $data['info'];
//    }
//    /**
//     * 判断返回是否是true，否则报错
//     */
//    function is_status_true($data){
//        $data = json_decode($data);
//        if($data['status'] ==  false){
//        }
//    }
    function recursion_web($data,$web=''){
        foreach($data as $k=>$vo){
            $web.="  <option value='$vo[id]'>$vo[title]</option>";
            if(isset($vo['children'])){
                $web.= recursion_web($vo,$web);
            }
        }
        return $web;
    }