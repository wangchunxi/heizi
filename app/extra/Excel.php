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
        private  $file_name;
        private  $title;
        private  $data;
        private  $data_title;
        /**文件路径
         * @param $path
         * @return $this
         */
        public function  Set_path($path){
            $this->path = $path;
            return $this;
        }
        /**
         * 文件名称
         */
        public function  Set_file_name($file_name){
            $this->file_name = $file_name;
            return $this;
        }
        /**
         *表格标题
         */
        public function Set_title($title){
            $this->title = $title;
            return $this;
        }
        /**
         * 导出数据
         */
        public function Set_data($data){
            $this->data = $data;
            return $this;
        }

        /**
         * 导出数据的标题
         * @param $data_title
         * @return $this
         */
        public function Set_data_title($data_title){
            $this->data_title = $data_title;
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
                $this->exportExcel();
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
        public function sum($array,$true =true){
            $number =  count($array);
            $arr =array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
            for($i=0;$i<$number;$i++){
                if($i<26){
                    $data_arr[$arr[$i]] = $array[$i] ;
                    if($true ==false){
                        $data_arr[$i] = $arr[$i];
                    }
                }elseif($number>25 && $number<703){
                    if(is_int(($i+1)/26)){
                        $a =$arr[floor(($i+1)/26)-2];
                        $b ='Z';
                    }else{
                        $a =$arr[floor(($i+1)/26)-1];
                        $b = $arr[(($i+1)%26)-1];
                    }
                    $data_arr[$a.$b] =$array[$i];
                    if($true == false){
                        $data_arr[$i] =$a.$b;
                    }
                }
            }
            return $data_arr;
        }

        public function exportExcel(){
            /*表格文件名称*/
            $expTitle = $this->verify_param('file_name');
            $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
            $fileName = $xlsTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
            /*Excel表格*/
            $expCellName = $this->verify_param('data_title');
            $cellNum = count($expCellName);/*统计表格数组*/
            /*Excel表格要导出的数据*/
            $expTableData = $this->verify_param('data');
            $dataNum = count($expTableData);/*数据的总数量*/
            $cellName =  $this->sum($expCellName,false);/*标题栏的组装对应数组*/
            $objPHPExcel = new \PHPExcel();
            /*是否传递了表格标题*/
            $i_num = 1;
            if(isset($this->title)){
                $objPHPExcel->getActiveSheet(0)->mergeCells('A'.$i_num.':'.$cellName[$cellNum-1].$i_num);//合并单元格
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $this->title.'  Export time:'.date('Y-m-d H:i:s'));
                $i_num = $i_num+1;
            }
            for($i=0;$i<$cellNum;$i++){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].$i_num, $expCellName[$i][1]);
            }
            $i_num = $i_num+1;
            // Miscellaneous glyphs, UTF-8
            for($i=0;$i<$dataNum;$i++){
                for($j=0;$j<$cellNum;$j++){
                    $expTableData[$i][$expCellName[$j][0]] = isset($expTableData[$i][$expCellName[$j][0]]) ? $expTableData[$i][$expCellName[$j][0]]: 0;
                    $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].$i_num, $expTableData[$i][$expCellName[$j][0]]);
                }
            }
            header('pragma:public');
            header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$fileName.'.xls"');
            header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            return true;
        }

    }