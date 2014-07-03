<?php

/**
 * 多个sheet导出
 * ---------------------------------------------------
 *  $data格式: $data[id] = array(
 *              'sheet_name'  => 'sheet列名',
 *              'sheet_data'=> array(数据),
 *              'sheet_field' => array(数据字段对应标题),
 *              'sheet_width'=> array(数据字段对应宽度)
 *              );
 * ----------------------------------------------------
 *
 * @param $data array
 * @param $filename string 文件名
 *
 * @author boxcore<boxcore@live.com>
 * @url http://blog.boxcore.org
 * @date 2014/7/3
 */
function export_excel_obj($data, $filename) {

    $field_x = range('A', 'Z');
    $phpxcel = new PHPExcel();
    $writer  = new PHPExcel_Writer_Excel5($phpxcel);

    $sheet_index = 0;
    $sheet_num   = count($data);
    foreach ($data as $v) {

        if (!empty($v['sheet_field']) && !empty($v['sheet_data'])) {
            $field_keys  = array_keys($v['sheet_field']); //
            $field_name  = $v['sheet_field']; // 指定列标题
            $field_width = $v['sheet_width']; // 指定列宽度
            $sheet_name  = $v['sheet_name'] ? $v['sheet_name'] : 'Sheet'; // 表格名
            // 设定列指定ID
            foreach ($field_keys as $k => $vo) {
                $field_alpha[$vo] = $field_x[$k];
            }

            if ($sheet_index) {
                $phpxcel->createSheet($sheet_index);
                $phpxcel->setActiveSheetIndex($sheet_index);
            } else {
                $phpxcel->setActiveSheetIndex($sheet_index);
            }

            $phpxcel->getActiveSheet()->setTitle($sheet_name);

            // 设置列标题
            $row = 1;
            foreach ($field_keys as $k) {
                $phpxcel->getActiveSheet()->setCellValue("{$field_alpha[$k]}$row", $field_name[$k]);

            }

            // 生成表格数据
            ++$row; //列从 2开始
            foreach ($v['sheet_data'] as $vo) {
                foreach ($field_keys as $k) {
                    $phpxcel->getActiveSheet()->setCellValue($field_alpha[$k] . $row, $vo[$k]);
                }
                ++$row;
            }

            // 设置列宽
            if (!empty($field_width)) {
                foreach ($field_width as $k=>$vw) {
                    $phpxcel->getActiveSheet()->getColumnDimension($field_alpha[$k])->setWidth($vw);
                }
            }


            ++$sheet_index;

        }
    }

    $phpxcel->setActiveSheetIndex(0);

    /** 导出excel */
    header('Content-Type: application/vnd.ms-excel');


    // 设置头文件
    $ua               = $_SERVER["HTTP_USER_AGENT"];
    $filename         = (isset($filename) && !empty($filename)) ? $filename : '导出数据.xls';
    $encoded_filename = str_replace("+", "%20", urlencode($filename));
    if (preg_match("/MSIE/", $ua)) {
        header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
    } else if (preg_match("/Firefox/", $ua)) {
        header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
    } else {
        header('Content-Disposition: attachment; filename="' . $filename . '"');
    }

    header('Cache-Control: max-age=0');

    $writer->save('php://output'); // 输出到浏览器
}

// 模拟数据
$data[0] = array(
    'sheet_name'  => '测试列1',
    'sheet_data'=> array(
        array('id'=> '12','name'=>'name1','mark'=>'hello'),
        array('id'=> '12','name'=>'name1','mark'=>'hello'),
        array('id'=> '12','name'=>'name1','mark'=>'hello'),
    ),
    'sheet_field' => array('id'=>'序号','name'=>'名称','mark'=>'标记'),
    'sheet_width'=> array('name'=>15),
);
$data[1] = array(
    'sheet_name'  => '测试列2',
    'sheet_data'=> array(
        array('id'=> '12','name'=>'name1','mark'=>'hello'),
        array('id'=> '12','name'=>'name1','mark'=>'hello'),
        array('id'=> '12','name'=>'name1','mark'=>'hello'),
    ),
    'sheet_field' => array('id'=>'序号','name'=>'名称','mark'=>'标记'),
    'sheet_width'=> array('name'=>15),
);
$data[2] = array(
    'sheet_name'  => '测试列3',
    'sheet_data'=> array(
        array('id'=> '12','name'=>'name1','mark'=>'hello'),
        array('id'=> '12','name'=>'name1','mark'=>'hello'),
        array('id'=> '12','name'=>'name1','mark'=>'hello'),
    ),
    'sheet_field' => array('id'=>'序号','name'=>'名称','mark'=>'标记'),
    'sheet_width'=> array('name'=>15),
);

//导出模拟数据
require './PHPExcel.php'; // 引入PHPExcel类,在 https://github.com/PHPOffice/PHPExcel/tree/develop/Classes
export_excel_obj($data, '这是名字.xls');