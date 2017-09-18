<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/9/19
     * Time: 11:05
     */
    class UploadFile{
        private $UploadType;
        private $data;
        private $config;
        /**上传类型
         * result_id 返回结果为ID
         * result_url 返回文件路径
         * @param $UploadType
         * @return $this
         */
        public function Set_UploadType($UploadType){
            $this->UploadType = $UploadType;
            return $this;
        }

        /**配置数组
         * @param $config
         * @return $this
         */
        public function Set_Config($config){
            $this->config = $config;
            return $this;
        }
        /**
         * 上传数据
         */
        public function Set_data($data){
            $this->data = $data;
            return $this;
        }
        public function verify_data($data){
            if(!$this->{$data}){
                exception($data.'未传参数');
            }
            return $this->{$data};
        }
        public function UploadFiles(){
            if($this->verify_data('UploadType') == 'result_url'){
               if($file_url = $this->Upload_result_url()){
                  return $file_url;
               }
            }
        }

        /**
         * 返回结果为数组的统一不存数据库
         */
        function Upload_result_url(){
            /*获取配置是否存在*/
            if($this->config){
                $config =  $this->config;
            }else{
                $config = array();
            }
            $Upload =   new \thinkextend\Upload($config);
            $result = $Upload->upload();
            if(!$result){
               return exception( $Upload->getError());
            }
            $rootpath =  isset($config['rootPath']) ? $config['rootPath']: './Uploads/';
            $savepath =  isset($config['savePath']) ? $config['savePath']:$result['file']['savepath'] ;
            $file_url =$rootpath.$savepath.$result['file']['savename'];
            return $file_url;
        }
    }