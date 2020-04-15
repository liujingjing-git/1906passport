<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * 注册页面
     */
    public function reg()
    {
        return view('reg/reg');
    }
    
    /**
     * 执行注册
     */
    public function regdo()
    {
        $data = request()->except('_token');
        //密码加密
        $data['password'] =password_hash($data['password'],PASSWORD_DEFAULT);
        $res = UserModel::create($data);
        if($res)
        {
            header("refresh:3,url=login");
            echo "注册成功,正在跳转至登录页面...";    
        }else{
            header("refresh:3,url=reg");
            echo "注册失败";    
        }
    }

    /**
     * 登录页面
     */
    public function login()
    {
        return view('reg/login');
    }
    /**
     * 执行登录
     */
    public function logindo()
    {
        $username = request()->input('username');
        $password = request()->input('password');
        
        $res = UserModel::where(['mobile'=>$username])->orwhere(['email'=>$username])->orwhere(['username'=>$username])->first();
        if($res==null)
        {
            header("refresh:3,url=reg");
            echo "该用户不存在 注册后再试...";die; 
        }

        //判断密码
        $password = request()->input('password');
        if (!Hash::check($password,$res['password'])) {
            header("refresh:3,url=login");
            echo "请确认您的密码后再次登录...";die;
        }
        $uid = request()->input('id');
        //生成token   写入cookie
        $token = Str::random(16);
        //设置cookie    生成的token,当前时间+3600秒后过期   整站有效
        setcookie('token',$token,time()+3600,'/','.1906.com',null,true);
        //将token存入redis
        $user_token_key = 'str:user:token:web'.$uid;
        Redis::set($user_token_key,$token);

        if($res)
        {
            header("refresh:3,url=github/center");
            echo "登录成功 正在跳转至个人中心...";
        }else{
            header("refresh:3,url=login");
            echo "登录失败";
        }

    }

    /**
     * 处理API注册
     */
    public function apiReg()
    {
        $username = request()->input('username');
        $email = request()->input('email');
        $mobile = request()->input('mobile');
        $password = request()->input('password');
        $password =password_hash($password,PASSWORD_DEFAULT);
        // echo $password;

        $user_data = [
            'username' => $username,
            'email'    => $email,
            'mobile'   => $mobile,
            'password' => $password
        ];
        
        $res = UserModel::create($user_data);
        $data1 = [
            'error' => 0,
            'data1' => [
                'username' => $username,
                'email'    => $email,
                'mobile'   => $mobile,
                'password' => $password
            ]
        ];
        return $data1;

    }

    /**
     * 处理API登录
     */
    public function apiLogin()
    {
        $username = request()->input('username');
        $password = request()->input('password');

        //验证
        $res = UserModel::where(['username'=>$username])->first();
        if($res==null)
        {
            header("refresh:3,url=reg");
            echo "该用户不存在 注册后再试..";die; 
        }
         //判断密码
         $password = request()->input('password');
         if (!Hash::check($password,$res['password'])) {
             header("refresh:3,url=login");
             echo "请确认您的密码后再次登录...";die;
         }
        
        $uid = request()->input('id');
        //生成token   写入cookie
        $token = Str::random(16);
        //将token存入redis
        $user_token_key = 'str:user:token:app'.$uid;
        Redis::set($user_token_key,$token);
        
        $data = [
            'error' => 0,
            'data' => [
                'token' => $token,
                'uid'   => $uid
            ]
        ];
        return $data;
    }
}
