<?php
namespace App\Traits\Controllers;

trait Tags
{
	protected function trim_tags($s) {
		$s = preg_replace('/\s+/', '', $s);
		$s = str_replace('，', ',', $s);
		$s = preg_replace('#,+#', ',', $s);
		$s = trim($s, ' ,');
		return $s;
	}
	
	protected function tagsToArray($keywords = '') {
		$keywords = $this->trim_tags($keywords);
		return explode(',', $keywords);
	}
	
	protected function checktags($tags, $num = 5) {
		$v       = explode(',', $tags);
		$v_num   = count($v);
		$message = '';
		if ($v_num > $num) {
			$message .= '标签(Tags)的关键字不能超过'.$num.'个';
			return $message;
		} else {
			for($i=0; $i<$v_num; $i++) {
				if(strlen($v[$i]) > 15) {
					$message .= '标签(Tags)的每个关键字不能超过15个字符, ' . $v[$i] . ' 超过了15个字符';
					return $message;
				}
			}
		}
	}

}
