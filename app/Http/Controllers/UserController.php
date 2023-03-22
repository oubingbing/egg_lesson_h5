<?php


namespace App\Http\Controllers;

use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use App\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getEmailCode(Request $request)
    {
        $email = $request->input("email");
        $result = $this->userService->getEmailCode($email);
        if($result  == 0){
            throw new ApiException("发送失败",ErrorEnum::USER_EMAIL_CODE_SEND_ERR);
        }

        return "发送成功";
    }

    public function login(Request $request)
    {
        $email = $request->input("email");
        $code  = $request->input("code");

        $this->userService->emailLogin($email,$code);

        return "登录成功";
    }

    public function user(Request $request)
    {
        return session("email");
    }
}
