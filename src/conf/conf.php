<?php
$config = Array (
	// 模板页面位置
	'page' => Array (
		'layout' 	=> 'layout.html', 			// 模板
		'install' 	=> 'install.html',			// 安装
		'index'		=> 'index.html',  			// 主页
		'login'		=> 'login.html',			// 登录
		'header'	=> 'parts/header.html',		// 页首部分
		'nav'		=> 'parts/nav.html',		// 导航栏
		'footer' 	=> 'parts/footer.html',		// 页脚部分
	),
	// 安装部分
	'install' => Array (
		'not_install_certification' => 'install/NOT_INSTALL',
	),
	// 站点设置
	'site' => Array (
		'template_folder' 	=> 'templates', 	// 模板位置
		'login_validate'	=> false,
	),
);
?>