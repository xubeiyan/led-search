<?php
/**
 * 入口文件
 */
// 主库内容
require('lib/led.php');

// 检查是否安装
LED::install_status();

// 开始 
LED::start();

?>