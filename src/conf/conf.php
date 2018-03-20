<?php
$config = Array (
	// 模板页面位置
	'page' => Array (
		'layout' 		=> 'layout.html', 				// 模板
		'install' 		=> 'install.html',				// 安装
		'index'			=> 'index.html',  				// 主页
		'login'			=> 'login.html',				// 登录
		'user'			=> 'user.html',					// 用户信息
		'info'			=> 'info.html',					// 错误信息
		'manage'		=> 'manage.html',				// 管理(管理员)
		'header'		=> 'parts/header.html',			// 页首部分
		'nav'			=> 'parts/nav.html',			// 导航栏
		'footer' 		=> 'parts/footer.html',			// 页脚部分
		'edit'			=> 'edit.html',					// 编辑标准（管理员）
		'statistics'	=> 'statistics.html',			// 统计部分
		'stdsearch'		=> 'stdsearch.html',			// 标准查询
		'advancesearch'	=> 'advancesearch.html',		// 高级查询
	),
	// 安装部分
	'install' => Array (
		'not_install_certification' => 'install/NOT_INSTALL',
	),
	// 站点设置
	'site' => Array (
		'session_display'		=> false,			// SESSION显示
		'render_time_display'	=> false,			// 渲染时间显示
		'template_folder' 		=> 'templates', 	// 模板位置
		'login_validate'		=> false,
		'record_per_page'		=> 50,				// 查询时每页数量
		'visit_num'				=> true				// 查询人数显示
	),
);
?>