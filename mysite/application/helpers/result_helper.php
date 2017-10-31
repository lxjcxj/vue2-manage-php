<?php

class Helper_Result
{

    /**
     * @desc 返回数据
     * @param  array [code=编码，msg=提示，data=返回数据]
     * @return array
     */
    public static function get($code, $msg = '', $data = array())
    {
        $ret = array(
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        );
        if ($code < RET_SUCC) {
            log_message('sysErrLog:' . json_encode($ret, JSON_UNESCAPED_UNICODE), LOG_DEBUG);
        }
        return $ret;
    }


    /**
     * @desc 验证返回数据编码
     * @param  array [code=编码，msg=提示，data=返回数据]
     * @return bool
     */
    public static function check($res)
    {
        if (!isset($res['code']) || $res['code'] !== RET_SUCC) {
            return false;
        }
        return true;
    }

    /**
     * @desc 验证参数是否存在，或者为空
     * @param  array [arr=验证的参数名数组，params=参数]
     * @return bool
     */
    public static function paramsCheck($arr, $params)
    {
        foreach ($arr as $v) {
            if (!array_key_exists($v, $params) || $params[$v] === '' || $params[$v] === null || $params[$v] === false) {
                self::$_errorParam = $v;
                Helper_Result::get(RET_PARAM_ERROR, '参数错误[' . $v . ']');
                return true;
            }
        }
        return false;
    }

    //错误的参数名
    public static $_errorParam = '';

    /**
     * @desc 参数简单过滤
     * @param  arr =要过滤的数组, $num=不需要传递
     * @return array [过滤后的原数组]
     */
    public static function paramsFilter($arr, $num = 0)
    {
        foreach ($arr as &$v) {
            if (is_array($v)) {
                $n = 0;
                if ($num != 0) {
                    $n = $num;
                }
                $n = $n + 1;
                if ($n == 5) {
                    log_message('参数过滤次数太多' . json_encode($arr, JSON_UNESCAPED_UNICODE), LOG_ERR);
                }
                $v = static::paramsFilter($v, $n);

            } else {
                $v = trim($v);
            }
        }
        return $arr;
    }

    /**
     * @desc 比较版本号 X.XX.XXX
     * @param  string $version
     * @return true不更新 false更新
     */
    public static function versionCompare($params = [])
    {
        $version1 = $params['version1'];    //小版本号
        $version2 = $params['version2'];    //最新版本号
        $str_version1 = explode('.', $version1);
        $str_version2 = explode('.', $version2);
        if ($str_version1[0] < $str_version2[0]) {
            //版本号第一位
            return false;
        } else {
            //X相等 比较XX
            if ($str_version1[1] < $str_version2[1]) {
                return false;
            } else {
                //XX相等
                if ($str_version1[2] < $str_version2[2]) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }

    /**
     * 过滤敏感字段
     * @param $data
     * @param array $arr
     * @return mixed
     */
    public static function filterArr($data, array $arr)
    {
        foreach ($arr as $v) {
            if (isset($data[$v])) unset($data[$v]);
        }
        return $data;
    }

    /**
     * 字符串只能中文、英文、数字
     * @param  str =字符串
     * @return 错误返回0,正确返回1
     */
    public static function strCheck($str)
    {
        return preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]+$/u', $str);
    }

}
