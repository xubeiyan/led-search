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
		} else if ($err_str == 'not_login_error') {
			$err_msg = '未登录';
		} else if ($err_str == 'user_disable_error') {
			$err_msg = '用户已停用';
		} else if ($err_str == 'oldpass_incorrect_error') {
			$err_msg = '旧密码不正确';
		} else if ($err_str == 'oldpass_require_error') {
			$err_msg = '必须提供旧密码';
		} else if ($err_str == 'not_admin_error') {
			$err_msg = '当前用户不是管理员';
		} else if ($err_str == 'update_empty_error') {
			$err_msg = '修改内容为空';
		} else if ($err_str == 'unexpect_end_error') {
			$err_msg = 'Unexpected end!';
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
		} else if ($succ_str == 'update_success') {
			$succ_msg = '修改成功';
		}
		
		if ($type == 'json') {
			$return_array = Array(
				'type' => $succ_str,
				'msg' => $succ_msg,
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