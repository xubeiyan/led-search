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
			
			exit(json_encode($return_array, JSON_UNESCAPED_UNICODE));
		} else {
			$length = count($resultArray);
		
			$return_array = Array(
				'found_result' => $length,
				'results' => $resultArray,
			);
			
			exit(json_encode($return_array, JSON_UNESCAPED_UNICODE));
		} 
	}
}

?>