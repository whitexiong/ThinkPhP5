<?php
namespace app\admin\validate;
use think\Validate;
class City extends Validate
{
	protected $rule = [
		['name','require|max:7|chs','操作失败啦亲！|超过7个字符拉亲|城市中文名必须为汉字啦'],

		['uname','alpha','城市英文名必须是英文啦'],

		['parent_id','number','分类ID必须为数字啦'],

		['id','number','ID必须为数字啦'],

		['status','number|in:-1,0,1', '状态必须是数字|状态范围不合法'],

		['Listorder', 'number','排序ID必须为数字啦'],

	];

	/**
	 * 场景设置
	 */
	
	protected $scene = [
		'add' => ['name','parent_id','id','uname'],//添加
		'Listorder' => ['id','Listorder'], //排序
		'status' => ['id','status'], //更新状态
		
	];
}