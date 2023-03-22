<?php

namespace App\Service;

use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use App\Models\User;
use Carbon\Carbon;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/14 0014
 * Time: 11:45
 */
class UserService extends BaseServiceAbstract
{
    public function getEmailCode($email)
    {
        $user = User::query()->where(User::FIELD_EMAIL,$email)->first();
        if(!$user){
            $user = User::create([
                User::FIELD_EMAIL=>$email,
                User::FIELD_EMAIL_CODE=>randomKeys(6),
                User::FIELD_CODE_EXPIRE_AT=>Carbon::now()->addHour(1)
            ]);
        }else{
            $user->{User::FIELD_EMAIL_CODE} = randomKeys(6);
            $user->{User::FIELD_CODE_EXPIRE_AT} = Carbon::now()->addHour(1);
            $result = $user->save();
            if(!$result){
                throw new ApiException("用户信息更新失败",ErrorEnum::USER_UPDATE_ERR);
            }
        }

        $content = "您的验证码为：".$user->{User::FIELD_EMAIL_CODE};
        $sendResult = app(EmailService::class)->sendRegisterEmail($email,$content);
        if($sendResult["statusCode"] == 200){
            return 1;
        }else{
            return 0;
        }
    }

    public function emailLogin($email,$code)
    {
        $user = User::query()->where(User::FIELD_EMAIL,$email)->first();
        if(!$user){
            throw new ApiException("用户不存在",ErrorEnum::USER_EMAIL_NOT_FOUND);
        }

        if($user->{User::FIELD_EMAIL_CODE} != $code){
            throw new ApiException("验证码错误",ErrorEnum::USER_EMAIL_CODE_ERR);
        }

        if(Carbon::now()->gt($user->{User::FIELD_CODE_EXPIRE_AT})){
            throw new ApiException("验证码已过期",ErrorEnum::USER_EMAIL_CODE_EXPIRE);
        }

        session(['email' =>$email,"id"=>$user->id]);
    }
}
