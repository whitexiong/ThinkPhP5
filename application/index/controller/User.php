<?php
namespace app\index\controller;
use think\Controller;
class User extends controller
{
    public function login()
    {
       return $this->fetch();
    }

    public function register()
    {
        return $this->fetch();
    }
}
