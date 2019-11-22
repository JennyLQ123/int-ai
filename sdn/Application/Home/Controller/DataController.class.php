<?php
namespace Home\Controller;
use Think\Controller;
class DataController extends Controller {

    public function delay(){
        $url = "http://127.0.0.1:8080/sdn/json/data.json";
        $data_json = curl($url);
//        dump($data_json);
//        exit;
        $this->ajaxReturn($data_json);

    }
    public function rec(){

 //       exec("E:\software\Anacodapy3\python D:\Dwork\pythonwork\c.py 2>&1",$array,$ret);
       // dump($array);
		//dump($ret);
      //  $array.str_replace("'","\"");
      //  $this->ajaxReturn($array);
//        dump($ret);
		$url = "http://127.0.0.1:8080/rabbit/rec.php";
        $data_json = curl($url);
        //dump($data_json);
        $this->ajaxReturn($data_json);
    }
	public function test(){
		phpinfo();
	}
	    public function send(){
		$url = "http://127.0.0.1:8080/rabbit/send.php";
        $data_json = curl($url);
        //dump($data_json);
        $this->ajaxReturn($data_json);
    }
	
}