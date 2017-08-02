<?php
namespace app\common\model;

use think\Model;

class Category extends Model
{
	
	
	protected $autoWriteTimestamp = true;
    // 创建时间字段
   // protected $createTime =  true;
     protected $type = [
        'create_time'    =>  'integer',
    ];

	public function add($data)
	{
		
		$data['status'] = 1;
		//$data['create_time'] = time();
		return $this->save($data); 

        //保存数据 在控制器中调用
	}

	
    public  function getNormalFirstCategory($parentId=0)
    {
        $data = [
            'status'=>1,
            'parent_id'=>$parentId,
        ];

        $order = [
    
            'id' => 'desc',
        ];

        return $this
        ->where($data)
        ->order($order)
        ->select();
    }

    public function getFirstCategory($parentId = 0)
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