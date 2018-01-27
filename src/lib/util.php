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
}

?>