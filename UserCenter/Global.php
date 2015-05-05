<?php
/*-----------------------------------------------------------------------------
 * 法铂丽会员中心 - 全局方法
 *-----------------------------------------------------------------------------
 *
 * 包含常用的全局方法
 */

session_start();
error_reporting(0);

/**
 * GET 请求
 * @param string $url
 * @author  binsee <binsee@163.com>
 */
function http_get($url)
{
    //初始化
    $ch = curl_init();
    //设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    //执行并获取HTML文档内容
    $output = curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    //打印获得的数据
    return $output;
}
