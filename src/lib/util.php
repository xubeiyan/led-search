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
			// 管理员权限不允许修改
			if ($value['RoleId'] == 1) {
				$returnStr .= '<tr>';
				$returnStr .= sprintf('<td>%s</td><td>%s</td><td>%s</td>', 
				$value['username'], '管理员', '---');
				$returnStr .= '</tr>';
			} else {
				$enable = $value['userStatus'] == 'enable' ? 'selectd' : '';
				$disable = $value['userStatus'] == 'disable' ? 'selected' : '';
				$toauth = $value['userStatus'] == 'toauth' ? 'selected' : '';
				
				$userStatus = sprintf('
				<select id="status-%s" onchange="selectchange(this.id, this.value)">
					<option value="enable" %s>已启用</option>
					<option value="disable" %s>已停用</option>
					<option value="toauth" %s>待认证</option>
				</select>', $value['uid'], $enable, $disable, $toauth);
				
				$user = $value['RoleId'] == 2 ? 'selected' : '';
				$vip = $value['RoleId'] == 3 ? 'selected' : '';
				
				$roleId = sprintf('
				<select id="role-%s" onchange="selectchange(this.id, this.value)">
					<option value="user" %s>一般用户</option>
					<option value="vip" %s>高级用户</option>
				</select>
				', $value['uid'], $user, $vip);
				
				$returnStr .= '<tr>';
				$returnStr .= sprintf('<td>%s</td><td>%s</td><td>%s</td>', 
					$value['username'], $roleId, $userStatus);
				$returnStr .= '</tr>';
			}
		}
		return $returnStr;
	}
}

?>