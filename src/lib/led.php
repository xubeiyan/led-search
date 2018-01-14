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
			$page = $config['page']['install'];
			self::render($page);
		}
	}
	/**
	 * 开始
	 */
	public static function start() {
		self::render('install');
	}
	
	/**
	* 渲染调用
	* @param 要渲染的页面
	*/
	private static function render($page) {
		global $config;
		$time_start = microtime();
		
		$layout_content = file_get_contents($config['site']['template_folder'] . '/' . $config['page']['layout']);
		$template_content = file_get_contents($config['site']['template_folder'] . '/' . $page);
		$header_content = file_get_contents($config['site']['template_folder'] . '/' . $config['page']['header']);
		$footer_content = file_get_contents($config['site']['template_folder'] . '/' . $config['page']['footer']);
		$replace_content = str_replace('{{ block body }}', $template_content, $layout_content);
		
		$entries = Array (
			'title' => '安装',
			'css_file' => 'templates/css/main.css',
			'header' => $header_content,
			'footer' => $footer_content,
			'script' => '1.js',
		);
		
		// print_r($entries);
		
		$result = Render::render_page($replace_content, $entries);
		$time_used = '渲染时间：' . (microtime() - $time_start) . 's';
		echo $result;
		echo $time_used;
		exit();
	}
}
?>