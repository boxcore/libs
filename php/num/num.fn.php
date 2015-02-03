<?php

/**
 * 数字处理函数集
 */

/**
 * 返回百分比
 *
 * @date   2015-02-03
 * @param  int|float     $denominator 分子
 * @param  int|float     $numerator   分母
 * @param  integer       $float       浮点精度，默认为2
 * @return string
 */
function to_pct($denominator, $numerator, $float=2){
    if( is_numeric($denominator) && is_numeric($numerator) && $numerator != 0){
        return round($denominator/$numerator*100, $float).'%';
    }
    return null;
}

echo to_pct(1,5);
echo "\n";
echo to_pct(0,'9');
echo "\n";
echo to_pct('0d',1);
echo "\n";
echo to_pct(1,0.6);
echo "\n";