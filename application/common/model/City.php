<?php
namespace app\common\Model;
use think\Model;
class City extends Model
{
	
	//开启自动写入时间
	protected $autoWriteTimestamp = true;

	//类型转换
	 protected $type = [
        'create_time'    =>  'integer',

    ];

    /**
     * 模型添加
     * @param [type] $data [description]
     */
	public function add($data)
	{
		
		$data['status'] = 1;
		//$data['create_time'] = time();
		return $this->save($data); //保存数据 在控制器中调用
	}


	public function getNormalFirstCity($parentId=0)
	{
		$data = [
			'status' => 1,
			'parent_id' => $parentId, 
		];

		$order = [
			'id' => 'desc',
		];

		//返回查询的结果
		return $this
		->where($data)
		->order($order)
		->select();

	}

	 public function getFirstCity($parentId = 0)
    {
    	$data = [
    		'parent_id' => $parentId,
    		'status'	=> ['neq',-1], //不等于-1
    	];

    	$order = [
            'Listorder' => 'desc',
    		'id' => 'desc',
            
    	];

    	$result = $this
    	->where($data)
    	->order($order)
    	->paginate();
    	//echo $this->getlastSql();
    	return $result;
    }




}