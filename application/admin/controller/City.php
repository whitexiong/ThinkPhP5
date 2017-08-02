<?php
namespace app\admin\controller;
use think\Controller;

class City extends Controller
{

	private $obj;
	/**
	 * 渲染模板
	 * @return [type] [description]
	 */
	public function index()
    {
       $parentId =  input('get.parent_id',0,'intval');
       $citys =  $this->obj->getFirstCity($parentId);
       return $this->fetch('', [
              'citys' => $citys,
        ] );
    }

	/**
	 * 初始化函数
	 * @return [type] [description]
	 */
	public function _initialize()
    {
        $this->obj = model("City");
    }

	/**
	 * 渲染添加操作模板
	 */
	public function  add()
	{

		//得到查询的结果集
		$citys = $this->obj->getNormalFirstCity();
		return $this->fetch('',[
				'citys' => $citys,
			]);
	}

	/**
	 * 渲染编辑操作模板
	 * @return [type] [description]
	 */
	public function edit($id = 0)
  {
  	 
  	 //如果参数不合法
  	 if(intval($id) < 1){
  	 	$this->error('参数不合法!');
  	 }

  	 //得到get参数;
  	 $city = $this->obj->get($id);

     //print_r($category);exit();
      $citys = $this->obj->getNormalFirstCity();


      return $this->fetch('',[
            'citys' => $citys,
            'city'  => $city,
        ]);
  }

	/**
	 * 执行添加保存到数据中的操作
	 * @return [type] [description]
	 */
	public function  save()
	{
		//判断传过来请求
		if(!request()->isPost()){
			//如果不是post请求则错误
			$this->error('请求失败');
		}
		//如果是POST请求则接受到数据中
		$data = input('post.');
		//接受到数据后需要进行正则验证
		$validate = validate('City');
		if(!$validate->scene('add')->check($data)){
			//如果失败则调用是正则验证中的错误提示
			$this->error($validate->getError());
		}

		//如果是更新操作
		if(!empty($data['id'])){
          return $this->update($data);
      }

			$res = $this->obj->add($data);
			if($res){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
	}

	/**
	 * 更新状态
	 * @return [type] [description]
	 */
	public function status(){
		$data = input('get.');
		// print_r($data);
		// exit();
		//我们要更新sutatus这个字段
		//验证状态和id字段是否合法
		$validate = validate('City');
		if(!$validate->scene('status')->check($data)){
			$this->error($validate->getError());
		}

		//这里验证通过后需要做更新操作
		$res = $this->obj->save(
				['status'=>$data['status']],['id'=>$data['id']]
			);
		if($res){
			$this->success('更新状态成功!');
		}else{
			$this->error('更新状态失败!');
		}


	}


	public function update($data)
  {
    $res = $this->obj->save($data,['id' => intval($data['id'])]);

    if($res){
        $this->success('更新成功！');
    }else{
        $this->error('更新失败!');
    }
  
}

	
	/**
	 * 验证方法
	 * @param  [type] $data  [验证的数据]
	 * @param  [type] $scene [验证的场景]
	 * @param  [type] $class [验证的类]
	 * @return [type]        [description]
	 */
	public function verify($data,$scene,$class)
	{
		$validate = validate($class);
		if($this->obj->scene($scene)->check($data)){
			return $this->success('验证成功');
		}else{
			return $this->error($validate->getError);
		}
	}


	 public function listorder($id, $Listorder)
    {

     
      $res = $this->obj->save(['Listorder'=>$Listorder],['id'=>$id]);
      if($res){
          $this->result($_SERVER['HTTP_REFERER'],1,'success');

      }else{
        $this->result($_SERVER['HTTP_REFERER'],0, '更新失败');
      }

   
   }

}