<?php
/**
 * 与时间处理相关函数
 */


/**
 * 获取开始到结束相差天数
 *
 * @date   2015-01-31
 * @param  string|int     $start [description]
 * @param  string|int     $end   [description]
 * @return string|int
 */
function get_num_day($start, $end){
    $start_time = strtotime($start);
    $end_time = strtotime($end);
    $days = intval( round(($end_time-$start_time)/3600/24) );
    return $days+1;
}


/**
 * 获取一个月的第一天和最后一天
 *
 * @date   2015-02-04
 * @param  string     $date 月份，格式：Y-m | ym
 * @return array      每月的第一天和最后一天的数组
 */
function get_month_day_range($date) 
{ 
    $firstday = date('Y-m-01', strtotime("$date -1 month -1 day")); 
    $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day")); 
    return array($firstday, $lastday); 
}