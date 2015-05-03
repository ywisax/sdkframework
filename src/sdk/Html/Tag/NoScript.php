<?php

namespace sdk\Html\Tag;

use sdk\Html\Element\BlockElement;
use sdk\Html\Tag;

/**
 * noscript 元素用来定义在脚本未被执行时的替代内容（文本）
 *
 * @package sdk\Html\Tag
 */
class NoScript extends Tag implements BlockElement
{

    protected $_tagName = 'noscript';

}
