<?php

/**
 * 获取oa84的115网盘礼包码
 *
 * @author boxcore
 * @date   2015-05-05
 * @param  int     $id
 * @return string|null
 */
function get_oa84_gift_code($id) {
    $url = "http://115.oa84.com/hits.php";
    $post_data = array (
        "id" => intval($id),
    );
     
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  //时候将获取数据返回
     
    // 我们在POST数据哦！
    curl_setopt($ch, CURLOPT_POST, 1); //设置为POST传输
     
    // 把post的变量加上
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); //post过去数据
     
    $output = curl_exec($ch);
     
    if($output === false){  //判断错误
       echo curl_error($ch);
    }
     
    $info = curl_getinfo($ch);  //能够在cURL执行后获取这一请求的有关信息
    curl_close($ch);
    // echo $output;
    if( preg_match('#name="gift\_code"\svalue="([\w\d]+)"#', $output, $e) ) {
        return $e[1];
    }

    return null;
}

/**
 * 通过oa84资源链接获取id
 *
 * @author boxcore
 * @date   2015-05-05
 * @param  string     $url
 * @return int
 */
function get_oa84_id_by_url($url){
    $url = trim($url);
 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  //时候将获取数据返回

    // 补加ignore会报错 : http://www.111cn.net/phper/31/36446.htm
    $output = iconv( 'GB2312', 'UTF-8//ignore', curl_exec($ch));
     
    if($output === false){  //判断错误
       echo curl_error($ch);
    }
     
    $info = curl_getinfo($ch);  //能够在cURL执行后获取这一请求的有关信息
    curl_close($ch);

    if( preg_match('#name="id" value="(\d+)"#i', $output, $e) ) {
        return $e[1];
    }

    return null;
}

/**
 * 通过oa84资源链接获取礼包代码
 *
 * @author boxcore
 * @date   2015-05-05
 * @param  string     $url
 * @return string
 */     
function get_gift_code($url){
    $code = '';
    $id = get_oa84_id_by_url($url);
    if($id>0 && is_numeric($id)){
        $code = get_oa84_gift_code($id);
    }

    return $code;
}

// $url = 'http://115.oa84.com/id-NTAyNjY.html';
// echo get_gift_code($url);