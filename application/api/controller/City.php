<?php
namespace app\api\controller;
use think\Controller;
class City extends Controller
{
	private $obj;
	public function _initialize()
    {
        $this->obj = model("City");
    }

	public function getNormalFirstCity()
	{
		$id = input('post.id');
		//print_r($id);exit;
		if(!$id){
			$this->error('Id不合法');
		}

		//通过ID获取二级城市
		$citys = $this->obj->getNormalFirstCity($id);
		if(!$citys){
			return show(0,'error');
		}
		return show(1,'success',$citys);

	}
}