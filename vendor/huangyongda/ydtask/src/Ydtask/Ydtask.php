<?php
/**
 * Created by PhpStorm.
 * User: huangyongda
 * Date: 2017/7/28
 * Time: 16:27
 */

namespace Ydtask;

class Ydtask
{
    static $kill_sig=0;
    private $run_num;
    private $fn;
    private $restartCheckFilePath;
    private $redis_host;
    private $redis_port;
    private $redis_task_list_name;
    private $isDaemonizeModel;
    private $printInfoPath;

    public function __construct()
    {
        self::$kill_sig=0;
        $this->restartCheckFilePath="";
        $this->fn=function(){};
        $this->run_num=2;
        $this->redis_host="192.168.233.129";
        $this->redis_port="6379";
        $this->redis_task_list_name="tasklist";
        $this->isDaemonizeModel=0;
        $this->printInfoPath="";
        $this->runConfig=array();
        $this->runing=array();
        $this->pidRunLevel=array();
        $this->pidPath="";
        $this->runCommandStr="";//运行命令
        $this->redis = new \Redis();
        $this->myids=array();//子进程id列表
    }

    /**
     * 设置自动重启的检测目录
     * @param $path
     * @return $this
     */
    public function setRestartCheckFilePath($path)
    {
        $this->restartCheckFilePath=$path;
        return $this;
    }

    /**
     * redis host
     * @param $path
     * @return $this
     */
    public function setRedisHost($str)
    {
        $this->redis_host=$str;
        return $this;
    }
    /**
     * redis port
     * @param $path
     * @return $this
     */
    public function setRedisPort($str)
    {
        $this->redis_port=$str;
        return $this;
    }
    /**
     * redis 任务队列的名称
     * @param $path
     * @return $this
     */
    public function setRedisTasklistName($str)
    {
        $this->redis_task_list_name=$str;
        return $this;
    }
    /**
     * 运行命令
     * @param $path
     * @return $this
     */
    public function setCommand($str)
    {
        $this->runCommandStr=$str;
        return $this;
    }
    /**
     * redis 任务队列的名称
     * @param $path
     * @return $this
     */
    public function setRunConfig($runLevel=1,$runNum=1)
    {
        $this->runConfig[$runLevel]=$runNum;
        return $this;
    }


    public function isDaemonize($daemonize=true)
    {
        $this->isDaemonizeModel=$daemonize;
        return $this;
    }

    /**
     * 守护进程
     */
    private function daemonize()
    {

        umask(0);
        $pid = pcntl_fork();
        if (-1 === $pid) {
            throw new \Exception('fork fail');
        } elseif ($pid > 0) {
            exit(0);
        }
        if (-1 === posix_setsid()) {
            throw new \Exception("setsid fail");
        }
        // Fork again avoid SVR4 system regain the control of terminal.
        $pid = pcntl_fork();
        if (-1 === $pid) {
            throw new \Exception("fork fail");
        } elseif (0 !== $pid) {
            exit(0);
        }

    }

    /**
     * 信号处理
     * @param $signo
     */
    private static function sighandler($signo)
    {
        self::$kill_sig=1;
//        $this->printInfo( "进程:".getmypid().",收到结束信号:".$signo."\n" );
    }

    /**
     * 设置任务数量
     * @param int $num
     * @return $this
     */
    public function setTaskNum($num=1)
    {
        $this->run_num=$num;
        return $this;
    }

    /**
     * 设置屏幕输出的内容到文件
     * @param $path
     * @return $this
     */
    public function setPrintInfoPath($path)
    {
        $this->printInfoPath=$path;
        return $this;
    }

    public function printInfo($info)
    {
        if($this->printInfoPath)
        {
            $fh = fopen($this->printInfoPath, "a");
            fwrite($fh, $info);
            fclose($fh);
        }
        if(!$this->isDaemonizeModel )
        {
            echo $info;
        }
    }

    /**
     * 设置屏幕输出的内容到文件
     * @param $path
     * @return $this
     */
    public function setPidPath($path)
    {
        $this->pidPath=$path;
        return $this;
    }

    private function writePid($pid)
    {
        $fh = fopen($this->pidPath, "a");
        fwrite($fh, $pid);
        fclose($fh);
    }

    private function check()
    {
        if(!trim($this->redis_task_list_name))
        {
            $this->printInfo( "请设置进程的队列名称..\n");
            exit(0);
        }
        if(count($this->run_num)<=0)
        {
            $this->printInfo( "请设置进程的数量..\n");
            exit(0);
        }
        if(!$this->pidPath)
        {
            $this->printInfo( "请设置pid的路径..\n");
            exit(0);
        }
        if(file_exists($this->pidPath) )
        {
            $this->printInfo( "程序已经运行，请不要重复运行..\n");
            exit(0);
        }
    }

