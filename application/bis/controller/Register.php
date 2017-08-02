<?php
namespace app\bis\controller;
use think\Controller;
class Register extends Controller
{


	public function index(){

		$citys = model('City')->getNormalFirstCity();
		$categorys = model('Category')->getNormalFirstCategory();
		return $this->fetch('',[
				'citys' => $citys,
				'categorys' => $categorys,
			]);
	}

	public function add()
	{
		if(!request()->isPost()){
			$this->error('错误');
		}

		//获取表单的值
		$data = input('post.');
		//校验数据
		//
		//
		//dump($data);exit;
		// $validate = validate('Bis');
		// if(!$validate->scene('add')->check($data)){
		// 	$this->error($validate->getError());
		// }

		//获取经纬度
		$Inglat = \Map::getLngLat($data['address']);
		//print_r($Inglat);exit;

		if(empty($Inglat || $Inglat['status'] != 0 || $Inglat['result']['precise'] !=1)){
			$this->error('无法获取数据, 或区域匹配的地址不精确');
		}

		/**
		 * 商户的基本信息
		 * @var [type]
		 */
		$bisData = [
            'name' => $data['name'],
            'city_id' => $data['city_id'],
            'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
            'Logo' => $data['logo'],
            'Licence_logo' => $data['licence_logo'],
            'description' => empty($data['description']) ? '' : $data['description'],
            'bank_info' =>  $data['bank_info'],
            'bank_user' =>  $data['bank_user'],
            'bank_name' =>  $data['bank_name'],
            'faren' =>  $data['faren'],
            'faren_tel' =>  $data['faren_tel'],
            'email' =>  $data['email'],
        ];

		//数据入库
		$bisId = model('Bis')->add($bisData);


		if(!empty($data['se_category_id'])){
			$data['cat'] = implode('|', $data['se_category_id']);
		}

		//总店
		$locationData = [
			'bis_id' => $bisId,
			'name' => $data['name'],
			'Logo' => $data['logo'],
			'tel' => $data['tel'],
			'contact' => $data['contact'],
			'category_id' => $data['category_id'],
			'category_path' => $data['category_id'].','.$data['cat'] ? '' : $data['category_id'].','.$data['cat'],
			'city_id' => $data['city_id'],
			'city_path' => empty($data['se_category_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
			'address' => $data['address'],
			'open_time' => $data['open_time'],
			'content' => empty($data['content']) ? '' : $data['content'],
			'is_main' => 1,
			'xpoint' => empty($Inglat['result']['location']['lng']) ? '' : $Inglat['result']['location']['lng'],
			'ypoint' => empty($Inglat['result']['location']['lat']) ? '' : $Inglat['result']['location']['lat'],	
		];

		//填充主键的ID
		$locationId = model('BisLocation')->add($locationData);
		//echo $locationId;exit;
		
		//账户相关的信息校验
		//数据加严
		$data['code'] = mt_rand(100, 10000); //随机密码
		$accounData = [
				'bis_id' => $bisId,
				'username' => $data['username'],
				'code' => $data['code'],
				'password' => md5($data['password'].$data['code']),
				'is_main' => 1, //代表总管理员
		];
		//填充数据
		$accountId = model('BisAccount')->add($accounData);
		if(!$accountId){
			$this->error('申请失败');
		}

		//发送邮件
		$url = request()->domain().url('bis/resgister/waiting',['id'=>$bisId]);
		$title = "***petFamily o2o入驻请求知道***";
		$contact = "您提交的的入驻请求需等待，请点击下方链接<br/> 
		<a href='".$url." target = '_blank'>查看链接</a> 查看审核状态";
		\phpmailer\Email::send($data['email'],$title, $content, $bisData['bank_user']);
		//echo $accounData; exit;
		// echo($bisId);exit;
		// //判断用户是否存在
		// $accountResult = Model('BisAccount')->get(['username'=>$data['username']]);
		// if($accountResult){

		// }
		
	}	

	public function waiting()
	{
		return 'test';
	}

}