<?php

/**
 * 生成随机密码
 *
 * @author boxcore
 * @date   2014-07-08
 * @param  integer    $len        密码长度
 * @param  boolean    $mixed_case 是否转小写,(true不转小写,false转小写. 默认转小写)
 * @return string
 */
function random_password($len = 7, $mixed_case = false){
    $a = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789!_";
    if(!$mixed_case) $a = strtolower($a);
    $out = "";
    for($i = 0; $i < $len; $i++){
        $tmp = $a[mt_rand(0, (strlen($a) - 1) )];
        $out .= $tmp;
    }
           
    return $out;
}

echo random_password(8, 1);