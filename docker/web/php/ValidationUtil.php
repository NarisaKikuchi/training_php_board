<?php

/**
 * validation用　共通メソッド
 */
class ValidationUtil
{
    /**
     * 半角英数チェック
     * 
     * @param string $value 入力値
     * @return bool 
     */
    public static function isHanEisu($value)
    {
        return preg_match("/^[a-zA-Z0-9]+$/", $value);
    }

    /**
     * 文字数制限チェック
     * 
     * @param string $value 入力値
     * @param int $max_length 最大文字数
     * @return bool
     * 
     */
    public static function isMaxLength($value, $max_length)
    {
        return mb_strlen($value) <= $max_length;
    }
}