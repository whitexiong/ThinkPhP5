<?php
namespace app\admin\controller;
use think\Controller;
//use phpmailer\Email;
class Index extends Controller
{
    public function index()
    {


       return $this->fetch();
    }

     public function map()
     {
     	return \Map::staticimage("重庆南岸茶园新区长生街鲁能领秀城5街区");
     	
     }

     public function test()
     {  

     	return \Map::staticimage('重庆');
     }

     public function welcome()
     {
     	//\phpmailer\Email::send('986247535@qq.com','ddd','ddd','dd');
        return 'success';
     }

    


}