    private function stop()
    {
        $cur_run_pid = "";
        if(file_exists($this->pidPath)){
            $cur_run_pid = file_get_contents($this->pidPath);//将整个文件内容读入到一个字符串中
        }
        if(!$cur_run_pid)
        {
            $this->printInfo( "找不到pid程序停止失败..\n");
            exit(0);
        }
        $shell_str="ps -ef|awk '{print $1\" \"$2\" \"$3\" \"$4}'|grep \"\ ".$cur_run_pid."\ \" |awk '{print $2}'";
        exec($shell_str,$out);
//                print_r($out);
        //echo var_export($out,true);
        //$out=explode("\n",$out);
        //print_r($out);
        $this->printInfo( "[".date("Y-m-d H:i:s")."]停止程序中".$cur_run_pid."...\n");
        foreach ($out as $pid) {
            $kill_info=posix_kill($pid, 2);
            $this->printInfo( "[".date("Y-m-d H:i:s")."]结束子进程 pid:【".$pid."结果". var_export($kill_info,true)."】\n");
        }
        for (;;){
            if(exec($shell_str."|wc -l") >0  ){
                sleep(1);
            }
            else{
                $this->printInfo( "[".date("Y-m-d H:i:s")."]程序".$cur_run_pid."停止成功...\n");exit(0);
            }
        }
    }

    private function runCommand()
    {
        switch ($this->runCommandStr) {
            case "stop":
                $this->stop();
                exit(0);
                break;
            case "":
                break;
            case "":
                break;
            default :
                break;
        }
    }


    public function run()
    {
        if(count($this->runConfig)>0){
            $this->run_num=array_sum($this->runConfig);
        }
        $this->runCommand();
        $this->check();

        $this->myids=array();


        declare(ticks=1);
        if($this->isDaemonizeModel)
        {
            $this->daemonize();
        }

        $this->writePid(getmypid());

        pcntl_signal(SIGINT, [__CLASS__, 'sighandler']);

        pcntl_signal(SIGCHLD, SIG_IGN); //如果父进程不关心子进程什么时候结束,子进程结束后，内核会回收。

        clearstatcache();//清除文件状态缓存。
        $last_update_time=$this->getFileNewTime($this->restartCheckFilePath);
        $this->run_task($this->run_num);
        for (;;){
            foreach ($this->myids as $key=>$pid) {
                $res = pcntl_waitpid($pid, $status, WNOHANG);
                if($res == -1 || $res > 0){
                    unset($this->myids[$key]);
                    $runLevel=$this->pidRunLevel[$pid];
                    unset($this->pidRunLevel[$pid]);
                    if(isset($this->runing[$runLevel]) ){
                        $this->runing[$runLevel]--;
                    }
                }

            }
            //echo "self::kill_sig".self::$kill_sig.">>".count($this->myids)."\n";
            if(self::$kill_sig==1 && count($this->myids)==0){
                $this->printInfo( "主进程结束..\n");
                unlink ($this->pidPath);//删除pid的文件
                exit(0);
            }
            if(self::$kill_sig==0 && count($this->myids)==0){
                $this->printInfo( "主进程重启..\n");
                $this->run_task($this->run_num);
            }
            clearstatcache();//清除文件状态缓存。
            if($this->restartCheckFilePath && $this->getFileNewTime($this->restartCheckFilePath)>$last_update_time ){
                $last_update_time=$this->getFileNewTime($this->restartCheckFilePath);
                $this->printInfo( "[".date("Y-m-d H:i:s")."]重启...."."\n");

                foreach ($this->myids as $key=>$pid) {
                    $res = pcntl_waitpid($pid, $status, WNOHANG);
                    if($res==0){
//                        $kill_info=posix_kill($pid, SIGTERM);
                        $kill_info=posix_kill($pid, 2);
                        $this->printInfo( "结束子进程 pid:【".$pid."结果". var_export($kill_info,true)."】\n");
                    }
                }
            }
            if(count($this->myids) <$this->run_num){
                $this->run_task($this->run_num-count($this->myids) );
            }
            sleep(2);
        }



    }

    /**
     * 获取目录最新文件的更新时间
     * @param $dir
     * @return bool|int
     */
    private function getFileNewTime($dir)
    {
        $last_update_time=0;
        if(is_dir($dir))
        {
            if ($dh = opendir($dir))
            {
                while (($file = readdir($dh)) !== false)
                {
                    if($file=="." || $file==".."){
                        continue;
                    }
                    if(is_dir($dir."/".$file))
                    {
                        $fmtime=$this->getFileNewTime($dir."/".$file);
                        $last_update_time=$fmtime>$last_update_time?$fmtime:$last_update_time;
                    }
                    else
                    {
                        if(substr(strrchr($file, '.'), 1) == "php"){
                            $fmtime=filemtime($dir."/".$file);
                            $last_update_time=$fmtime>$last_update_time?$fmtime:$last_update_time;
                        }
                    }
                }
                closedir($dh);
            }
        }
        return $last_update_time;
    }


