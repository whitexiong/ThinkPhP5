<?php
namespace app\api\controller;
use think\Controller;

class Category extends Controller
{
	private $obj;
	/**
	 * 初始化方法
	 * @return [type] [description]
	 */
	public function _initialize()
	{
		$this->obj = model('Category');
	}

	/**
	 * 返回
	 * @return [type] [description]
	 */
	public function getNormalFirstCategory()
	{
		$id = input('post.id');
		if(!$id){
			 $this->error('参数错误');
		}

	  $categorys = $this->obj->getNormalFirstCategory($id);
		if(!$categorys){
			return show(0,'error');
		}
		return show(1,'success',$categorys);

	}
}
