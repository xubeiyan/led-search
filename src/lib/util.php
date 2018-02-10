<?php
/**
* 工具类
*/
class Util {
	/**
	* 检查字段
	*/
	public static function expect($expect, $request) {
		foreach ($expect as $key => $value) {
			if (!isset($request[$key])) {
				return 'not set key: ' . $key;
			}
			
			if (preg_match($value['regexp'], $request[$key]) == 0) {
				return 'not match regexp: ' . $key;
			}
		}
		return 'pass';
	}
	
	/**
	* 输出查询结果
	*/
	public static function searchResult($resultArray) {
		header('Content-Type: application/json');
		
		if ($resultArray == Array()) {
			$return_array = Array(
				'found_result' => 0,
				'results' => Array(),
			);
		} else {
			$length = count($resultArray);
		
			$return_array = Array(
				'found_result' => $length,
				'results' => $resultArray,
			);
		}
		return $return_array;
	}
	
	/**
	* 生成用户列表
	*/
	public static function makeUserTable($result) {
		$returnStr = '';
		foreach ($result as $value) {
			if ($value['userStatus'] == 'enable') {
				$userStatus = '已启用';
			} else if ($value['userStatus'] == 'disable') {
				$userStatus = '已停用';
			} else if ($value['userStatus'] == 'toauth') {
				$userStatus = '待认证';
			} else {
				$userStatus = '未知状态';
			}
			
			if ($value['RoleId'] == 1) {
				$roleId = '管理员';
			} else if ($value['RoleId'] == 2) {
				$roleId = '普通用户';
			} else if ($value['RoleId'] == 3) {
				$roleId = 'VIP用户';
			}
			
			$returnStr .= '<tr>';
			$returnStr .= sprintf('<td>%s</td><td>%s</td><td>%s</td>', 
				$value['username'], $roleId, $userStatus);
			$returnStr .= '</tr>';
		}
		return $returnStr;
	}
}

?>