<?php

namespace sdk\Base;

use Noodlehaus\Config as VendorConfig;

/**
 * 配置管理器
 *
 * @package sdk\Base
 */
class Config extends VendorConfig
{

    /**
     * 继承原来的load方法，实现级联系统的配置文件自动加载
     *
     * @param array|string $path
     * @return \Noodlehaus\Config
     */
    public static function load($path)
    {
        if ( ! is_array($path))
        {
            $path = [$path];
        }

        $finalPath = [];
        foreach ($path as $_path)
        {
            foreach (Sdk::includePaths() as $includePath)
            {
                $file = $includePath . 'config' . DIRECTORY_SEPARATOR . $_path;
                if (strpos($file, '*') === false)
                {
                    if (is_file($file))
                    {
                        $finalPath[] = $file;
                    }
                }
                else
                {
                    $finalPath[] = $file;
                }
            }
        }

        return parent::load($finalPath);
    }

}
