<?php

namespace App\Service;
use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/3 0003
 * Time: 15:14
 */
class AuthService
{
    public static function validLogin(Request $request)
    {
        $rules = [
            'email'     => 'required|email',
            'password'  => 'required'
        ];
        $message = [
            'email.required'    => '邮箱不能为空',
            'email.email'       => '邮箱格式错误',
            'password.required' => '密码不能为空',
        ];
        $validator = \Validator::make($request->all(),$rules,$message);

        if ($validator->fails()) {
            $errors = $validator->errors();
            throw new ApiException($errors->first(),ErrorEnum::AUTH_LOGIN_VERIFY_FAIL);
        }
    }

}