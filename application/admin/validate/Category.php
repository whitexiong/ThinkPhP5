<?php
namespace app\admin\validate;
use think\Validate;
class Category extends Validate
{
	protected $rule = [
		['name','require|max:10','傻逼啊|超过10个字符拉亲'],
		['parent_id','number'],
		['id','number'],
		['status','number|in:-1,0,1', '状态必须是数字|状态范围不合法'],
		['Listorder', 'number'],

	];

	/**
	 * 场景设置
	 */
	
	protected $scene = [
		'add' => ['name','parent_id','id'],//添加
		'Listorder' => ['id','Listorder'], //排序
		'status' => ['id','status'],
		
	];
}