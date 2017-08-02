<?php
namespace app\admin\controller;
use think\Controller;
class Category extends Controller
{
    private $obj;
    public function index()
    {
       $parentId =  input('get.parent_id',0,'intval');
       $categorys =  $this->obj->getFirstCategory($parentId);
       return $this->fetch('', [
              'categorys' => $categorys,
        ] );
    }

    public function _initialize()
    {
        $this->obj = model("Category");
    }

   public function add()
    {
        $categorys = $this->obj->getNormalFirstCategory();

       return $this->fetch('',[
            'categorys' => $categorys,
        ]);
    }


    public function save()
    {
       //print_r($_POST);
       //print_r(input('post.'));
      //print_r(request()->post());
      /**
       * 严格判断
       * @var [type]
       */
      if(!request()->isPost()){
          $this->error('请求失败');
      }
      $data = input('post.');
      //$data['status'] = 10;
      
      $validate = validate('Category');
      if(!$validate->scene('add')->check($data)){
      	$this->error($validate->getError());
      }

      //更新操作
      if(!empty($data['id'])){
          return $this->update($data);
      }

     $res = $this->obj->add($data);
     if($res){
        $this->success('添加成功亲');
     }else{
        $this->error('添加失败亲！');
     }
  }


  /**
   * 编辑界面
   * @return [type] [description]
   */
  public function edit($id = 0)
  {
      if(intval($id) < 1){
          $this->error('参数不合法');
      }

     $category = $this->obj->get($id);

     //print_r($category);exit();
      $categorys = $this->obj->getNormalFirstCategory();

      return $this->fetch('',[
            'categorys' => $categorys,
            'category'  => $category,
        ]);
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

    public function listorder($id, $Listorder)
    {

     
      $res = $this->obj->save(['Listorder'=>$Listorder],['id'=>$id]);
      if($res){
          $this->result($_SERVER['HTTP_REFERER'],1,'success');

      }else{
        $this->result($_SERVER['HTTP_REFERER'],0, '更新失败');
      }

   
   }

   public function status()
   {
      $data = input('get.');
      $validate = validate('Category');
      if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
      }

      $res = $this->obj->save(['status'=>$data['status']],
        ['id'=>$data['id']]);
      if($res){
          $this->success("状态更新成功");
      }else{
          $this->error("状态更新失败");
      }
   }

}
