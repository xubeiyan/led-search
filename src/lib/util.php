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
	
	/**
	* 生成Entity列表
	*/
	public static function makeEntityTable($result) {
		$returnStr = '<tr><td>名称</td><td>值</td><td>数据类型</td></tr>';
		$returnStr = '<tr><td>EntityID</td><td id="entityid">' . $result['EntityId'] . '</td><td>数据类型</td></tr>';
		$returnStr .= '<tr><td>标准编号</td><td><input id="stdnum" value="' .  $result['StdNum'] . '"></td><td>VARCHAR(20)</td></tr>';
		$returnStr .= '<tr><td>标准层级</td><td><input id="stdlevel" value="' .  $result['StdLevel'] . '"></td><td>VARCHAR(20)</td></tr>';
		$returnStr .= '<tr><td>行业分类</td><td><input id="category" value="' .  $result['Category'] . '"></td><td>VARCHAR(20)</td></tr>';
		$returnStr .= '<tr><td>中文名称</td><td><input id="chname" value="' .  $result['ChName'] . '"></td><td>VARCHAR(255)</td></tr>';
		$returnStr .= '<tr><td>英文名称</td><td><input id="enname" value="' .  $result['EnName'] . '"></td><td>VARCHAR(255)</td></tr>';
		$returnStr .= '<tr><td>发布日期</td><td><input id="releasedate" value="' .  $result['ReleaseDate'] . '"></td><td>DATE</td></tr>';
		$returnStr .= '<tr><td>实施日期</td><td><input id="impelementdate" value="' .  $result['ImpelementDate'] . '"></td><td>DATE</td></tr>';
		$returnStr .= '<tr><td>标准状态</td><td><input id="stdstatus" value="' .  $result['StdStatus'] . '"></td><td>VARCHAR(20)</td></tr>';
		$returnStr .= '<tr><td>代替标准</td><td><input id="alterstandard" value="' .  $result['AlterStandard'] . '"></td><td>VARCHAR(40)</td></tr>';
		$returnStr .= '<tr><td>采标号</td><td><input id="adoptno" value="' .  $result['AdoptNo'] . '"></td><td>VARCHAR(20)</td></tr>';
		$returnStr .= '<tr><td>采标名称</td><td><input id="adoptname" value="' .  $result['AdoptName'] . '"></td><td>VARCHAR(40)</td></tr>';
		$returnStr .= '<tr><td>采标程度</td><td><input id="adoptlev" value="' .  $result['AdoptLev'] . '"></td><td>VARCHAR(20)</td></tr>';
		$returnStr .= '<tr><td>采标类型</td><td><input id="adopttype" value="' .  $result['AdoptType'] . '"></td><td>VARCHAR(20)</td></tr>';
		$returnStr .= '<tr><td>ICS</td><td><input id="ics" value="' .  $result['ICS'] . '"></td><td>VARCHAR(20)</td></tr>';
		$returnStr .= '<tr><td>CCS</td><td><input id="ccs" value="' .  $result['CCS'] . '"></td><td>VARCHAR(20)</td></tr>';
		$returnStr .= '<tr><td>标准类型</td><td><input id="standardtype" value="' .  $result['StandardType'] . '"></td><td>VARCHAR(20)</td></tr>';
		$returnStr .= '<tr><td>产品类型</td><td><input id="producttype" value="' .  $result['ProductType'] . '"></td><td>VARCHAR(20)</td></tr>';
		$returnStr .= '<tr><td>主管部门</td><td><input id="departcharge" value="' .  $result['DepartCharge'] . '"></td><td>VARCHAR(127)</td></tr>';
		$returnStr .= '<tr><td>归口单位</td><td><input id="departresponse" value="' .  $result['DepartResponse'] . '"></td><td>VARCHAR(127)</td></tr>';
		$returnStr .= '<tr><td>公告号</td><td><input id="announcenum" value="' .  $result['AnnounceNum'] . '"></td><td>VARCHAR(20)</td></tr>';
		$returnStr .= '<tr><td>全文链接</td><td><input id="ctnlink" value="' .  $result['CtnLink'] . '"></td><td>VARCHAR(255)</td></tr>';
		$returnStr .= '<tr><td>摘要</td><td><textarea id="abstract">' . $result['Abstract'] .'</textarea></td><td>TEXT</td></tr>';
		return $returnStr;
		
	}
}

?>