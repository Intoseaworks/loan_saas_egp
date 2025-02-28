<?php

namespace Api\Rules\User;

use Common\Rule\Rule;
use Illuminate\Http\Request;

class PwdLoginRule extends Rule {

    const SCENARIO_LOGIN = 'login';
    const PWD_LOGIN = 'login_pwd';
    const SCENARIO_REG = 'reg';
    const PWD_RETRIEVE = 'retrieve_pwd';

    public function rules() {
        $telephone = app(Request::class)->get('telephone');
        return [
            self::PWD_LOGIN => [
                'telephone' => 'required|mobile',
                'password' => 'required|string|min:6',
            ],
            self::SCENARIO_REG => [
                'telephone' => 'required|mobile',
                'password' => 'required|string|min:6',
                'password_check' => 'required|string|min:6',
                'captcha' => "required|string|size:4|captcha:{$telephone}",
            ],self::PWD_RETRIEVE => [
                'old_password' => 'string|min:6',
                'new_password' => 'required|string|min:6',
                'check_password' => 'required|string|min:6',
            ],
        ];
    }

    public function messages() {
        return [
            self::PWD_LOGIN => [
                'telephone.required' => t('请输入手机号', 'captcha'),
                'telephone.mobile' => t('手机号格式不正确', 'captcha'),
                'password.required' => t('密码不正确', 'captcha'),
                'password.string' => t('密码不正确', 'captcha'),
                'password.min' => t('密码不正确', 'captcha'),
            ],
            self::SCENARIO_REG => [
                'telephone.required' => t('请输入手机号', 'captcha'),
                'telephone.mobile' => t('手机号格式不正确', 'captcha'),
                'password.required' => t('密码不正确', 'captcha'),
                'password.string' => t('密码不正确', 'captcha'),
                'password.min' => t('密码不正确', 'captcha'),
                'captcha.required' => t('请输入验证码', 'captcha'),
                'captcha.size' => t('验证码不正确', 'captcha'),
                'captcha.captcha' => t('验证码不正确', 'captcha'),
            ]
        ];
    }

}
