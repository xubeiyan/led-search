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
		session_start();
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
		// 登录
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
		// } else if (isset($_GET['install'])) {
			// $install_templates = Array(
				// 'header_title' => '安装',
			// );
			// self::render('install', $install_templates);
		// 登出
		} else if (isset($_GET['logout'])) {
			if (!isset($_SESSION['user']['status']) || $_SESSION['user']['status'] == false) {
				$info_templates = Array(
					'title' => '出错了',
					'info' => '并没有登录',
					'backUrl' => '.',
				);
				self::render('info', $info_templates);
			}
			
			unset($_SESSION['user']);
		// 标准体系
		} else if (isset($_GET['standard'])) {
			$standard_templates = Array(
				'header_title' => '标准体系结构图',
				'title' => '标准LED查询系统 - 体系结构',
			);
			self::render('standard', $standard_templates);
		// 用户信息
		} else if (isset($_GET['user'])) {
			if (!isset($_SESSION['user']['status']) || $_SESSION['user']['status'] == FALSE) {
				$info_templates = Array(
					'title' => '出错了',
					'info' => '并没有登录',
					'backUrl' => '.',
				);
				self::render('info', $info_templates);
			}
			
			$userInfo = DB::userInfo($_SESSION['user'], 'get');
			
			if ($userInfo == 'no such user') {
				$info_templates = Array(
					'title' => '出错了',
					'info' => '未找到该用户',
					'backUrl' => '.',
				);
				self::render('info', $info_templates);
			}
			
			$user_templates = Array (
				'header_title' => '用户信息',
				'title' => '标准LED查询系统 - 用户信息',
				'script' => 'templates/js/user.js',
			);
			
			$user_templates = array_merge($user_templates, $userInfo);
			
			self::render('user', $user_templates);
		// 管理页面
		} else if (isset($_GET['manage'])) {
			
		// 浏览页面
		} else if (isset($_GET['view'])) {
			if (!isset($_GET['entityid'])) {
				$info_templates = Array(
					'title' => '出错了',
					'info' => '没有提供EntityID',
					'backUrl' => '.',
				);
				self::render('info', $info_templates);
			}
			
			$entityid = is_numeric($_GET['entityid']) ? $_GET['entityid'] : 0;
			
			$searchArray = Array(
				'entityid' => $entityid
			);
			
			$resultArray = DB::viewStd($searchArray);
			
			if ($resultArray == 'no record') {
				$info_templates = Array(
					'title' => '出错了',
					'info' => '没找到EntityID为' . $entityid . '的记录',
					'backUrl' => '.',
				);
				self::render('info', $info_templates);
			}
			
			$view_templates = Array(
				'title' => '标准LED查询系统 - 浏览',
			);
			
			$view_templates = array_merge($view_templates, $resultArray);
			
			// print_r($resultArray);
			// exit();
			
			self::render('view', $view_templates);
		// 标准体系统计
		} else if (isset($_GET['statistics'])) {
			$statistics_templates = Array(
				'title' => '标准LED查询系统 - 标准体系统计',
			);
			
			self::render('statistics', $statistics_templates);
		// 标准查询
		} else if (isset($_GET['stdsearch'])) {
			$std_templates = Array (
				'header_title' => '标准查询',
				'title' => '标准LED查询系统 - 标准查询',
				'script' => 'templates/js/search.js',
			);
			self::render('stdsearch', $std_templates);
		// 高级查询
		} else if (isset($_GET['advancesearch'])) {
			$std_templates = Array (
				'header_title' => '高级查询',
				'title' => '标准LED查询系统 - 高级查询',
			);
			self::render('stdsearch', $std_templates);
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
						'regexp' => '/^[\w]{1,32}$/', // \w的6-32位
					),
				);
				$result = Util::expect($expect_array, $decode_req);
				
				if ($result != 'pass') {
					Error::errMsg('param_error', $result);
				}
			}
			
			$user_info = DB::login($decode_req['username']);
			
			// 不存在此用户
			if ($user_info == 'no such user') {
				Error::errMsg('user_or_pass_error');
			}
			
			// 用户已停用
			if ($user_info == 'user disabled') {
				Error::errMsg('user_disable_error');
			}
			
			
			if (!password_verify($decode_req['password'], $user_info['password'])) {
				Error::errMsg('user_or_pass_error');
			}
			
			$_SESSION['user']['status'] = true;
			$_SESSION['user']['username'] = $decode_req['username'];
			$_SESSION['user']['roleId'] = $user_info['roleId'];
			
			Error::succMsg('login_success');
		// 标准查询
		} else if ($decode_req['request'] == 'stdsearch') {
			$searchArray = Array();
			$searchArray['keyword'] = isset($decode_req['keyword']) ? $decode_req['keyword'] : '%';
			$searchArray['search_type'] = isset($decode_req['search_type']) ? $decode_req['search_type'] : 'standard_type';
			
			if (!($searchArray['search_type'] == 'standard_type' || $searchArray['search_type'] == 'product_type' ||
				$searchArray['search_type'] == 'stdlevel' || $searchArray['search_type'] == 'std_status' || 
				$searchArray['search_type'] == 'std_num' || $searchArray['search_type'] == 'std_name')) {
					$searchArray['search_type'] = 'standard_type';
				}
			
			if (isset($decode_req['page'])) {
				$page = $decode_req['page'] == '' ? 0 : $decode_req['page'];
			} else {
				$page = 0;
			}
			
			global $config;
			
			$pageArray = Array(
				'from' 		=> $page * $config['site']['record_per_page'],
				'perPage' 	=> $config['site']['record_per_page'],
			);
			
			$result = DB::search($searchArray, $pageArray);
			
			Util::searchResult($result);
			
			
		// 更新用户信息
		} else if ($decode_req['request'] == 'updateUserInfo') {
			
			// 未提供旧密码
			if (!isset($decode_req['oldpass'])) {
				Error::errMsg('oldpass_require_error');
			}
			
			$user_info = DB::login($_SESSION['user']['username']);
			
			// 不存在此用户
			if ($user_info == 'no such user') {
				Error::errMsg('user_or_pass_error');
			}
			
			// 用户已停用
			if ($user_info == 'user disabled') {
				Error::errMsg('user_disable_error');
			} 
			
			if (!password_verify($decode_req['oldpass'], $user_info['password'])) {
				Error::errMsg('oldpass_incorrect_error');
			}
			
			$userInfo = Array (
				'username' => $_SESSION['user']['username'],
				'nickname' => isset($decode_req['nickname']) ? $decode_req['nickname'] : '',
				'newpass' => $decode_req['newpass'],
				'email' => isset($decode_req['email']) ? $decode_req['email'] : "",
			);
			
			if (DB::userInfo($userInfo, 'set') == 'update success') {
				Error::succMsg('update_success');				
			}
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
		
		if (isset($_SESSION['user']['status']) && $_SESSION['user']['status'] == true) {
			// 判断是不是管理员
			if ($_SESSION['user']['roleId'] == 1) {
				$login_entries = Array (
					'login_info' => '<a href="?user">' . $_SESSION['user']['username'] . '</a> | <a href="?manage">管理</a> | <a href="?logout">登出</a>',
				);	
			} else {
				$login_entries = Array (
					'login_info' => '<a href="?user">' . $_SESSION['user']['username'] . '</a> | <a href="?logout">登出</a>',
				);				
			}
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
		echo '<pre>';
		print_r($_SESSION);
		echo '</pre>';
		exit();
	}
}
?>