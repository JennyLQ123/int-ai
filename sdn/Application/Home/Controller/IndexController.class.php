<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display("index");
    }
    public function index_search(){
        $url = "http://127.0.0.1:8080/sdn/json/test.json";
        $data_json = curl($url);
//        dump($data_json);
//        exit;
        $this->ajaxReturn($data_json);

    }
}