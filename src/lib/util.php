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
	public static function searchResult($resultArray, $page) {
		header('Content-Type: application/json');
		
		if ($resultArray == Array()) {
			$return_array = Array(
				'found_result' => 0,
				'page' => 0,
				'results' => Array(),
			);
		} else {
			$length = count($resultArray);
		
			$return_array = Array(
				'found_result' => $length,
				'page' => $page,
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
	
	/**
	* 统计列表标准
	*/
	public static function initStatisticTable() {
		$statisticTable = Array(
			'general_standard' => Array ( // 通用标准
				'na' => 0,
				'in' => 0,
			),
			'material' => Array ( // 材料
				'na' => 0,
				'in' => 0,
				'general_standard' => Array( // 材料通用标准
					'na' => 0,
					'in' => 0,
				),
				'substrate' => Array( // 衬底材料
					'na' => 0,
					'in' => 0,
				),
				'light' => Array( // 发光材料
					'na' => 0,
					'in' => 0,
				),
			),
			'chip_and_device' => Array ( // 芯片和器件
				'na' => 0,
				'in' => 0,
				'wafer' => Array ( // 外延片
					'na' => 0,
					'in' => 0,
				),
				'chip' => Array ( // 芯片
					'na' => 0,
					'in' => 0,
				),
				'device' => Array ( // 器件
					'na' => 0,
					'in' => 0,
				),
			),
			'light_device_and_system' => Array ( // 照明设备和系统
				'na' => 0,
				'in' => 0,
				'led_module' => Array ( // LED模块
					'na' => 0,
					'in' => 0,
				),
				'led_light_source' => Array ( // LED光源
					'na' => 0,
					'in' => 0,
				),
				'lamp_annex' => Array ( // 灯用附件
					'na' => 0,
					'in' => 0,
					'dedicated_integrated_circuit' => Array( // 专用集成电路
						'na' => 0,
						'in' => 0,
					),
					'drive_control_system' => Array( // 驱动控制装置
						'na' => 0,
						'in' => 0,
					),
					'light_interface' => Array( // 照明接口
						'na' => 0,
						'in' => 0,
					),
				),
				'lamp_holder_and_socket' => Array ( //灯头灯座
					'na' => 0,
					'in' => 0,
				),
				'lamps' => Array ( // 灯具
					'na' => 0,
					'in' => 0,
				),
				'light_system' => Array ( // 照明系统
					'na' => 0,
					'in' => 0,
					'intelligent_control_system' => Array( // 智能控制系统
						'na' => 0,
						'in' => 0,
					),
					'sensor_system' => Array( // 传感器系统
						'na' => 0,
						'in' => 0,
					),
					'other_connection_system' => Array( // 其他连接系统
						'na' => 0,
						'in' => 0,
					),
				),
			),
			'others' => Array ( // 其他
				'na' => 0,
				'in' => 0,
			),
		);
		
		return $statisticTable;
	}
	
	public static function makeStatisticArr($table, $productType, $na, $in) {
		if ($productType == '通用标准') {
			$table['general_standard']['na'] = $na;
			$table['general_standard']['in'] = $in;
		// 材料部分
		} else if ($productType == '材料') {
			$table['material']['na'] = $na;
			$table['material']['in'] = $in;
		} else if ($productType == '材料通用标准') {
			$table['material']['general_standard']['na'] = $na;
			$table['material']['general_standard']['in'] = $in;
		} else if ($productType == '衬底材料') {
			$table['material']['substrate']['na'] = $na;
			$table['material']['substrate']['in'] = $in;
		} else if ($productType == '发光材料') {
			$table['material']['light']['na'] = $na;
			$table['material']['light']['in'] = $in;
		// 芯片和器件
		} else if ($productType == '芯片和器件') {
			$table['chip_and_device']['na'] = $na;
			$table['chip_and_device']['in'] = $in;
		} else if ($productType == '外延片') {
			$table['chip_and_device']['wafer']['na'] = $na;
			$table['chip_and_device']['wafer']['in'] = $in;
		} else if ($productType == '芯片') {
			$table['chip_and_device']['chip']['na'] = $na;
			$table['chip_and_device']['chip']['in'] = $in;
		} else if ($productType == '器件') {
			$table['chip_and_device']['device']['na'] = $na;
			$table['chip_and_device']['device']['in'] = $in;
		// 照明设备和系统
		} else if ($productType == '照明设备和系统') {
			$table['light_device_and_system']['na'] = $na;
			$table['light_device_and_system']['in'] = $in;
		} else if ($productType == 'LED模块') {
			$table['light_device_and_system']['led_module']['na'] = $na;
			$table['light_device_and_system']['led_module']['in'] = $in;
		} else if ($productType == 'LED光源') {
			$table['light_device_and_system']['led_light_source']['na'] = $na;
			$table['light_device_and_system']['led_light_source']['in'] = $in;
		} else if ($productType == '灯用附件') {
			$table['light_device_and_system']['lamp_annex']['na'] = $na;
			$table['light_device_and_system']['lamp_annex']['in'] = $in;
		} else if ($productType == '专用集成电路') {
			$table['light_device_and_system']['lamp_annex']['na'] = $na;
			$table['light_device_and_system']['lamp_annex']['in'] = $in;
		} else if ($productType == '灯用附件') {
			$table['light_device_and_system']['lamp_annex']['na'] = $na;
			$table['light_device_and_system']['lamp_annex']['in'] = $in;
		} else if ($productType == '灯头灯座') {
			$table['light_device_and_system']['lamp_holder_and_socket']['na'] = $na;
			$table['light_device_and_system']['lamp_holder_and_socket']['in'] = $in;
		} else if ($productType == '灯具') {
			$table['light_device_and_system']['lamps']['na'] = $na;
			$table['light_device_and_system']['lamps']['in'] = $in;
		} else if ($productType == '照明系统') {
			$table['light_device_and_system']['light_system']['na'] = $na;
			$table['light_device_and_system']['light_system']['in'] = $in;
		// 其他
		} else if ($productType == '其他') {
			$table['others']['na'] = $na;
			$table['others']['in'] = $in;
		}
		
		return $table;
	}
	
	public static function getStatisticInfo($table, $stdLevel, $productType) {
		
	}
	
	public static function makeStatisticTable($table) {
		$returnTable = '<tr><td rowspan="14" style="width: 20%">半导体照明综合标准化技术体系</td>';
		$returnTable .= '<td colspan="2">通用标准</td><td>' . $table['general_standard']['na'] . '</td><td>' . 
			$table['general_standard']['in'] . '</td><td>' . 
			($table['general_standard']['na'] + $table['general_standard']['in']) . '</td></tr>';
			
		$na = $table['material']['na'];
		$in = $table['material']['in'];
		$returnTable .= '<td rowspan="3">材料</td><td>材料通用标准</td><td>' . 
			($na + $table['material']['general_standard']['na']) . '</td><td>' . 
			($in + $table['material']['general_standard']['in']) . '</td><td>' .
			($na + $table['material']['general_standard']['na'] + $in + $table['material']['general_standard']['in']) . '</td></tr>';
		
		$returnTable .= '<td>衬底材料</td><td>' . 
			($na + $table['material']['substrate']['na']) . '</td><td>' . 
			($in + $table['material']['substrate']['in']) . '</td><td>' .
			($na + $table['material']['substrate']['na'] + $in + $table['material']['substrate']['in']) . '</td></tr>';
		$returnTable .= '<td>发光材料</td><td>' . 
			($na + $table['material']['light']['na']) . '</td><td>' . 
			($in + $table['material']['light']['in']) . '</td><td>' .
			($na + $table['material']['light']['na'] + $in + $table['material']['light']['in']) . '</td></tr>';

		$na = $table['chip_and_device']['na'];
		$in = $table['chip_and_device']['in'];
		$returnTable .= '<td rowspan="3">芯片和器件</td><td>外延片</td><td>' . 
			($na + $table['chip_and_device']['wafer']['na']) . '</td><td>' . 
			($in + $table['chip_and_device']['wafer']['in']) . '</td><td>' .
			($na + $table['chip_and_device']['wafer']['na'] + $in + $table['chip_and_device']['wafer']['in']) . '</td></tr>';
		$returnTable .= '<td>芯片</td><td>' . 
			($na + $table['chip_and_device']['chip']['na']) . '</td><td>' . 
			($in + $table['chip_and_device']['chip']['in']) . '</td><td>' .
			($na + $table['chip_and_device']['chip']['na'] + $in + $table['chip_and_device']['chip']['in']) . '</td></tr>';
		$returnTable .= '<td>器件</td><td>' . 
			($na + $table['chip_and_device']['device']['na']) . '</td><td>' . 
			($in + $table['chip_and_device']['device']['in']) . '</td><td>' .
			($na + $table['chip_and_device']['device']['na'] + $in + $table['chip_and_device']['device']['in']) . '</td></tr>';
	
		$na = $table['light_device_and_system']['na'];
		$in = $table['light_device_and_system']['in'];
		$returnTable .= '<td rowspan="6">照明设备和系统</td><td>LED模块</td><td>' . 
			($na + $table['light_device_and_system']['led_module']['na']) . '</td><td>' . 
			($in + $table['light_device_and_system']['led_module']['in']) . '</td><td>' .
			($na + $table['light_device_and_system']['led_module']['na'] + $in + $table['light_device_and_system']['led_module']['in']) . '</td></tr>';
		$returnTable .= '<td>LED光源</td><td>' . 
			($na + $table['light_device_and_system']['led_light_source']['na']) . '</td><td>' . 
			($in + $table['light_device_and_system']['led_light_source']['in']) . '</td><td>' .
			($na + $table['light_device_and_system']['led_light_source']['na'] + $in + $table['light_device_and_system']['led_light_source']['in']) . '</td></tr>';
		
		$this_na = $na + $table['light_device_and_system']['lamp_annex']['na'] + 
			$table['light_device_and_system']['lamp_annex']['dedicated_integrated_circuit']['na'] +
			$table['light_device_and_system']['lamp_annex']['drive_control_system']['na'] + 
			$table['light_device_and_system']['lamp_annex']['light_interface']['na'];
		$this_in = $in + $table['light_device_and_system']['lamp_annex']['na'] + 
			$table['light_device_and_system']['lamp_annex']['dedicated_integrated_circuit']['in'] +
			$table['light_device_and_system']['lamp_annex']['drive_control_system']['in'] + 
			$table['light_device_and_system']['lamp_annex']['light_interface']['in'];
		$returnTable .= '<td>灯用附件</td><td>' . $this_na . '</td><td>' . $this_in . '</td><td>' . ($this_na + $this_in) . '</td></tr>';
		$returnTable .= '<td>灯头灯座</td><td>' . 
			($na + $table['light_device_and_system']['lamp_holder_and_socket']['na']) . '</td><td>' . 
			($in + $table['light_device_and_system']['lamp_holder_and_socket']['in']) . '</td><td>' .
			($na + $table['light_device_and_system']['lamp_holder_and_socket']['na'] + $in + $table['light_device_and_system']['lamp_holder_and_socket']['in']) . '</td></tr>';
		$returnTable .= '<td>灯具</td><td>' . 
			($na + $table['light_device_and_system']['lamps']['na']) . '</td><td>' . 
			($in + $table['light_device_and_system']['lamps']['in']) . '</td><td>' .
			($na + $table['light_device_and_system']['lamps']['na'] + $in + $table['light_device_and_system']['lamps']['in']) . '</td></tr>';
		$this_na = $na + $table['light_device_and_system']['light_system']['na'] + 
			$table['light_device_and_system']['light_system']['intelligent_control_system']['na'] +
			$table['light_device_and_system']['light_system']['sensor_system']['na'] + 
			$table['light_device_and_system']['light_system']['other_connection_system']['na'];
		$this_in = $in + $table['light_device_and_system']['light_system']['in'] + 
			$table['light_device_and_system']['light_system']['intelligent_control_system']['in'] +
			$table['light_device_and_system']['light_system']['sensor_system']['in'] + 
			$table['light_device_and_system']['light_system']['other_connection_system']['in'];
		$returnTable .= '<td>照明系统</td><td>' . $this_na . '</td><td>' . $this_in . '</td><td>' . ($this_na + $this_in) . '</td></tr>';
	
		$returnTable .= '<td colspan="2">其他</td><td>' . 
			$table['others']['na'] . '</td><td>' . 
			$table['others']['in'] . '</td><td>' .
			($table['others']['na'] + $table['others']['in']) . '</td></tr>';
			
		$total_na = $table['general_standard']['na'] + $table['material']['na'] 
			+ $table['material']['general_standard']['na'] + $table['material']['substrate']['na']
			+ $table['material']['light']['na'] + $table['chip_and_device']['na']
			+ $table['chip_and_device']['wafer']['na'] + $table['chip_and_device']['chip']['na']
			+ $table['chip_and_device']['device']['na'] + $table['light_device_and_system']['na']
			+ $table['light_device_and_system']['led_module']['na'] + $table['light_device_and_system']['led_light_source']['na']
			+ $table['light_device_and_system']['lamp_annex']['na'] + $table['light_device_and_system']['lamp_holder_and_socket']['na']
			+ $table['light_device_and_system']['lamps']['na'] + $table['light_device_and_system']['light_system']['na']
			+ $table['others']['na'];
		$total_in = $table['general_standard']['in'] + $table['material']['in'] 
			+ $table['material']['general_standard']['in'] + $table['material']['substrate']['in']
			+ $table['material']['light']['in'] + $table['chip_and_device']['in']
			+ $table['chip_and_device']['wafer']['in'] + $table['chip_and_device']['chip']['in']
			+ $table['chip_and_device']['device']['in'] + $table['light_device_and_system']['in']
			+ $table['light_device_and_system']['led_module']['in'] + $table['light_device_and_system']['led_light_source']['in']
			+ $table['light_device_and_system']['lamp_annex']['in'] + $table['light_device_and_system']['lamp_holder_and_socket']['in']
			+ $table['light_device_and_system']['lamps']['in'] + $table['light_device_and_system']['light_system']['in']
			+ $table['others']['in'];;
		
		$returnTable .= '<td colspan="3">总计</td><td>' . 
			$total_na . '</td><td>' . 
			$total_in . '</td><td>' .
			($total_na + $total_in) . '</td></tr>';
			
		return $returnTable;
	}
	
	public static function translate($en) {
		if ($en == 'general') {
			return '通用标准';
		} else if ($en == 'material') {
			return '材料';
		} else if ($en == 'standard') {
			return '材料通用标准';
		} else if ($en == 'substrate') {
			return '衬底材料';
		} else if ($en == 'light_m') {
			return '发光材料';
		} else if ($en == 'candd') {
			return '芯片和器件';
		} else if ($en == 'wafer') {
			return '外延片';
		} else if ($en == 'chip') {
			return '芯片';
		} else if ($en == 'device') {
			return '器件';
		} else if ($en == 'light') {
			return '照明设备和系统';
		} else if ($en == 'led_module') {
			return 'LED模块';
		} else if ($en == 'led_light_source') {
			return 'LED光源';
		} else if ($en == 'lamp_annex') {
			return '灯用附件';
		} else if ($en == 'lamp_holder_and_socket') {
			return '灯头灯座';
		} else if ($en == 'lamps') {
			return '灯具';
		} else if ($en == 'light_system') {
			return '照明系统';
		} else {
			return 'uncertain';
		}
	}
}

?>