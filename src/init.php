<?php

// 记录系统初始化时间
if ( ! defined('SDK_START_TIME'))
{
    define('SDK_START_TIME', microtime(true));
}

// 记录系统启动时的内存占用
if ( ! defined('SDK_START_MEMORY'))
{
    define('SDK_START_MEMORY', memory_get_usage());
}

// 框架目录
if ( ! defined('SDK_PATH'))
{
    define('SDK_PATH', __DIR__ . DIRECTORY_SEPARATOR);
}

if ( ! function_exists('__'))
{
    /**
     * 自动翻译函数，使用 [strtr](http://php.net/strtr) 来替换参数
     *
     *    __('Welcome back, :user', [':user' => $username]);
     *
     * @param   string $string 要翻译的文本
     * @param   array  $values 变量数组
     * @param   string $lang   源语言
     * @return  string
     */
    function __($string, array $values = null, $lang = 'en-us')
    {
        if (class_exists('sdk\Base\I18n'))
        {
            if ($lang !== sdk\Base\I18n::$lang)
            {
                $string = sdk\Base\I18n::get($string);
            }
        }

        return empty($values) ? $string : strtr($string, $values);
    }
}
