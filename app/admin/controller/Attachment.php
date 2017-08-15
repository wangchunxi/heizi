<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace app\admin\controller;
use think\Controller;
use Plug\Plug;
/**
 * 附件控制器
 * @package app\admin\controller
 */
class Attachment extends Base
{
    /**
     * 水印图片列表页
     * @return \think\response\View
     */
    public function Watermark_List(){
        $data = $this->Get_sys(__FUNCTION__);
        return  $this->Set_ListPage($data['config'],"public/table_list",$data['request_url']);
    }
    /*水印图片添加页*/
    public function Add_watermark(){
        $data = $this->Get_sys('Watermark_Info');
        return  $this->Set_ListPage($data['config'],"public/info",$data['request_url']);
    }
    /*水印图片详情页*/
    public function info_watermark(){
       // $data = $this->Get_sys(__FUNCTION__);
    }
    /*详情数据*/
    public function info(){

    }
    /*统一数据处理*/
    public function update(){

    }
    /**
     *统一上传附件
     */
    public function upload_file(){
        return json_encode(array("code"=>0));
    }

    /**
     * 验证图片md5
     */
    public function verify_image(){

    }
    /**
     * 获取配置参数
     */
    protected  function Get_sys($page_name='',$data=array()){
        $Plug = new Plug();
        switch($page_name){
            case 'Watermark_List':
                $data['config'] = $Plug->Set_TabTop(1)->index('Set_Watermark_TabTop');
                $data['request_url']['get_list'] =  url('getlist');
                $data['request_url']['add_url'] = url('Add_watermark');
                break;
            case 'Watermark_Info':
                if($data){
                    $data['config'] =$Plug->Set_Value($data)->index('Set_Watermark_Info');
                }else{
                    $data['config'] =$Plug->index('Set_Watermark_Info');
                }
                $data['request_url']['submit_url'] = url('update');
                $data['request_url']['upload_file'] = url('upload_file');
                $data['request_url']['verify_image'] = url('verify_image');
                break;
            case 'getlist':
                $data['config']= $Plug->index('Set_User_TabBottom');
                $data['request_url']['edit'] = '/admin/User/info/id/';
                break;
        }
        return $data;
    }

}