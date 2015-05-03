<?php

namespace sdk\Base;

use Exception;
use sdk\Base\Exception\BaseException;
use sdk\Base\Exception\InvalidCallException;
use sdk\Base\Exception\UnknownPropertyException;

/**
 * Yii2中抽取的Object类，进行了部分修改，使其更适应框架本身
 *
 * @package    sdk\Base
 * @category   Base
 * @access     public
 * @author     lzp <25803471@qq.com>
 */
class Object
{

    protected static $_instances = [];

    /**
     * 返回指定实例
     *
     * @static
     * @access public
     * @param  mixed  $args 实例传参，直接传给构造方法
     * @return $this
     */
    public static function instance($args = null)
    {
        if (is_array($args))
        {
            $instanceKey = md5(json_encode($args));
        }
        elseif ($args === null)
        {
            $instanceKey = 'default';
        }
        else
        {
            $instanceKey = (string) $args;
        }

        if ( ! isset(self::$_instances[$instanceKey]))
        {
            $class = self::className();
            self::$_instances[$instanceKey] = is_array($args) ? new $class($args) : new $class;
        }
        return self::$_instances[$instanceKey];
    }

    /**
     * 返回当前类的类名，关键词：__延时加载__
     *
     * @static
     * @access public
     * @return string
     */
    final public static function className()
    {
        return get_called_class();
    }

    /**
     * 构造函数，使用数组传参，直接给成员赋值
     *
     * @access public
     * @param  array $args name-value数组
     */
    public function __construct($args = [])
    {
        if ( ! empty($args))
        {
            foreach ($args as $k => $v)
            {
                $this->{$k} = $v;
            }
        }
        $this->init();
    }

    /**
     * 对象初始化操作，不破坏原有的构造方法
     */
    public function init()
    {
    }

    /**
     * 返回对象属性，实现getter功能
     *
     * @access public
     * @param  string $name 属性名
     * @return mixed 指定的属性值
     * @throws UnknownPropertyException 属性值不存在的话
     * @throws InvalidCallException 属性值只读
     */
    public function __get($name)
    {
        // 默认的getter方法
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter))
        {
            return $this->$getter();
        }
        // 有可能只需要返回布尔值
        elseif (method_exists($this, 'is' . ucfirst($name)))
        {
            $getter = 'is' . ucfirst($name);
            return (bool) $this->$getter();
        }
        elseif (method_exists($this, 'set' . ucfirst($name)))
        {
            throw new InvalidCallException('Getting write-only property: {class}::{name}', [
                '{class}' => get_class($this),
                '{name}'  => $name,
            ]);
        }
        else
        {
            throw new InvalidCallException('Getting unknown property: {class}::{name}', [
                '{class}' => get_class($this),
                '{name}'  => $name,
            ]);
        }
    }

    /**
     * setter功能的实现
     *
     * @access public
     * @param  string $name  属性名
     * @param  mixed  $value 属性值
     * @throws UnknownPropertyException 属性值不存在
     * @throws InvalidCallException 属性值只读
     * @see    __get()
     */
    public function __set($name, $value)
    {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter))
        {
            $this->$setter($value);
        }
        elseif (method_exists($this, 'get' . ucfirst($name)))
        {
            throw new InvalidCallException('Setting read-only property: ' . get_class($this) . '::' . $name);
        }
        else
        {
            throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * 检查setter是否存在
     *
     * @param string $name 属性名
     * @return boolean
     */
    public function __isset($name)
    {
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter))
        {
            return null !== $this->$getter();
        }
        else
        {
            return false;
        }
    }

    /**
     * 注销值
     *
     * @param string $name 属性名
     * @throws InvalidCallException  属性值只读的话
     */
    public function __unset($name)
    {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter))
        {
            $this->$setter(null);
        }
        elseif (method_exists($this, 'get' . ucfirst($name)))
        {
            throw new InvalidCallException('Deleting read-only property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * 将指定的属性转为布尔值
     *
     * @param $property
     * @param $value
     *
     * @throws BaseException
     */
    public function toBoolean($property, $value)
    {
        $trueValues = [true, 1, '1', 'true', 'yes', 'on'];
        $falseValues = [false, 0, '0', 'false', 'no', 'off', ''];

        if (is_string($value))
        {
            $value = strtolower($value);
        }

        $result = null;
        if ($result === null && in_array($value, $trueValues, true))
        {
            $result = true;
        }
        if ($result === null && in_array($value, $falseValues, true))
        {
            $result = false;
        }

        // 强制转换
        try
        {
            $this->$property = (bool) $result;
        }
        catch (Exception $ex)
        {
            throw new BaseException('Property :property is not existed or the value is cast.', [
                ':property' => $property,
            ]);
        }
    }

    /**
     * 转换指定字段数据为整形
     *
     * @param $property
     * @param $value
     *
     * @throws BaseException
     */
    public function toInteger($property, $value)
    {
        $result = 0;

        if (is_integer($value))
        {
            $result = $value;
        }
        if (is_numeric($value) && ($value == (integer) $value))
        {
            $result = (integer) $value;
        }

        try
        {
            $this->$property = (int) $result;
        }
        catch (Exception $e)
        {
            throw new BaseException('Property :property is not existed or the value is cast.', [
                ':property' => $property,
            ]);
        }
    }

    /**
     * 是否存在指定的属性
     *
     * @param  string  $name      属性名
     * @param  boolean $checkVars 是否检查成员变量
     * @return boolean
     * @see canGetProperty()
     * @see canSetProperty()
     */
    public function hasProperty($name, $checkVars = true)
    {
        return $this->canGetProperty($name, $checkVars) || $this->canSetProperty($name, false);
    }

    /**
     * 检查指定的属性是否可读
     *
     * @param  string  $name      属性名
     * @param  boolean $checkVars 是否检查成员变量
     * @return boolean
     * @see canSetProperty()
     */
    public function canGetProperty($name, $checkVars = true)
    {
        return method_exists($this, 'get' . ucfirst($name)) || $checkVars && property_exists($this, $name);
    }

    /**
     * 检查指定的属性是否可写
     *
     * @param string  $name      属性名
     * @param boolean $checkVars 是否检查成员变量
     * @return boolean
     * @see canGetProperty()
     */
    public function canSetProperty($name, $checkVars = true)
    {
        return method_exists($this, 'set' . ucfirst($name)) || $checkVars && property_exists($this, $name);
    }

    /**
     * 检查对象是否有指定方法
     *
     * @param string $name 方法名
     * @return boolean 方法是否定义
     */
    public function hasMethod($name)
    {
        return method_exists($this, $name);
    }
}
