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
		
		if ($conn = mysqli_connect($host, $username, $password, $db_name, $port)) {
			return $conn;
		} else {
			die('database connect failed!');
		}
	}
	/**
	* 查询登录信息
	* 
	*/
	public static function login($username) {
		$conn = self::connect();
		$sql = sprintf('SELECT roleId, pwd, userstatus FROM `leduser` WHERE username="%s" LIMIT 1', $username);
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) == 0) {
			return 'no such user';
		}
		
		$row = mysqli_fetch_assoc($result);
		
		if ($row['userstatus'] == 'disable') {
			return 'user disabled';
		}
		
		$userInfo = Array(
			'username' 	=> $username,
			'password' 	=> $row['pwd'],
			'roleId'	=> $row['roleId'],
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
			$sql = sprintf('UPDATE ``');
		}
	}
}
?>