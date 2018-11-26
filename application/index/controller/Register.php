<?php
namespace app\index\controller;

use think\Controller;

class Register extends Controller{
  	public function index(){
		return $this->fetch();
  	}
 	public function doRegister(){
		$param = input('post.');
      	$user_name = trim($param['user_name']);
   		$user_pwd=trim($param['user_pwd']);
    	$user_pwd2=trim($param['user_pwd2']);

		if(empty($param['user_name'])){
			$this->error('用户名不能为空');
			}
		if(empty($param['user_pwd'])){
			$this->error('密码不能为空');
			}
      	if(strlen($user_name)<4){
			$this->error('用户名长度不得小于4');
			}
      	if($user_pwd != $user_pwd2){
          	$this->error('两次输入密码不一致');
        }
      	if(strlen($user_pwd)<5){
       	 	$this->error('密码长度不得小于5');
      	}
		// 验证用户名
		$has = db('users')->where('user_name', $user_name)->find();
		if($has){
			$this->error('用户名已存在');
		}else{
			// 注册用户信息
			$inserted_item=['user_name' => $user_name, 'user_pwd'=>md5($user_pwd)];//向数据库插入新用户信息，用md5加密
      		$insert = db('users')->insert($inserted_item);
			if($insert == 1){
        	  	$this->success('恭喜您注册成功！请前往登陆页面','index/login/index',3);
       	 	}else{
          		$this->error('注册失败，请重试');
      		}
        }
	}
}