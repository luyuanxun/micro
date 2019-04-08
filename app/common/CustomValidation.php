<?php

namespace App\Common;

use Phalcon\Crypt\Mismatch;
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
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;

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
     * @param array $decryptFields 解密字段
     * @return mixed
     * @throws CustomException
     */
    public static function validate(array $params, array $rules, $msg = [], $decryptFields = ['id'])
    {
        $validator = new Validation();
        foreach ($rules as $field => $str) {
            if (empty($str)) {
                continue;
            }

            $fieldRules = explode('|', $str);
            if (in_array('required', $fieldRules)) {
                $validator->add($field, new PresenceOf([
                    'message' => $msg[$field . '.required'] ?? ':field为必填项',
                    'cancelOnFail' => true,
                ]));
            } else {
                /**
                 * 传来空串且非必填直接跳过
                 */
                if (!isset($params[$field]) || $params[$field] === '') {
                    continue;
                }
            }

            foreach ($fieldRules as $fieldRule) {
                $arr = explode(':', $fieldRule);
                $rule = $arr[0];
                $ruleVal = $arr[1] ?? '';
                switch ($rule) {
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
                        $stringLengthParams = [
                            'min' => $m[0],
                            'messageMinimum' => ':field长度必须大于等于' . $m[0],
                            'cancelOnFail' => true,
                        ];

                        if (isset($m[1])) {
                            $stringLengthParams['max'] = $m[1];
                            $stringLengthParams['messageMaximum'] = ':field长度必须在' . $m[0] . ',' . $m[1] . '之间';
                        }

                        $validator->add($field, new StringLength($stringLengthParams));

                        break;
                    case 'between'://格式：between:min,max
                        $m = explode(',', $ruleVal);
                        $betweenParams = [
                            'minimum' => $m[0],
                            'maximum' => $m[1] ?? 1000,
                            'message' => ':field必须大于或等于' . $m[0],
                            'cancelOnFail' => true,
                        ];

                        if (isset($m[1])) {
                            $betweenParams['message'] = ':field必须在' . $m[0] . ',' . $m[1] . '之间';
                        }

                        $validator->add($field, new Between($betweenParams));

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
                    case 'unique'://格式：unique:model,attribute
                        $u = explode(',', $ruleVal);
                        if (empty($u)) break;
                        $modelName = "App\\Models\\" . ucfirst($u[0]);
                        $validator->add($field, new UniquenessValidator([
                            'model' => new $modelName(),
                            'attribute' => $u[1] ?? $field,
                            'message' => $params[$field] . '已存在！',
                            'cancelOnFail' => true,
                        ]));

                        break;
                }
            }
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

        /**
         * 处理需要解密的字段
         */
        foreach ($decryptFields as $field) {
            if (isset($params[$field]) && strlen($params[$field]) >= 24) {
                try {
                    $params[$field] = $validator->crypt->decryptBase64($params[$field]);
                } catch (Mismatch $e) {
                    error_exit(Code::SERVER_ERROR, $e->getMessage());
                }
            }
        }

        return $params;
    }
}