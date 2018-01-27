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
		$sql = sprintf('SELECT password FROM `user` WHERE username="%s" LIMIT 1', $username);
		$result = mysqli_query($conn, $sql);
		if (mysqli_field_count($conn) == 0) {
			return 'no such user';
		}
		
		$userInfo = Array(
			'username' => $username,
			'password' => $row['password'],
		);
		
		return $userInfo;
		
	}
}
?>