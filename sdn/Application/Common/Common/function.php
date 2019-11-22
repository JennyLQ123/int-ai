<?php
/**
 * Created by PhpStorm.
 * User: hysy
 * Date: 2018/8/6
 * Time: 11:44
 */
//通过cul_init获取json格式数据的共同代码
 function curl($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
	//dump($result);
    if(curl_errno($ch)){
        $ret['err'] = curl_errno($ch);
//        dump($ret);
        return $ret;
    }
    curl_close($ch);
    return $result;
}
?>