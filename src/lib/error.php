<?php
class Error {
	/**
	* 输出错误信息
	*/
	public static function errMsg($err_str, $err_info = '', $type = 'json') {
		if ($err_str == 'json_parse_error') {
			$err_msg = 'JSON解析错误';
		} else if ($err_str == 'request_parm_miss_error') {
			$err_msg = '请求中缺少request字段';
		} else if ($err_str == 'param_error') {
			$err_msg = $err_info;
		} else if ($err_str == 'user_or_pass_error') {
			$err_msg = '用户名或密码错误';
		} else {
			$err_msg = '未知错误';
		}
		
		if ($type == 'json') {
			$return_array = Array (
				'err_type' => $err_str,
				'err_msg' => $err_msg,
			);
			
			header('Content-Type: application/json');
			echo json_encode($return_array, JSON_UNESCAPED_UNICODE);
			exit();
		}
	}
	/**
	* 输出成功信息（为什么把它放到错误里呢
	*/
	public static function succMsg($succ_str, $type = 'json') {
		if ($succ_str == 'login_success') {
			$succ_msg = '登录成功';
		}
		
		if ($type == 'json') {
			$return_array = Array(
				'type': $msg_str,
				'msg': $succ_msg,
			);
			
			header('Content-Type: application/json');
			echo json_encode($return_array, JSON_UNESCAPED_UNICODE);
			exit();
		}
		
		echo 'Unexpected branch...';
		exit();
	}
}
?>