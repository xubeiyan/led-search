<?php
/**
 * 主要库
 */
require('conf/conf.php');
require('render/template_render.php');

class LED {
	/**
	 * 检查是否安装
	 */
	public static function install_status() {
		global $config;
		if (file_exists($config['install']['not_install_certification'])) {
			self::render('install');
		}
	}
	/**
	 * 开始
	 */
	public static function start() {
		if (isset($_GET['login'])) {
			$login_templates = Array(
				'header_title' => '登录',
				'title' => '标准查询系统 - 登录',
			);
			self::render('login', $login_templates);
		} else if (isset($_GET['install'])) {
			$install_templates = Array(
				'header_title' => '安装',
			);
			self::render('install', $install_templates);
		}
		
		// 什么都获取不到则渲染主页
		self::render('index');
	}
	
	/**
	* 渲染调用
	* @param 要渲染的页面值
	* @param 要渲染的数组
	*/
	private static function render($page_str, $page_templates = Array()) {
		global $config;
		
		// config有此页面则将其赋值到$page，没有则尝试templates目录下的$page_str + .html的形式
		if (array_key_exists($page_str, $config['page'])) {
			$page = $config['page'][$page_str];
		} else {
			$page = $page_str . '.html';
		}
		
		// 检查模板文件是否存在
		if (!file_exists($config['site']['template_folder'] . '/' . $page)) {
			die('template file <b>' . $page . '</b> seems not exists...');
		}
		 
		$time_start = microtime();
		
		$layout_content = file_get_contents($config['site']['template_folder'] . '/' . $config['page']['layout']);
		$template_content = file_get_contents($config['site']['template_folder'] . '/' . $page);
		$header_content = file_get_contents($config['site']['template_folder'] . '/' . $config['page']['header']);
		$footer_content = file_get_contents($config['site']['template_folder'] . '/' . $config['page']['footer']);
		// 替换body，header，footer三部分
		$layout_content = str_replace('{{ block body }}', $template_content, $layout_content);
		$layout_content = str_replace('{{ header }}', $header_content, $layout_content);
		$layout_content = str_replace('{{ footer }}', $footer_content, $layout_content);
		
		$entries = Array (
			'title' 		=> '标准查询系统',
			'header_title' 	=> '首页',
			'css_file' 		=> 'templates/css/main.css',
			'script' 		=> '1.js',
			'date'			=> date('Y年m月d日'),
		);
		
		// 将自定义渲染的部分放入$entries中
		if ($page_templates != Array()) {
			$entries = array_merge($entries, $page_templates);
		}
		
		// print_r($entries);
		
		$result = Render::render_page($layout_content, $entries);
		$time_used = '渲染时间：' . (microtime() - $time_start) * 1000 . '毫秒';
		echo $result;
		echo $time_used;
		exit();
	}
}
?>