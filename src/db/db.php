<?php
class DB {
	/**
	* 连接数据库
	*/
	private static function connect() {
		$host 		= 'localhost';
		$db_name 	= 'led_search';
		$username	= 'root';
		$password	= '';
		$port		= 3306;
		
		if ($conn = new mysqli($host, $username, $password, $db_name, $port)) {
			return $conn;
		} else {
			die('database connect failed!');
		}
	}
	/**
	* 用户登录
	* 
	*/
	public static function login($username) {
		$conn = self::connect();
		
		$sql = sprintf('SELECT roleId, pwd, userstatus FROM `leduser` WHERE username="%s" LIMIT 1', $username);
		
		$result = mysqli_query($conn, $sql);
		
		$rows = mysqli_fetch_assoc($result);
		
		if (mysqli_num_rows($result) == 0) {
			return 'no such user';
		}
		
		if ($rows['userstatus'] == 'disable') {
			return 'user disabled';
		}
		
		$userInfo = Array(
			'username' 	=> $username,
			'password' 	=> $rows['pwd'],
			'roleId'	=> $rows['roleId'],
		);
		
		return $userInfo;	
	}
	
	/**
	* 获取/更新用户信息
	* 获取：
	* username 用户名
	* 更新:
	* oldpass 旧密码
	* newpass 新密码
	* 
	*/
	public static function userInfo($userInfo, $operation) {
		$conn = self::connect();
		
		if ($operation == 'get') {
			$sql = sprintf('SELECT `nickname`,`userStatus`,`email` FROM `leduser` WHERE username="%s" LIMIT 1', 
				$userInfo['username']);
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) == 0) {
				return 'no such user';
			}
			
			$row = mysqli_fetch_assoc($result);
			
			$userInfo = Array(
				'username' 	=> $userInfo['username'],
				'nickname' 	=> $row['nickname'],
				'email'		=> $row['email'],
			);
			
			return $userInfo;
		} else if ($operation == 'set') {
			// $sql = sprintf();
			$sql = sprintf('UPDATE `leduser` SET 
				`nickname`="%s", `pwd`="%s", `email`="%s" WHERE `username`="%s"', 
				 $userInfo['nickname'], password_hash($userInfo['newpass'], PASSWORD_DEFAULT), $userInfo['email'],
				$userInfo['username']);
				
			if (mysqli_query($conn, $sql)) {
				return 'update success';
			} else {
				die(mysqli_error($conn));
			}
		}
	}
	
	/**
	* 获取标准
	*/
	public static function viewStd($search) {
		$conn = self::connect();
		mysqli_set_charset($conn, 'utf8');
		
		$sql = sprintf('SELECT * FROM `ledstdentity` WHERE `entityid` = %d LIMIT 1', $search['entityid']);
		
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) == 0) {
			return 'no record';
		}
		
		$row = mysqli_fetch_assoc($result);
		
		return $row;
	}
	
	/**
	* 查找
	*/
	public static function search($searchArray, $pageArray) {
		$conn = self::connect();
		mysqli_set_charset($conn, 'utf8');
		$search_type = $searchArray['search_type'];
		$keyword = $searchArray['keyword'];
		// 标准类型
		if ($search_type == 'standard_type') {
			$sql = sprintf('SELECT * FROM `ledstdentity` WHERE `standardtype` LIKE "%s" LIMIT %d OFFSET %d', 
				$keyword, $pageArray['perPage'], $pageArray['perPage'] * $pageArray['from']);
		// 产品类型
		} else if ($search_type == 'product_type') {
			$sql = sprintf('SELECT * FROM `ledstdentity` WHERE `producttype` LIKE "%s" LIMIT %d OFFSET %d', 
				$keyword, $pageArray['perPage'], $pageArray['perPage'] * $pageArray['from']);
		// 标准层级
		} else if ($search_type == 'stdlevel') {
			$sql = sprintf('SELECT * FROM `ledstdentity` WHERE `stdlevel` LIKE "%s" LIMIT %d OFFSET %d', 
				$keyword, $pageArray['perPage'], $pageArray['perPage'] * $pageArray['from']);
		// 标准状态
		} else if ($search_type == 'std_status') {
			$sql = sprintf('SELECT * FROM `ledstdentity` WHERE `stdstatus` LIKE "%s" LIMIT %d OFFSET %d', 
				$keyword, $pageArray['perPage'], $pageArray['perPage'] * $pageArray['from']);
		// 标准号
		} else if ($search_type == 'std_num') {
			$sql = sprintf('SELECT * FROM `ledstdentity` WHERE `stdnum` LIKE "%s" LIMIT %d OFFSET %d', 
				$keyword, $pageArray['perPage'], $pageArray['perPage'] * $pageArray['from']);
		// 标准名称
		} else if ($search_type == 'std_name') {
			$sql = sprintf('SELECT * FROM `ledstdentity` WHERE (`chname` LIKE "%s" OR `enname` LIKE "%s") LIMIT %d OFFSET %d', 
				$keyword, $keyword, $pageArray['perPage'], $pageArray['perPage'] * $pageArray['from']);
		}
		
		$result = mysqli_query($conn, $sql);
		
		$returnArray = Array();
		
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($returnArray, $row);
		}
		
		return $returnArray;
	}
	
	/**
	* 查询/更新用户列表
	* 查询提供参数:
	* page
	* perpage
	* 更新提供参数：（目前支持修改使用情况和修改用户身份至VIP或普通用户）
	* id
	* role或者status
	* value
	*/
	public static function userTable($infoArray, $operation) {
		$conn = self::connect();
		mysqli_set_charset($conn, 'utf8');
		
		if ($operation == 'get') {
			$page = isset($infoArray['page']) && is_numeric($infoArray['page']) ? $infoArray['page'] : 0;
			$perPage = $infoArray['perPage'];
			$from = $page * $perPage;
			
			// +1是为了判断后一页还有记录没有
			$sql = sprintf('SELECT * FROM `leduser` LIMIT %d OFFSET %d', $perPage + 1, $from);
			
			$result = mysqli_query($conn, $sql);
			
			$returnArray = Array();
			
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($returnArray, $row);
			}
			
			return $returnArray;
		} else if ($operation == 'set') {
			// TODO: 并未验证是否修改的是否管理员
			foreach ($infoArray as $value) {
				$id = explode('-', $value['id'])[1];
				$type = explode('-', $value['id'])[0];
				$val = $value['value'];
				
				if ($type == 'status') {
					$sql = sprintf('UPDATE `leduser` SET `userStatus` = "%s" WHERE `uid` = %d', $val, $id);					
				} else if ($type == 'role') {
					$roleId = $val == 'vip' ? 3 : 2;
					$sql = sprintf('UPDATE `leduser` SET `RoleId` = %d WHERE `uid` = %d', $roleId, $id);					
				}
				
				if (!mysqli_query($conn, $sql)) {
					die(mysqli_error($conn));
				}
			}
			return 'success';
		}
	}
}
?>