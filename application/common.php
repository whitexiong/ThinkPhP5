<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function status($status)
{
	//$str = '';
	if($status == 1){
		$str = "<span class='label-success radius'>正常</span>";
	}elseif ($status == 0) {
		$str = "<span class='label-danger radius'>待审</span>";
	}else{
		$str = "<span class='label-default radius'>删除</span>";
	}
	return $str;
}

/**
 * [doCurl description]
 * @param  [type]  $url  [description]
 * @param  integer $type [0 get 1 post]
 * @param  array   $data [description]
 * @return [type]        [description]
 */
function doCurl($url, $type=0, $data=[])
{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_HEADER,0);
		
		
		if($type == 1){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		//如果是get方式

		//执行并获取
		$output = curl_exec($ch);
		//释放句柄
		curl_close($ch); 

		return $output;
}



