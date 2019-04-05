<?php


namespace App\Common;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Alnum as AlphaNumValidator;
use Phalcon\Validation\Validator\Alpha as AlphaValidator;
use Phalcon\Validation\Validator\Date as DateValidator;
use Phalcon\Validation\Validator\Digit as DigitValidator;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\ExclusionIn;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Regex as RegexValidator;
use Phalcon\Validation\Validator\StringLength as StringLength;
use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Url as UrlValidator;
use Phalcon\Validation\Validator\CreditCard as CreditCardValidator;

/**
 * 自定义验证类
 * Class CustomValidation
 * @package App\Common
 */
class CustomValidation
{

    /**
     * 检验参数
     * @param array $params 需校验的参数
     * @param array $rules 校验规则
     * @param array $msg 自定义消息
     * @return mixed
     * @throws CustomException
     */
    public static function validate($params, $rules, $msg = [])
    {
        $validator = new Validation();

        foreach ($rules as $field => $str) {
            if (empty($str)) {
                continue;
            }

            $fieldRules = explode('|', $str);
            foreach ($fieldRules as $fieldRule) {
                $arr = explode(':', $fieldRule);
                $rule = $arr[0];
                $ruleVal = $arr[1] ?? '';
                switch ($rule) {
                    case 'required':
                        $validator->add($field, new PresenceOf([
                            'message' => $msg[$field . '.' . $rule] ?? ':field为必填项',
                            'cancelOnFail' => true,
                        ]));

                        break;
                    case 'alphaNum':
                        $validator->add($field, new AlphaNumValidator([
                            'message' => $msg[$field . '.' . $rule] ?? ':field必须为字母和数字',
                            'cancelOnFail' => true,
                        ]));

                        break;
                    case 'alpha':
                        $validator->add($field, new AlphaValidator([
                            'message' => $msg[$field . '.' . $rule] ?? ':field必须为字母',
                            'cancelOnFail' => true,
                        ]));

                        break;
                    case 'date'://格式：date:Y-m-d H:i:s
                        $validator->add($field, new DateValidator([
                            'format' => $ruleVal ? $ruleVal : 'Y-m-d H:i:s',
                            'message' => $msg[$field . '.' . $rule] ?? ':field必须为字母',
                            'cancelOnFail' => true,
                        ]));

                        break;

                    case 'digit':
                        $validator->add($field, new DigitValidator([
                            'message' => $msg[$field . '.' . $rule] ?? ':field必须为整数',
                            'cancelOnFail' => true,
                        ]));

                        break;
                    case 'num':
                        $validator->add($field, new Numericality([
                            'message' => $msg[$field . '.' . $rule] ?? ':field必须为数字',
                            'cancelOnFail' => true,
                        ]));

                        break;

                    case 'email':
                        $validator->add($field, new EmailValidator([
                            'message' => $msg[$field . '.' . $rule] ?? ':field必须为邮箱',
                            'cancelOnFail' => true,
                        ]));

                        break;
                    case 'notIn'://格式：notIn:1,a,test
                        $validator->add($field, new ExclusionIn([
                            'message' => $msg[$field . '.' . $rule] ?? ':field必须不能是:' . $ruleVal,
                            'domain' => explode(',', $ruleVal),
                            'cancelOnFail' => true,
                        ]));

                        break;
                    case 'in'://格式：in:1,a,test
                        $validator->add($field, new InclusionIn([
                            'message' => $msg[$field . '.' . $rule] ?? ':field必须是:' . $ruleVal,
                            'domain' => explode(',', $ruleVal),
                            'cancelOnFail' => true,
                        ]));

                        break;
                    case 'regex'://格式：regex:/^[0-9]$/
                        $validator->add($field, new RegexValidator([
                            'message' => $msg[$field . '.' . $rule] ?? ':field格式错误',
                            'pattern' => $ruleVal,
                            'cancelOnFail' => true,
                        ]));

                        break;
                    case 'strLen'://格式：strLen:min,max
                        $m = explode(',', $ruleVal);
                        $max = $m[1] ?? 50;
                        $min = $m[0] ?? 0;
                        $validator->add($field, new StringLength([
                            'max' => $max,
                            'min' => $min,
                            'messageMaximum' => ':field长度必须在' . $min . ',' . $max . '之间',
                            'messageMinimum' => ':field长度必须在' . $min . ',' . $max . '之间',
                            'cancelOnFail' => true,
                        ]));

                        break;
                    case 'between'://格式：between:min,max
                        $m = explode(',', $ruleVal);
                        $max = $m[1] ?? 50;
                        $min = $m[0] ?? 0;
                        $validator->add($field, new Between([
                            'minimum' => $min,
                            'maximum' => $max,
                            'message' => ':field必须在' . $min . ',' . $max . '之间',
                            'cancelOnFail' => true,
                        ]));

                        break;
                    case 'confirmed'://格式：confirmed:field
                        $validator->add($field, new Confirmation([
                            'with' => $ruleVal,
                            'message' => ':field与' . $ruleVal . '不一致',
                            'cancelOnFail' => true,
                        ]));

                        break;
                    case 'url':
                        $validator->add($field, new UrlValidator([
                            'message' => ':field必须是URL',
                        ]));

                        break;
                    case 'creditCard':
                        $validator->add($field, new CreditCardValidator([
                            'message' => ':field必须是信用卡卡号',
                        ]));

                        break;
                }
            }
        }

        /**
         * 去除前后空格
         */
        foreach ($params as $key => $val) {
            $params[$key] = $validator->filter->sanitize($val, 'trim');
        }

        /**
         * 参数校验
         */
        $msg = $validator->validate($params);
        if (count($msg)) {
            foreach ($msg as $m) {
                error_exit(Code::INVALID_PARAMETER, $m);
            }
        }

        return $params;
    }
}