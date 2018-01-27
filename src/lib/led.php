<?php
/**
 * 主要库
 */
require('conf/conf.php');
require('render/template_render.php');
// 数据库
require('db/db.php');

// 错误信息
require('error.php');

// 工具类
require('util.php');

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
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			self::get_handler();
		} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			self::post_handler();
		}
		
		// 什么都获取不到则渲染主页
		self::render('index');
	}
	
	/**
	* 处理get请求
	*/
	private static function get_handler() {
		if (isset($_GET['login'])) {
			if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
				header('refresh:0;url=.');
			}
			
			$login_templates = Array(
				'header_title' => '登录',
				'title' => '标准LED查询系统 - 登录',
				'script' => 'templates/js/login.js',
			);
			self::render('login', $login_templates);
		} else if (isset($_GET['install'])) {
			$install_templates = Array(
				'header_title' => '安装',
			);
			self::render('install', $install_templates);
		}
	}
	
	/**
	* 处理post请求
	*/
	private static function post_handler() {
		$request = file_get_contents('php://input');
		
		$decode_req = json_decode($request, TRUE);
		
		if ($decode_req == FALSE) {
			Error::errMsg('json_parse_error');
		}
		
		if (!isset($decode_req['request'])) {
			Error::errMsg('request_parm_miss_error');
		}
		
		// 登录
		if ($decode_req['request'] == 'login') {
			global $config;
			
			// 是否设置登录验证
			if ($config['site']['login_validate']) {
				$expect_array = Array(
					'username' => Array(
						'regexp' => '/^[A-Za-z0-9]{1,32}$/', // A-Za-z0-9的1到32位
					),
					'password' => Array(
						'regexp' => '/^[\w]{6,32}$/', // \w的6-32位
					),
				);
				$result = Util::expect($expect_array, $decode_req);
				
				if ($result != 'pass') {
					Error::errMsg('param_error', $result);
				}
			}
			
			$user_info = DB::login($decode_req['username']);
			
			if ($user_info == 'no such user') {
				Error::errMsg('user_or_pass_error');
			}
			
			if ($user_info['password'] != md5($decode_req['password'])) {
				Error::errMsg('user_or_pass_error');
			}
			
			$_SESSION['user']['status'] = true;
			$_SESSION['user']['username'] = $decode_req['username'];
			
			Error::succMsg('login_success');
		// 查询
		} else if ($decode_req['request'] == 'query') {
			
		}
		exit();
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
		$nav_content = file_get_contents($config['site']['template_folder'] . '/' . $config['page']['nav']);
		$footer_content = file_get_contents($config['site']['template_folder'] . '/' . $config['page']['footer']);
		// 替换body，header，nav，footer三部分
		$layout_content = str_replace('{{ header }}', $header_content, $layout_content);
		$layout_content = str_replace('{{ nav }}', $nav_content, $layout_content);
		$layout_content = str_replace('{{ block body }}', $template_content, $layout_content);
		$layout_content = str_replace('{{ footer }}', $footer_content, $layout_content);
		
		$entries = Array (
			'title' 		=> '标准LED查询系统 - 首页',
			'header_title' 	=> '首页',
			'css_file' 		=> 'templates/css/main.css',
			'script' 		=> 'templates/js/index.js',
			'date'			=> date('Y年m月d日'),
		);
		
		if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
			$login_entries = Array (
				'login_info' => '登录了',
			);
		} else {
			$login_entries = Array (
				'login_info' => '<a href="?login">会员登录</a>'
			);
		}
		$entries = array_merge($entries, $login_entries);
		
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