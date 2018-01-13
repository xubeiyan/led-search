<?php
class Render {
	/**
	 * 渲染页面
	 * @param $page_name 要渲染的内容
	 * @param $entries 要渲染的内容的数组
	 */
	public static function render_page($content, $entries) {
		foreach ($entries as $key => $value) {
			$content = str_replace('%' . $key . '%', $value, $content);
		}
		return $content;
	}
}
?>