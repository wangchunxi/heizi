<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/9/19
     * Time: 14:41
     */
    namespace app\admin\model;
    use think\Model;
    class Attachment extends Model{
        private $post;
        public function  Set_Post($post){
            $this->post = $post;
            return $this;
        }
        public function verify_data($data){
            if(!$this->{$data}){
                exception($data.'未传值');
            }
            return $this->{$data};
        }

        /**只获取上传文件路径
         * 用于导入导出
         * @return string
         */
        public function result_url_file(){
            $uploadfile = new  \UploadFile();
            $result = $uploadfile->Set_UploadType('result_url')->Set_data($this->verify_data('post'))->UploadFiles();
            return $result;
        }

    }