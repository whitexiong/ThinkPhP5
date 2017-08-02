<?php
namespace app\api\controller;
use think\Controller;
use think\Request;
use think\File;
class Image extends Controller
{

	/**
	 * 图片上传
	 * @return [type] [description]
	 */
	public function upload()
	{
		$file =  Request::instance()->file('file');
		//给一个目录
		$info = $file->move('upload');
		// print_r($info);
		if($info && $info->getPathname()){
			//如果有数据并且文件存在
			return show(1,'success','/'.$info->getPathname());
		}

		return show(0,'upload error');
	}

}