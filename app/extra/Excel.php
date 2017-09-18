<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/9/19
     * Time: 9:32
     */
    class Excel{
        private  $path;
        private  $ExcelType;
        private  $ExcelArray;
        private  $highestRow;
        /**文件路径
         * @param $path
         * @return $this
         */
        public function  Set_path($path){
            $this->path = $path;
            return $this;
        }

        /**导入导出类型
         * @param $ExcelType
         * @return $this
         */
        public function Set_ExcelType($ExcelType){
            $this->ExcelType = $ExcelType;
            return $this;
        }
        /*参数验证*/
        public function verify_param($param){
            if(empty($this->{$param})){
                exception($param.'参数不存在');
            }
            return $this->{$param};
        }
        /*
         * 数组
         * 格式array(
         *  'A'=>'id'
         *  'B'=>'xx'
         * )
         */
        public function Set_array($array){
            $this->ExcelArray = $array;
            return $this;
        }

        /**
         * 开始的行数
         */
        public function Set_start_highestRow( $highestRow = 2){
            $this->highestRow = $highestRow;
            return $this;
        }

        public function Excel_operate(){
            $ExcelType = $this->verify_param('ExcelType');
            if($ExcelType == 'Import' ){
               $result =  $this->Excel_Import();
            }else{

            }
            return $result;
        }
        /*文件导入成数组*/
        function  Excel_Import(){
            $PHPExcel =\PHPExcel_IOFactory::createReader('Excel2007');
            $path = $this->verify_param('path');
            if(!$PHPExcel->canRead($path)){
                $PHPExcel =\PHPExcel_IOFactory::createReader('Excel5');
            }
            $objPHPExcel = $PHPExcel->load($path,$encode='utf-8');
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            /*获取导出的对应数组*/
            $Excel_Array = $this->verify_param('ExcelArray');
            /**
             * 数组格式
             * array(A,B,C,D)
             */
            $Excel_Import_Array = $this->sum($Excel_Array);/*取得对应的数组*/
            /*循环获取数组*/
            for($i = $this->verify_param('highestRow');$i<$highestRow+1;$i++){
                /*循环列数组*/
                foreach($Excel_Import_Array as $k=>$v){
                    /*找到每个字母所设定的对应值 例如 A=>xxxx,B=>xxxx*/
                    $data[$i-$this->verify_param('highestRow')][$v]= $objPHPExcel->getActiveSheet()->getCell($k.$i)->getValue();
                }
            }
            return $data;
        }

        /**
         * 根据列返回数组
         * @param $number
         * @return mixed
         */
        public function sum($array){
            $number =  count($array);
            $arr =array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
            for($i=0;$i<$number;$i++){
                if($i<26){
                    $data_arr[$arr[$i]] = $array[$i] ;
                }elseif($number>25 && $number<703){
                    if(is_int(($i+1)/26)){
                        $a =$arr[floor(($i+1)/26)-2];
                        $b ='Z';
                    }else{
                        $a =$arr[floor(($i+1)/26)-1];
                        $b = $arr[(($i+1)%26)-1];
                    }
                    $data_arr[$a.$b] =$array[$i];
                }
            }
            return $data_arr;
        }



    }