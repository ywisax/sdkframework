<?php

namespace sdk\Base;

/**
 * 国际化翻译类，使用方法：
 *
 *     // 不带参数
 *     echo __('Hello, world');
 *     // 带参数
 *     echo __('Hello, :user', [':user' => $username]);
 *
 * @package    Sdk
 * @category   Base
 * @author     YwiSax
 */
class I18n
{

    /**
     * @var  string   目标语言：en-us, es-es, zh-cn
     */
    public static $lang = 'en-us';

    /**
     * @var  string  源语言： en-us, es-es, zh-cn
     */
    public static $source = 'en-us';

    /**
     * @var  array  已加载的语言缓存
     */
    protected static $_cache = [];

    protected static $_langNormalizeSearch  = [' ', '_'];
    protected static $_langNormalizeReplace = '-';

    /**
     * 获取当前的目标语言
     *
     *     $lang = I18n::lang();
     *     // 更改语言
     *     I18n::lang('es-es');
     *
     * @param   string $lang new language setting
     * @return  string
     */
    public static function lang($lang = null)
    {
        if ($lang)
        {
            self::$lang = strtolower(str_replace(self::$_langNormalizeSearch, self::$_langNormalizeReplace, $lang));
        }
        return self::$lang;
    }

    /**
     * 获取字符串翻译文本，这个方法是不传参的：
     *
     *     $hello = I18n::get('Hello friends, my name is :name');
     *
     * @param   string $string 要翻译的文本
     * @param   string $lang   目标语言
     * @return  string
     */
    public static function get($string, $lang = null)
    {
        if ( ! $lang)
        {
            $lang = self::$lang;
        }
        // 加载语言表
        $table = self::load($lang);

        return isset($table[$string]) ? $table[$string] : $string;
    }

    /**
     * 加载和返回指定语言表格
     *
     *     $messages = I18n::load('es-es');
     *
     * @param   string $lang 要加载的语言
     * @return  array
     */
    public static function load($lang)
    {
        if (isset(self::$_cache[$lang]))
        {
            return self::$_cache[$lang];
        }

        $table = [];
        $parts = explode('-', $lang);

        do
        {
            $path = implode(DIRECTORY_SEPARATOR, $parts);

            if ($files = Sdk::findFile('i18n', $path, null, true))
            {
                $t = [];
                foreach ($files as $file)
                {
                    $t = array_merge($t, Sdk::load($file));
                }
                $table += $t;
            }
            array_pop($parts);
        }
        while ($parts);

        return self::$_cache[$lang] = $table;
    }

}