    private function convert($size){
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
    private function run_task($num=2)
    {
        for ($i=1;$i<=$num;$i++){
            $run_level="";
            foreach ($this->runConfig as $level=>$run_num) {
                if(!isset($this->runing[$level])){
                    $this->runing[$level]=0;
                }
                if($this->runing[$level]<$run_num){
                    $run_level=$level;//
                    $this->runing[$level]++;
                    break;//跳出
                }
            }
            $pid = pcntl_fork();    //创建子进程
            //父进程和子进程都会执行下面代码
            if ($pid == -1) {
                //错误处理：创建子进程失败时返回-1.
                die('错误处理：创建子进程失败时返回-1.');
            } else if ($pid) {
                $this->myids[] = $pid;
                $this->pidRunLevel[$pid] = $run_level;//
                //父进程会得到子进程号，所以这里是父进程执行的逻辑
                //如果不需要阻塞进程，而又想得到子进程的退出状态，则可以注释掉pcntl_wait($status)语句，或写成：
//                pcntl_wait($status,WNOHANG); //等待子进程中断，防止子进程成为僵尸进程。
                //pcntl_wait($status,WNOHANG); //等待子进程中断，防止子进程成为僵尸进程。
                //echo "父进程结束".$status;
            } else {
                //子进程得到的$pid为0, 所以这里是子进程执行的逻辑。
                //sleep(1);
                $this->child($run_level);
                exit(0) ;
            }
        }
    }

    public function callFunction($fn)
    {
        $this->fn=$fn;
        return $this;
    }

    /**
     * 子进程
     */
    private function child($run_level="")
    {

        $id = getmypid();
        $this->printInfo( "创建子进程：".($run_level?"level[".$run_level."]":"")."[" . $id . "]>>>\n");
        for (;;) {
            $info="";
            $list=array();
            try {
                if(self::$kill_sig==1){
                    $this->printInfo( "结束子进程".($run_level?"level[".$run_level."]":"")."[".$id."]\n");exit(0);
                }
                $list = $this->TaskPop($run_level);
                if (count($list) <= 0) {
                    continue;
                }
                $fn=$this->fn;
                $info = $fn($list);
                if(!$info){
                    throw new \Exception("任务调用失败返回值[".var_export($info,true)."]");
                }
            } catch (\PDOException $e) {
                $info= "\e[0;31mPDOException >>>>" . $e->getMessage()."\e[0m";
            } catch (\ErrorException $e) {
                if(count($list)>0 ){
                    $this->redis->lPush($list[0]."_error", $list[1]);
                }
                $info= "\e[0;31mErrorException >>>>" . $e->getMessage()."\e[0m";
            } catch (\RedisException $e) {
                $info= "\e[0;31mRedisException >>>>" . $e->getMessage().",line:".$e->getLine()."\e[0m";
            } catch (\Exception $e) {
                if(count($list)>0 ){
                    $this->redis->lPush($list[0]."_error", $list[1]);
                }
                $info= "\e[0;31mException >>>>" . $e->getMessage() ."\e[0m";
            }
            $this->printInfo( "\033[1;33m[子进程:" . $id . ",".($run_level?"level:".$run_level.",":"")."".
            $this->convert(memory_get_usage(true)).
            "," . date("Y-m-d H:i:s") . "]\e[0m ".
            "出队" . (isset($list)&&isset($list[0])?$list[0]:"null") . ":" .
                (isset($list)&&isset($list[1])?$list[1]:"null") ." ".
                "返回" . var_export($info,true) . "\n");
            if(self::$kill_sig==1){
                $this->printInfo( "结束子进程".$id."\n");exit(0);
            }

        }
    }

    /**
     * 任务出队
     */
    public function TaskPop($run_level="")
    {
        try {
            $ping_str=$this->redis->ping();
            if(!$ping_str){
                throw new \RedisException("ping服务器redis失败".$this->redis_host.":".$this->redis_port,231301);
            }
        } catch (\RedisException $e) {
            $this->redisConnect();
        }
        $redis_task_list_name=$this->redis_task_list_name;
        if(is_string($redis_task_list_name))
        {
            $redis_task_list_name.=$run_level;
        }
        if(is_array($redis_task_list_name)){
            foreach ($redis_task_list_name as $key=>$item) {
                $redis_task_list_name[$key].=$run_level;
            }
        }
        $list = $this->redis->brPop($redis_task_list_name, 5);//这个时间必须小于connect配置的时间

        return $list;
    }

    private function redisConnect()
    {
        $connetct_redis=@$this->redis->connect($this->redis_host, $this->redis_port,10);//10秒超时
        if(!$connetct_redis){
            throw new \RedisException("连接redis失败[".$this->redis_host.":".$this->redis_port."]",231302);
        }

    }
}