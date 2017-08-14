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

    /**option选项循环输出子集
     * @param $data
     * @param string $web
     * @return string
     */
    function recursion_web($data,$web=''){
//        echo "<--start--> \n";
//        dump($data);
//        echo "<--end--> \n";
        foreach($data as $k=>$vo) {
//            echo "<--start.vo--> \n";
//            dump($vo);
//            echo "<--end.vo--> \n";
//            echo $vo['id'];
            $web.="<option value='$vo[id]'>$vo[title]</option>";
            if (isset($vo['children'])) {
                $web= recursion_web($vo['children'],$web);
            }
        }
        return $web;
    }

    /**
     * 判断添加或者修改的偷懒函数
     */
    function is_AddUpdate($id,$post=array()){
        if(!empty($id)){
            $post['update_time'] = time();
            /*修改人*/
            $post['update_id'] = session('uid');
        }else{
            $post['add_time'] = time();
            //添加人
            $post['add_id'] = session('uid');
        }
        return $post;
    }
    function get_pant_file($URl =''){
        /**
         * 【php获取目录中的所有文件名】
         */
        //1、先打开要操作的目录，并用一个变量指向它
        //打开当前目录下的目录pic下的子目录common。
        $handler = opendir($URl);
        //2、循环的读取目录下的所有文件
        //其中$filename = readdir($handler)是每次循环的时候将读取的文件名赋值给$filename，为了不陷于死循环，所以还要让$filename !== false。一定要用!==，因为如果某个文件名如果叫’0′，或者某些被系统认为是代表false，用!=就会停止循环*/
        while( ($filename = readdir($handler)) !== false ) {
            //3、目录下都会有两个文件，名字为’.'和‘..’，不要对他们进行操作
            if($filename != "." && $filename != ".."){
                //4、进行处理
                //这里简单的用echo来输出文件名
                $file[]=str_replace( '.' . pathinfo($filename,PATHINFO_EXTENSION), '',$filename );
            }
        }
////5、关闭目录
        closedir($handler);
        return $file;
    }